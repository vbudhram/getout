--vw_Event
Create View Vw_Event
AS
Select 
E.Id,
E.Date_Time,
E.Duration,
E.Created_On,
E.Average_Skill,
Team_Size,
E.Created_By,
E.Activity_Id,
E.Spot_Id,
To_Char(E.Date_Time, 'Day') As Event_DOW,
To_Char(E.Date_Time, 'Mon DD') As Event_Day,
To_Char(E.Date_Time, 'HH:MI am') As Event_Start_Time,
E.Date_Time + E.Duration/1440 As Event_End_Date_Time,
TO_Char(E.Date_Time + E.Duration/1440, 'HH:MI am') as Event_End_Time,
S.Name as SpotName,
S.Location,
S.City,
S.State,
S.Zip,
A.Name As Activityname,
W.Name as Creator

From Event E
Join Spot S On E.Spot_Id = S.Spot_Id
Join Activity A On E.Activity_id = A.Id
Join Webuser W On E.Created_By = W.Id;


--Event_Insert
create or replace
Procedure Event_Insert (
I_Datetime        In  Date, 
I_Duration        In  Int, 
I_SkillLevel      In  Int, 
I_Teamsize        In  Int, 
I_Creatorid       In  Int, 
I_Activityid      In  Int, 
I_Spotid          In  Int, 
O_Id              Out Int,
O_CreatedOn       Out Date
)
As
Begin

Select Event_Seq_Id.Nextval, Current_Date
Into O_Id, O_CreatedOn
From Dual;


INSERT INTO EVENT(
ID,
DATE_TIME,
DURATION,
CREATED_ON,
AVERAGE_SKILL,
TEAM_SIZE,
CREATED_BY,
ACTIVITY_ID,
Spot_Id)

Values(
O_Id,
I_Datetime,
I_Duration,
O_Createdon,
I_Skilllevel,
I_Teamsize,
I_Creatorid,
I_Activityid,
I_Spotid);

End;

--Event_Update
create or replace
Procedure Event_Update
(
I_Id              in Int,
I_Datetime        In  Date, 
I_Duration        In  Int, 
I_SkillLevel      In  Int, 
I_Teamsize        In  Int
)
As
Begin

Update Event 
Set 
Date_Time = I_Datetime,
Duration = I_Duration,
Average_Skill = I_Skilllevel,
Team_Size = I_Teamsize
where Id = I_Id;

End;

--Event_Delete
create or replace
Procedure Event_Delete(
I_Id              In Int)
As
Begin
Delete From Event
where Id = I_Id;

End;
