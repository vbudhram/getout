--Activity_Insert
create or replace
Procedure Activity_Insert (
I_Created_By      In  int, 
I_Name            In  Varchar, 
I_Description     In  Varchar,
O_Id              Out Int,
O_Created_Time    Out Date 

)
As
Begin

Select Activity_Seq_Id.Nextval, Current_Date
Into O_Id, O_Created_Time
From Dual;

Insert Into Activity(
Id,
NAME,
Description,
CREATED_TIME,
Created_By
)

Values(
O_Id,
I_Name,
I_Description,
O_Created_Time,
I_Created_By
);
End;

--Activity_Update
create or replace
Procedure Activity_Update (
I_Id              In Int,
I_Name            In  Varchar, 
I_Description     In  Varchar
)
As
Begin

Update Activity
Set name = i_name,
    description = i_description
Where id = i_id;

End;

--ACTIVITY_GET
create or replace
PROCEDURE ACTIVITY_GET (
  O_result      In Out sys_refcursor,
  I_search      In     Varchar
) 
AS 
BEGIN 
  OPEN O_result 
  FOR   SELECT a.id, a.name, a.description, a.created_time, u.name created_by, e.events,
        CASE WHEN ae.ActiveEvents IS NULL THEN 0 ELSE ae.ActiveEvents END activeEvents,
        s.spots 
        FROM ACTIVITY a
        LEFT JOIN (
          SELECT a.id, count(e.id) events
          FROM ACTIVITY a
          LEFT JOIN EVENT e ON e.activity_id = a.id
          GROUP BY a.id
        ) e on e.id = a.id
        LEFT JOIN (
          SELECT a.id, count(e.id) activeEvents
          FROM ACTIVITY a
          LEFT JOIN EVENT e ON e.activity_id = a.id
          WHERE e.date_time > Current_Date
          GROUP BY a.id
        ) ae on ae.id = a.id
        LEFT JOIN (
          SELECT a.id, count(DISTINCT s.spot_id) Spots
          FROM ACTIVITY a
          LEFT JOIN EVENT e ON e.activity_id = a.id
          LEFT JOIN SPOT s ON s.spot_id = e.spot_id
          GROUP BY a.id
        ) s on s.id = a.id
        LEFT JOIN WEBUSER u on u.id = a.created_by
      WHERE (I_search is null) or (a.name LIKE '%'||I_search||'%')
         OR (I_search is null) or (description LIKE '%'||I_search||'%')
         OR (I_search is null) or (created_time LIKE '%'||I_search||'%')
         OR (I_search is null) or (u.name LIKE '%'||I_search||'%')
         OR (I_search is null) or (e.events LIKE '%'||I_search||'%')
         OR (I_search is null) or (s.spots LIKE '%'||I_search||'%')
         OR (I_search is null) or (activeEvents LIKE '%'||I_search||'%');     
END ACTIVITY_GET;