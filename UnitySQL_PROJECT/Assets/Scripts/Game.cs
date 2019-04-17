using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;
using UnityEngine.Networking;

public class Game : MonoBehaviour
{
    public Text playerDisplay;
    public Text levelDisplay;
    public Text xpDisplay;
    public Text goldDisplay;
    public Text currentQuestDisplay;

    public GameObject NPCBtn;

    public GameObject NPCList;
    public GameObject ZoneList;
    public GameObject QueryOptions;
    public GameObject QueryByName;
    public GameObject QueryByFilter;
    public GameObject QueryBox;

    public Dropdown questDropdown;
    public Dropdown zoneDropdown;

    public Dropdown searchZoneDropdown;
    public Dropdown searchQuestDropdown;
    public Dropdown searchRaceDropdown;
    public Dropdown searchClassDropdown;
    public InputField searchLevelInput;

    public InputField searchNameInput;

    public Text nameResults;
    public Text raceResults;
    public Text classResults;
    public Text levelResults;

    // Start is called before the first frame update
    void Awake()
    {
        if (DBManager.username == null)
        {
            UnityEngine.SceneManagement.SceneManager.LoadScene(0);
        }

        QueryBox.SetActive(false);

        //get player XP and gold
        StartCoroutine(GetMoreCharData());
        StartCoroutine(GetNPCs());
        StartCoroutine(GetZones());
    }

    private void Update()
    {
        if (DBManager.hasQuest == true)
        {
            NPCBtn.SetActive(false);
        }
    }

    IEnumerator GetMoreCharData()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", DBManager.username);
        form.AddField("ch_name", DBManager.characterName);
        form.AddField("zone", DBManager.currentZone);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/characterStats.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text[0] == '0')
            {
                Debug.Log("Character data retrieved.");
                string[] statsResults = request.downloadHandler.text.Split('\t');
                DBManager.XP = int.Parse(statsResults[1]);
                DBManager.gold = int.Parse(statsResults[2]);
                if(statsResults[3] != "none")
                {
                    DBManager.currentQuestDetails = GetQuestDetails(int.Parse(statsResults[3]));
                    DBManager.hasQuest = true;
                }
                else
                {
                    DBManager.currentQuestDetails = "none";
                    DBManager.hasQuest = false;
                }
                playerDisplay.text = "Character: " + DBManager.characterName;
                levelDisplay.text = "Level: " + DBManager.level;
                xpDisplay.text = "XP: " + DBManager.XP;
                goldDisplay.text = "Gold: " + DBManager.gold;
                currentQuestDisplay.text = "Current Quest: " + DBManager.currentQuestDetails;
            }
            else
            {
                Debug.Log("Character data retrieval failed. " + request.downloadHandler.text);
            }
        }
    }

    IEnumerator GetNPCs()
    {
        WWWForm form = new WWWForm();
        form.AddField("zone", DBManager.currentZone);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/questOptions.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text[0] == '0')
            {
                Debug.Log("Quest data retrieved.");
                string[] zoneResults = request.downloadHandler.text.Split('\t');

                int numNPC = int.Parse(zoneResults[1]);
                List<string> questOptions = new List<string>();

                for (int i = 2; i <= (numNPC * 2); i += 2)
                {
                    string questOption = zoneResults[i];
                    //get quest details and add
                    string questDetails = GetQuestDetails(int.Parse(zoneResults[i + 1]));
                    questOption += ": " + questDetails;
                    questOptions.Add(questOption);
                }

                questDropdown.AddOptions(questOptions);
            }
            else
            {
                Debug.Log("Quest data retrieval failed. " + request.downloadHandler.text);
            }
        }
    }

    IEnumerator GetZones()
    {
        WWWForm form = new WWWForm();
        form.AddField("zone", DBManager.currentZone);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/zoneOptions.php", form))
        {
            yield return request.SendWebRequest();

            Debug.Log(request.downloadHandler.text);
            if (request.downloadHandler.text[0] == '0')
            {
                Debug.Log("Zone data retrieved.");
                string[] zoneResults = request.downloadHandler.text.Split('\t');

                int numNPC = int.Parse(zoneResults[1]);
                List<string> zoneOptions = new List<string>();

                for (int i = 2; i <= numNPC + 1; i++)
                {
                    Debug.Log(zoneResults[i]);
                    string zoneOption = zoneResults[i];
                    
                    zoneOptions.Add(zoneOption);
                }

                zoneDropdown.AddOptions(zoneOptions);
            }
            else
            {
                Debug.Log("Zone data retrieval failed. " + request.downloadHandler.text);
            }
        }
    }

    public string GetQuestDetails(int qID)
    {
        switch(qID)
        {
            case 1:
                return "Save the princess!";
            case 2:
                return "Kill 10 Boars.";
            case 3:
                return "Attack the bandits.";
            case 4:
                return "Retrieve the jewel";
            default:
                return "Here is a simple quest for you";
        }
    }

    //insert current player data into DB
    IEnumerator SavePlayerData()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", DBManager.username);
        form.AddField("ch_name", DBManager.characterName);
        form.AddField("level", DBManager.level);
        form.AddField("xp", DBManager.XP);
        form.AddField("gold", DBManager.gold);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/savedata.php", form))
        {
            yield return request.SendWebRequest();
            if (request.downloadHandler.text == "0")
            {
                Debug.Log("Game Saved.");
                playerDisplay.text = "Character: " + DBManager.characterName;
                levelDisplay.text = "Level: " + DBManager.level;
                xpDisplay.text = "XP: " + DBManager.XP;
                goldDisplay.text = "Gold: " + DBManager.gold;
            }
            else
            {
                Debug.Log("Save failed. Error: " + request.downloadHandler.text);
            }
        }
    }

    IEnumerator updateQuestRelation()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", DBManager.username);
        form.AddField("ch_name", DBManager.characterName);
        form.AddField("quest_giver", DBManager.currentQuestGiver);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/questData.php", form))
        {
            yield return request.SendWebRequest();
            if (request.downloadHandler.text == "0")
            {
                Debug.Log("Quest Saved in DB.");
                currentQuestDisplay.text = "Current Quest: " + DBManager.currentQuestDetails;
            }
            else
            {
                Debug.Log("Save failed. Error: " + request.downloadHandler.text);
            }
        }
    }

    IEnumerator queryByFilter(Query q)
    {
        WWWForm form = new WWWForm();
        form.AddField("zone", q.zone);
        form.AddField("questID", q.questID);
        form.AddField("race", q.race);
        form.AddField("class", q.characterClass);
        form.AddField("level", q.level);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/filterQuery.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text[0] == '0')
            {
                //clear text
                nameResults.text = "";
                raceResults.text = "";
                classResults.text = "";
                levelResults.text = "";

                string[] characterResults = request.downloadHandler.text.Split('\t');
                int numCharacters = int.Parse(characterResults[1]);

                QueryBox.SetActive(true);
                nameResults.text += "Name" + "\n";
                raceResults.text += "Race" + "\n";
                classResults.text += "Class" + "\n";
                levelResults.text += "Level" + "\n";


                if (numCharacters == 0)
                {
                    nameResults.text += "0 Results";
                }
                else
                {
                    for (int i = 2; i < (numCharacters * 4); i += 4)
                    {
                        nameResults.text += characterResults[i] + "\n";
                        raceResults.text += characterResults[i + 1] + "\n";
                        classResults.text += characterResults[i + 2] + "\n";
                        levelResults.text += characterResults[i + 3] + "\n";
                    }
                }
            }
            else
            {
                Debug.Log("Query failed. Error: " + request.downloadHandler.text);
            }


        }
    }

    IEnumerator QueryName(Query q)
    {
        WWWForm form = new WWWForm();
        form.AddField("name", q.characterName);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/nameQuery.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text[0] == '0')
            {
                string[] qResults = request.downloadHandler.text.Split('\t');

                //clear text
                nameResults.text = "";
                raceResults.text = "";
                classResults.text = "";
                levelResults.text = "";

                //fill text box
                QueryBox.SetActive(true);
                nameResults.text += "Name" + "\n";
                raceResults.text += "Race" + "\n";
                classResults.text += "Class" + "\n";
                levelResults.text += "Level" + "\n";

                if (qResults[1] == "0")
                {
                    nameResults.text += "0 Results";
                }
                else
                {
                    nameResults.text += qResults[2];
                    raceResults.text += qResults[3];
                    classResults.text += qResults[4];
                    levelResults.text += qResults[5];
                }

            }
            else
            {
                Debug.Log("Query failed. Error: " + request.downloadHandler.text);
            }
        }
    }

    IEnumerator UpdateZone()
    {
        WWWForm form = new WWWForm();
        form.AddField("ch_name", DBManager.characterName);
        form.AddField("zone", DBManager.currentZone);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/updateZone.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text == "0")
            {
                Debug.Log("Zone changed");
            }
            else
            {
                Debug.Log("Save failed. Error: " + request.downloadHandler.text);
            }
        }

    }

    public void KillMonster()
    {
        DBManager.XP += 25;

        //level up check 
        if (DBManager.XP / DBManager.level >= 100)
        {
            DBManager.level++;
        }

        int loot = (int)(Random.Range(1.0f, 5.0f) * 2.0f);
        DBManager.gold += loot;

        StartCoroutine(SavePlayerData()); //start data update process
    }

    public void GetQuestList()
    {

        NPCList.SetActive(!NPCList.activeInHierarchy);
    }

    public void SelectQuest()
    {
        string[] questInfo = new string[] { };
        questInfo = questDropdown.captionText.text.Split(':');
        DBManager.currentQuestGiver = questInfo[0];
        DBManager.currentQuestDetails = questInfo[1];
        DBManager.hasQuest = true;

        NPCList.SetActive(false);

        StartCoroutine(updateQuestRelation());
    }

    public void GetZoneList()
    {
        ZoneList.SetActive(!ZoneList.activeInHierarchy);
    }

    public void SelectZone()
    {
        DBManager.currentZone = zoneDropdown.captionText.text;

        StartCoroutine(UpdateZone());
        
        if(SceneManager.GetActiveScene().buildIndex == 5)
        {
            SceneManager.LoadScene(6);
        }
        else
        {
            SceneManager.LoadScene(5);
        }

    }

    public void GetQueryUI()
    {
        QueryOptions.SetActive(!QueryOptions.activeInHierarchy);

        if(!QueryOptions.activeInHierarchy)
        {
            QueryByName.SetActive(false);
            QueryByFilter.SetActive(false);
        }
    }

    public void GetFilterQuery()
    {
        QueryByName.SetActive(false);
        QueryByFilter.SetActive(!QueryByFilter.activeInHierarchy);
    }

    public void GetNameQuery()
    {
        QueryByFilter.SetActive(false);
        QueryByName.SetActive(!QueryByName.activeInHierarchy);
    }


    public void SearchByFilter()
    {
        Query filterQuery = new Query();
        filterQuery.zone = searchZoneDropdown.captionText.text;

        if(searchQuestDropdown.captionText.text != "N/A")
        {
            string[] quest = searchQuestDropdown.captionText.text.Split(null);
            filterQuery.questID = int.Parse(quest[0]);
        }
        else
        {
            filterQuery.questID = 0;
        }

        filterQuery.race = searchRaceDropdown.captionText.text;
        filterQuery.characterClass = searchClassDropdown.captionText.text;

        if (!(searchLevelInput.text == ""))
        {
            filterQuery.level = int.Parse(searchLevelInput.text);
        }

        StartCoroutine(queryByFilter(filterQuery));
    }

    public void SearchByName()
    {
        Query nameQuery = new Query();

        nameQuery.characterName = searchNameInput.text;

        StartCoroutine(QueryName(nameQuery));
    }

    public void CloseQuery()
    {
        QueryBox.SetActive(false);
    }

    public void ExitGame()
    {
        StartCoroutine(SavePlayerData());
        DBManager.hasQuest = false;

        SceneManager.LoadScene(0);
    }



}
