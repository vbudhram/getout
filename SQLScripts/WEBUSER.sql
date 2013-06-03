
--WEBUSER_INSERT
create or replace
Procedure Webuser_Insert (
iEmail            In  Varchar, 
Ipassword_Hash    In  Varchar, 
iHash_Salt        In  Varchar, 
iName             In  Varchar, 
iCity             In  Varchar, 
iZip              In  Char, 
iState            In  Char, 
iAvatar           In  Blob, 
iLatitude         In  Number,
iLongitude        In  Number,
oId               Out Int,
oCreated_On       Out Date, 
oLast_Accessed_On Out Date
)
As
Begin

Select Webuser_Seq_Id.Nextval, Current_Date, Current_Date
Into Oid, oCreated_On, oLast_Accessed_On
From Dual;

Insert Into Webuser(
Id,
Email, 
Password_Hash, 
Hash_Salt, 
Name, 
City, 
State, 
Zip, 
Created_On, 
Last_Accessed_On, 
Avatar, 
Location)

Values(
oId,
iEmail, 
iPassword_Hash, 
iHash_Salt, 
iName, 
iCity, 
iState, 
iZip, 
oCreated_On, 
oLast_Accessed_On, 
Iavatar, 
 Sdo_Geometry(2001, 8307, Sdo_Point_Type (iLongitude, iLatitude, Null), Null, Null)
);
End;

--WEBUSER_LOGIN
create or replace
Procedure Webuser_Login (
iEmail            In  Varchar, 
iPassword_Hash    In  Varchar, 
oId               Out Int,
oName             Out Varchar, 
oCity             Out Varchar, 
oZip              Out Char, 
oState            Out Char, 
Oavatar           Out Blob, 
Olatitude         Out Number,
oLongitude        Out Number,
oCreated_On       Out Date, 
oLast_Accessed_On Out Date
)
As
Begin

Select Id, Name, City, State, Zip, Avatar, Created_On, Last_Accessed_On,
W.Location.Sdo_Point.X, W.Location.Sdo_Point.Y
Into Oid, Oname, Ocity, Ostate, Ozip, Oavatar, Ocreated_On, Olast_Accessed_On,
Olongitude, Olatitude
From Webuser W 
where email = iEmail AND Password_Hash = iPassword_Hash;

Update Webuser
Set Last_Accessed_On = (select Current_Date from dual)
Where Id = Oid;

EXCEPTION
When No_Data_Found Then
        null;

End;