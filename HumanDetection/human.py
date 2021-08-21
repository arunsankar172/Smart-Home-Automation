import cv2
import numpy as np

cap = cv2.VideoCapture('http://10.10.1.51:8080/video')

frame_width = int( cap.get(cv2.CAP_PROP_FRAME_WIDTH))
frame_height =int( cap.get( cv2.CAP_PROP_FRAME_HEIGHT))

#fourcc = cv2.VideoWriter_fourcc('X','V','I','D')
#out = cv2.VideoWriter("output.avi", fourcc, 5.0, (1280,720))
obj = mydb.cursor()
ret, frame1 = cap.read()
ret, frame2 = cap.read()
print(frame1.shape)
while cap.isOpened():
    diff = cv2.absdiff(frame1, frame2)
    gray = cv2.cvtColor(diff, cv2.COLOR_BGR2GRAY)
    blur = cv2.GaussianBlur(gray, (5,5), 2)
    _, thresh = cv2.threshold(blur, 30, 265, cv2.THRESH_BINARY)
    dilated = cv2.dilate(thresh, None, iterations=5)
    contours, _ = cv2.findContours(dilated, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)

    for contour in contours:
        (x, y, w, h) = cv2.boundingRect(contour)

	sql = "UPDATE switch SET state = 0 WHERE id = 1 "
	obj.execute(sql)
	mydb.commit()

        if cv2.contourArea(contour) < 1000:
            continue
        cv2.rectangle(frame1, (x, y), (x+w, y+h), (0, 255, 0), 2)
        cv2.putText(frame1, "Status: {}".format('People Detected'), (10, 20), cv2.FONT_HERSHEY_SIMPLEX,
                    1, (0, 0, 255), 3)
    #cv2.drawContours(frame1, contours, -1, (0, 255, 0), 2)

    image = cv2.resize(frame1, (1280,720))
    cv2.imshow("feed", frame1)
    frame1 = frame2
    ret, frame2 = cap.read()

    if cv2.waitKey(40) == 27:
        break

cv2.destroyAllWindows()
cap.release()
##out.release()
