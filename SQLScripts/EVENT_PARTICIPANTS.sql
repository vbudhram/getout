--Event_Participants_Delete
create or replace
Procedure Event_Participants_Delete (
I_User_Id             In  int, 
I_Event_Id            In  int
)
As
Begin

Delete From Event_Participants
Where user_id = I_User_Id
  and event_id = I_Event_Id;

End;

--Event_Participants_Insert
create or replace
Procedure Event_Participants_Insert (
I_User_Id             In  int, 
I_Event_Id            In  int, 
I_Participation_Type  In  int
)
As
Begin

Insert Into Event_Participants(
user_id,
event_id,
participation_type
)

Values(
I_User_Id,
I_Event_Id,
I_Participation_Type
);
End;

--Event_Participants_Update
create or replace
Procedure Event_Participants_Update (
I_User_Id             In  int, 
I_Event_Id            In  int, 
I_Participation_Type  In  int
)
As
Begin

Update Event_Participants
Set participation_type = I_Participation_Type
Where user_id = I_User_Id
  and event_id = I_Event_Id;

End;