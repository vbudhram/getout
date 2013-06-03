create or replace
PROCEDURE SPOT_GET(
    I_id      IN  VARCHAR,
    spots         IN OUT sys_refcursor )
AS
BEGIN
  OPEN spots FOR SELECT spot_id,s.Location.Sdo_Point.y,s.Location.Sdo_Point.x, name,city,zip,state,street_address FROM SPOT s 
  WHERE s.spot_id = I_id;
  
END;

create or replace
PROCEDURE Spot_Get_Withindistance(
    I_Search   IN VARCHAR,
    I_Distance IN INT,
    iLatitude  IN NUMBER,
    iLongitude IN NUMBER,
    spots      IN OUT sys_refcursor )
AS
BEGIN
  OPEN spots FOR 
  SELECT spot_id,s.Location.Sdo_Point.y,s.Location.Sdo_Point.x, name,city,zip,state,street_address 
  FROM SPOT s 
  WHERE (UPPER(s.city) LIKE UPPER('%'||I_search||'%')
    OR UPPER(s.name) LIKE UPPER('%'||I_search||'%')
    OR UPPER(s.street_address) LIKE UPPER('%'||I_search||'%')
    OR UPPER(s.state) LIKE UPPER('%'||I_search||'%')
    OR UPPER(s.zip) LIKE UPPER('%'||I_search||'%'))
    AND Sdo_Geom.Within_Distance(Sdo_Geometry(2001, 8307, Sdo_Point_Type (iLongitude, iLatitude, Null), Null, Null), I_Distance, s.Location, 10, 'unit=MILE') = 'TRUE'
    order by spot_id;
END;

create or replace
PROCEDURE SPOT_INSERT(
    iName           IN VARCHAR,
    iCity           IN VARCHAR,
    iZip            IN VARCHAR,
    iState          IN VARCHAR,
    iLat            IN NUMBER,
    iLon            IN NUMBER,
    iStreet_Address IN VARCHAR,
    iCreated_By     IN VARCHAR,
    oCreated_On OUT DATE,
    oId OUT INT )
AS
BEGIN
  SELECT spot_seq_id.nextval,CURRENT_DATE INTO oId, oCreated_On FROM dual;
  INSERT
  INTO SPOT
    (
      spot_id,
      location,
      name,
      city,
      zip,
      state,
      street_address,
      created_on,
      created_by
    )
    VALUES
    (
      Oid,
      Sdo_Geometry(2001, 8307, Sdo_Point_Type (iLon, iLat, NULL), NULL, NULL),
      iName,
      iCity,
      iZip,
      iState,
      iStreet_Address,
      oCreated_On,
      iCreated_By
    );
EXCEPTION
WHEN OTHERS THEN
  NULL;
END SPOT_INSERT;

create or replace
PROCEDURE SPOT_DELETE(
    deleteId      IN  VARCHAR)
AS
BEGIN
  /*
    Need to do some error checking here, which spots can be delete and which cant
  */
  DELETE FROM SPOT WHERE SPOT.SPOT_ID = deleteId;
END SPOT_DELETE;