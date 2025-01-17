import firebase_admin
from firebase_admin import credentials
from firebase_admin import messaging
import mysql.connector

cred = credentials.Certificate("/var/www/python/serviceAccountKey.json")
firebase_admin.initialize_app(cred)
boby = ""

conn = mysql.connector.connect(user='root', password='password', port = 3306, host='localhost', database='NewsTwit', charset='utf8mb4')
cur = conn.cursor()
try:
    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 6 HOUR GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 2")
    rows1 = cur.fetchall()
    for row1 in rows1:
        cur.execute("SELECT title FROM news WHERE news_id = %s", (row1[0], ))
        rows2 = cur.fetchall()
        for row2 in rows2:
            boby += "▶ " + row2[0] + "\n"
except:
    conn.rollback()

notification = messaging.Notification(
    body = boby,
)
topic='weather'

apns = messaging.APNSConfig(
   payload = messaging.APNSPayload(
       aps = messaging.Aps(badge = 1) #　ここがバックグランド通知に必要な部分
   )
)

message = messaging.Message(
    notification=notification,
    apns=apns,
    topic=topic,
)

# Send a message to the device corresponding to the provided
# registration token.
response = messaging.send(message)
# Response is a message ID string.
print('Successfully sent message:', response)
