using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public static class DBManager
{
    public static string username;

    public static string characterName;
    public static string characterRace;
    public static string characterClass;
    public static int level;

    public static string currentQuestGiver;
    public static string currentQuestDetails;
    public static bool hasQuest;

    public static string currentZone;

    public static int XP;
    public static int gold;

    public static bool LoggedIn { get { return username != null;  } }

    public static void LogOut()
    {
        username = null;
    }

}
