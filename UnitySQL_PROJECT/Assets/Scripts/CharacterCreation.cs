using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;
using UnityEngine.SceneManagement;

public class CharacterCreation : MonoBehaviour
{
    public InputField charName;
    public Dropdown charRace;
    public Dropdown charClass;

    public Button createButton;

    public void CallCreation()
    {
        StartCoroutine(Create());
    }

    IEnumerator Create()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", DBManager.username);
        form.AddField("charName", charName.text);
        form.AddField("charRace", charRace.captionText.text);
        form.AddField("charClass", charClass.captionText.text);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/charCreation.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text == "0")
            {
                Debug.Log("Character created successfully.");
                SceneManager.LoadScene(3);
            }
            else
            {
                Debug.Log("Character creation failed. Error.. " + request.downloadHandler.text);
            }
        }
    }

    public void TestCreate()
    {
        Debug.Log(charName.text);
        Debug.Log(charRace.captionText.text);
        Debug.Log(charClass.captionText.text);
    }
}
