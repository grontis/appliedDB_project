using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.Networking;
using UnityEngine.UI;


public class CharacterSelection : MonoBehaviour
{
    public Dropdown charDropdown;
    public Button PlayGameBtn;

    void Awake()
    {
        charDropdown.ClearOptions();
        StartCoroutine(GetCharacters());
    }

    IEnumerator GetCharacters()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", DBManager.username);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/charSelection.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text[0] == '0')
            {
                charDropdown.ClearOptions();
                Debug.Log("Characters Retrieved successfully.");

                //parse input of resulting query into array
                string[] characterResults = request.downloadHandler.text.Split('\t');

                //the number of characters the current user has attached to their account. 
                int numCharacters = int.Parse(characterResults[1]);

                //if player does not have any characters, cannot enter game. 
                if (numCharacters == 0)
                {
                    PlayGameBtn.interactable = false;
                }
                else
                {
                    PlayGameBtn.interactable = true;
                }

                List<string> characterOptions = new List<string>();

                for (int i = 2; i <= (numCharacters * 4) - 2; i += 4)
                {
                    string characterOption = characterResults[i] + " " + characterResults[i + 1] + " " + characterResults[i + 2] + " "
                                            + characterResults[i + 3];
                    characterOptions.Add(characterOption);
                }

                charDropdown.AddOptions(characterOptions);
            }
            else
            {
                Debug.Log("Save failed. Error: " + request.downloadHandler.text);
            }
        }
    }

    IEnumerator characterRemoval(string c)
    {
        WWWForm form = new WWWForm();
        form.AddField("ch_name", c);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/charRemoval.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text == "0")
            {
                Debug.Log("Character removed");
            }
            else
            {
                Debug.Log("Remove failed. Error: " + request.downloadHandler.text);
            }
        }

    }

    public void GoToCreation()
    {
        SceneManager.LoadScene(4);
    }

    public void GoToGame()
    {
        string[] characterInfo = new string[] { };
        characterInfo = charDropdown.captionText.text.Split(null);

        DBManager.characterName = characterInfo[0];
        Debug.Log(DBManager.characterName);

        DBManager.characterRace = characterInfo[1];
        Debug.Log(DBManager.characterRace);

        DBManager.characterClass = characterInfo[2];
        Debug.Log(DBManager.characterClass);

        DBManager.level = int.Parse(characterInfo[3]);
        Debug.Log(DBManager.level);

        DBManager.currentZone = "Verdant Forest";

        SceneManager.LoadScene(5);
    }

    public void DeleteCharacter()
    {
        string[] charInfo = charDropdown.captionText.text.Split(null);
        string deleteChar = charInfo[0];

        StartCoroutine(characterRemoval(deleteChar));
        StartCoroutine(GetCharacters());
    }
}
