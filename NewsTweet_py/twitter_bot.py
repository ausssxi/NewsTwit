from credential import CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN_KEY, ACCESS_TOKEN_SECRET
from requests_oauthlib import OAuth1Session
from http import HTTPStatus
import mysql.connector
import sys
import random

def post_tweet(body):
    # 認証処理
    twitter = OAuth1Session(
        CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN_KEY, ACCESS_TOKEN_SECRET
    )
    # ツイート処理
    res = twitter.post("https://api.twitter.com/1.1/statuses/update.json", params={"status": body})
    print(res)

    # エラー処理
    if res.status_code == HTTPStatus.OK:
        print("Successfuly posted")
        cur.close()
        conn.close()
        sys.exit()
    else:
        print(f"Failed: {res.status_code}")

def main():
    conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit')
    cur = conn.cursor()
    try:
        cur.execute("SELECT * FROM `news_count` WHERE `category` = 1");
        rows = cur.fetchall()
        for row in rows:
            cur.execute("SELECT news_id FROM bot WHERE news_id = %s", (row[0],))
            rows1 = cur.fetchall()
            if not rows1:
                cur.execute("SELECT title FROM news WHERE news_id = %s", (row[0],))
                rows2 = cur.fetchall()
                for row2 in rows2:
                    cur.execute("INSERT INTO bot (news_id) VALUES (%s)", (row[0],))
                    conn.commit()
                    a = ['いまツイッターで人気のニュースはこちらです。\n\n' + row2[0], 'いま人気のニュースはこちらです。もうチェックした？\n\n' + row2[0], row2[0] + '\n\nが伸びてるみたい。みんな注目してるんだね！']
                    random.shuffle(a)
                    body = a[0] + " #NewsTwit\nhttps://newstwit.jp/news/" + str(row[0])
                    post_tweet(body)
    except:
        conn.rollback()

    cur.close()
    conn.close()

if __name__ == '__main__':
    main()
