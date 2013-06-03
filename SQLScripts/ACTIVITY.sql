CREATE OR REPLACE
PROCEDURE FEEDBACK_GETALL(
    iEvent_ID  IN INT,
    oFeedbacks IN OUT sys_refcursor)
AS
BEGIN
  OPEN oFeedbacks FOR 
  SELECT * FROM FEEDBACK,RATING,PICTURE, "COMMENT" co
  WHERE feedback.event_id=iEvent_ID  
  AND feedback.id=rating.feedback_id(+)
  AND feedback.id=picture.feedback_id(+)
  AND feedback.id=co.feedback_id(+)
  order by id;
END;

create or replace
PROCEDURE FEEDBACK_INSERT(
    iCreated_by IN INT,
    iEvent_ID   IN INT,
    iUri        IN VARCHAR,
    iType       IN INT,
    iRating     IN INT,
    iComment    IN VARCHAR,
    oID OUT INT,
    oCreated_on OUT DATE)
AS
BEGIN
SELECT Activity_Seq_Id.Nextval, CURRENT_DATE INTO oID, oCreated_on FROM Dual;
  IF iUri IS NULL AND iRating IS NULL AND iComment IS NULL THEN
    RAISE VALUE_ERROR;
  ELSE
    SELECT Activity_Seq_Id.Nextval, CURRENT_DATE INTO oID, oCreated_on FROM Dual;
    INSERT
    INTO FEEDBACK
      (
        id,
        created_by,
        created_on,
        event_id
      )
      VALUES
      (
        oID,
        iCreated_by,
        oCreated_on,
        iEvent_ID
      );
  END IF;
  IF iUri IS NOT NULL THEN
    INSERT INTO PICTURE
      ( feedback_id, uri
      ) VALUES
      ( oID, iUri
      );
  END IF;
  IF iComment IS NOT NULL THEN
    INSERT INTO "COMMENT"
      ( feedback_id, comment_text
      ) VALUES
      ( oID, iComment
      );
  END IF;
  IF iRating IS NOT NULL THEN
    INSERT INTO RATING
      ( feedback_id, type, value
      ) VALUES
      ( oID, 0, iRating
      );
  END IF;
END;