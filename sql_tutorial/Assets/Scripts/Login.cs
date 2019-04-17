using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;

public class Login : MonoBehaviour
{
    public InputField nameField;
    public InputField passwordField;

    public Button loginButton;

    public void CallLogin()
    {
        StartCoroutine(LoginProcess());
    }

    IEnumerator LoginProcess()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", nameField.text);
        form.AddField("password", passwordField.text);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/login.php", form))
        {
            yield return request.SendWebRequest();
            if (request.downloadHandler.text == "0")
            {
                //username based on input field
                DBManager.username = nameField.text;

                //retrieve score from php file and store as integer
                UnityEngine.SceneManagement.SceneManager.LoadScene(0);
            }
            else
            {
                Debug.Log("user login failed. error #" + request.downloadHandler.text);
            }
        }
    }


    public void VerifyInput()
    {
        loginButton.interactable = (nameField.text.Length >= 6 && passwordField.text.Length >= 6);
    }
}
