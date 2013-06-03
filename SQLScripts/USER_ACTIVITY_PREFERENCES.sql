--User_Activity_Pref_Delete
create or replace
Procedure User_Activity_Pref_Delete (
I_Activity_Id     In  int,
I_WebUser_Id      In  int
)
As
Begin

Delete From user_activity_preferences
Where Activity_Id = I_Activity_Id
  And WebUser_Id = I_WebUser_Id;

End;

--User_Activity_Pref_Save
create or replace
Procedure User_Activity_Pref_Save (
I_Team_Size             In  int, 
I_User_Skill_Level      In  int,
I_Opponent_Skill_Min    In  int,
I_Activity_Id           In  int,
I_WebUser_Id            In  int,
I_Opponent_Skill_Max    In  int
)
As
  c int;
Begin

Select count(*)
Into c
From user_activity_preferences
Where activity_id = i_activity_id
  And webuser_id = i_webuser_id;

IF c = 0 THEN
  Insert Into User_Activity_Preferences(
    Team_Size, 
    User_Skill_Level,
    Opponent_Skill_Min,
    Activity_Id,
    WebUser_Id,
    Opponent_Skill_Max
  )

  Values(
    I_Team_Size, 
    I_User_Skill_Level,
    I_Opponent_Skill_Min,
    I_Activity_Id,
    I_WebUser_Id,
    I_Opponent_Skill_Max
  );
END IF ;

IF c = 1 THEN
  Update user_activity_preferences
  Set Team_Size = I_Team_Size, 
      User_Skill_Level = I_User_Skill_Level,
      Opponent_Skill_Min = I_Opponent_Skill_Min,
      Opponent_Skill_Max = I_Opponent_Skill_Max
  Where Activity_Id = I_Activity_Id
    And WebUser_Id = I_WebUser_Id;
END IF ;

End;


--User_Activity_Pref_Get
create or replace
PROCEDURE User_Activity_Pref_Get (
  O_result       In Out sys_refcursor,
  I_activity_id  In     Int,
  I_webuser_id   In     Int
) 
AS 
BEGIN 
  OPEN O_result 
  FOR   SELECT team_size, user_skill_level, opponent_skill_max, opponent_skill_min
        FROM User_Activity_Preferences 
        WHERE activity_id = I_activity_id
          AND webuser_id = I_webuser_id;
END User_Activity_Pref_Get;