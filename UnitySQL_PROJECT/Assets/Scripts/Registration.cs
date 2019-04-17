using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;


public class Registration : MonoBehaviour
{
    public InputField nameField;
    public InputField passwordField;
    public InputField emailField;

    public Button submitButton;

    public void CallRegister()
    {
        StartCoroutine(Register());
    }

    IEnumerator Register()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", nameField.text);
        form.AddField("password", passwordField.text);
        form.AddField("email", emailField.text);

        using (UnityWebRequest request = UnityWebRequest.Post("http://localhost/unitySQL_project/register.php", form))
        {
            yield return request.SendWebRequest();

            if (request.downloadHandler.text == "0")
            {
                Debug.Log("User created successfully.");
                UnityEngine.SceneManagement.SceneManager.LoadScene(0);
            }
            else
            {
                Debug.Log("User creation failed. Error # " + request.downloadHandler.text);
            }
        }
    }

    public void VerifyInput()
    {
        submitButton.interactable = (nameField.text.Length >= 6 && passwordField.text.Length >= 6);
    }
}
