import firebase_admin
from firebase_admin import credentials
from firebase_admin import messaging

cred = credentials.Certificate("/var/www/python/serviceAccountKey.json")
firebase_admin.initialize_app(cred)

notification = messaging.Notification(
    title = 'test server',
    body = 'test server message',
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
