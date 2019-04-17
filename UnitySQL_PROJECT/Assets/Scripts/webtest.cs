using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;

public class webtest : MonoBehaviour
{

    // Start is called before the first frame update
    IEnumerator Start()
    {
        UnityWebRequest request = UnityWebRequest.Get("http://localhost/unitySQL_tutorial/webtest.php");

        yield return request.SendWebRequest();
        string[] webResults = request.downloadHandler.text.Split('\t');

        Debug.Log(webResults[0]);

        int webNumber = int.Parse(webResults[1]);
        Debug.Log(webNumber - 1);
    }

}
