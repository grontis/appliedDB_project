using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;

public class MainMenu : MonoBehaviour
{
    public Text playerDisplay;

    public Button registerButton;
    public Button loginButton;
    public Button playButton;

    private void Start()
    {
        if(DBManager.LoggedIn)
        {
            playerDisplay.text = "Current user: " + DBManager.username;
        }
        registerButton.interactable = !DBManager.LoggedIn;
        loginButton.interactable = !DBManager.LoggedIn;
        playButton.interactable = DBManager.LoggedIn;
    }

    public void GoToRegister()
    {
        SceneManager.LoadScene(1);
    }

    public void GoToLogin()
    {
        SceneManager.LoadScene(2);
    }

    public void GoToCharSelection()
    {
        SceneManager.LoadScene(3);
    }
}
