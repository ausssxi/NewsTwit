import tweepy
import mysql.connector
from tweepy import OAuthHandler

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit', charset='utf8mb4')
cursor = conn.cursor()

CONSUMER_KEY = 'OACTaC3sLUogSZ62SkyMwgF3m'
CONSUMER_SECRET = 'pgj2UkPGOoWHRCtjOR7DxQBwIK1XItDq2Qo1w2brwu6NDHn716'
ACCESS_KEY = '1387344957229264899-sfAeiMkyBF3n19KMheTAcXHS9KsVfk'
ACCESS_SECRET = 'QCiTNzRgbbkg4wCyVrjx3GfpwBRtyNbTDtYcNuCwYyZPw'

auth = OAuthHandler(CONSUMER_KEY,CONSUMER_SECRET)
api = tweepy.API(auth)

auth.set_access_token(ACCESS_KEY, ACCESS_SECRET)
cursor.execute("SELECT screen FROM comment WHERE `twitter_id` = 0 ORDER BY UP DESC LIMIT 900")
rows = cursor.fetchall()
for row in rows:
    try:
        user = api.get_user(row[0])
        cursor.execute('UPDATE comment SET twitter_id = %s WHERE screen = %s', (user.id, row[0]))
        conn.commit()
        print(user.id)
        print(row[0])
    except tweepy.error.TweepError as e:
        print(e)
        if e.reason == "[{'code': 50, 'message': 'User not found.'}]" or "[{'code': 63, 'message': 'User has been suspended.'}]":
            cursor.execute('DELETE FROM comment WHERE screen = %s', (row[0], ))
            conn.commit()
        else:
            break
cursor.close()
conn.close()
