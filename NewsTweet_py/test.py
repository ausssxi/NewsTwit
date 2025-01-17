import tweepy
import re
import mysql.connector
from collections import Counter
import unicodedata
import string
import datetime
import schedule
import sys

def job():
    sys.exit()

schedule.every(20).minutes.do(job)

consumer_key    = "94eBnzdwG3M41KRyy4HgFi956"
consumer_secret = "thpAstoHZEyPnsMG0ROAoedhR1UDbc5l2jSBQTSVNvKp53yt6c"

auth = tweepy.AppAuthHandler(consumer_key, consumer_secret)
api = tweepy.API(auth)

conn = mysql.connector.connect(user='root', password='password', port = 3306, host='localhost', database='NewsTwit', charset='utf8mb4')
cursor = conn.cursor()
try:
    cursor.execute("SELECT news_id, title, url, site_domain_name, up FROM news ORDER BY up DESC")
    rows = cursor.fetchall()
    try:
        for row in rows:
            if len(row[2]) < 500:
                title1 = r"" + re.escape(row[1]) + r"(.|\s)*#\S+(\s|$)"
                title2 = r"" + re.escape(row[1]) + r"\s(.{0,40})https?://[\w/:%#\$&\?\(\)~\.=\+\-]+"
                title3 = r"" + re.escape(row[1]) + r"(.{0,40})https?://[\w/:%#\$&\?\(\)~\.=\+\-]+"
                title4 = r"" + re.escape(row[1])
                tweets = api.search_tweets(q=row[2], count=100, exclude='retweets', tweet_mode='extended', lang = 'ja', result_type='recent')
                for tweet in tweets:
                    text = re.sub(re.escape(title1), "", tweet.full_text)
                    text = re.sub(re.escape(title2), "", text)
                    text = re.sub(re.escape(title3), "", text)
                    text = re.sub(re.escape(title4), "", text)
                    text = re.sub(r'（(.*?)）', "", text)
                    text = re.sub(r'\((.*?)\)', "", text)
                    text = re.sub(r'【(.*?)】', "", text)
                    text = re.sub(r'\[(.*?)\]', "", text)
                    text = re.sub(r'〔(.*?)〕', "", text)
                    text = re.sub(r'《(.*?)》', "", text)
                    text = re.sub(r'#\S+(\s|$)', "", text)
                    text = re.sub(r'＃\S+(\s|$)', "", text)
                    text = re.sub(r'[12]\d{3}[/\-年](0?[1-9]|1[0-2])[/\-月](0?[1-9]|[12][0-9]|3[01])日?$', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+さんから', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+さん', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+から', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+より', "", text)
                    text = re.sub(r'他[0-9]+件のコメント', "", text)
                    text = re.sub(r'[0-9]+コメント時', "", text)
                    text = re.sub(r'日本経済新聞', "", text)
                    text = re.sub(r'｜(.*)(\s|$)', "", text)
                    text = re.sub(r'\|(.*)(\s|$)', "", text)
                    text = re.sub(r'-\s(.*)(\s|$)', "", text)
                    text = re.sub(r'■(.*)(\s|$)', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+', "", text)
                    text = re.sub(r'https?://[\w/:%#\$&\?\(\)~\.=\+\-]+', "", text)
                    text = re.sub(r'「(.*?)」\sにコメントしました。', "", text)
                    text = re.sub(r'「」\sにコメントしました。', "", text)
                    text = re.sub(r'「(.*?)」にいいね！しました。', "", text)
                    text = re.sub(r'さんの「(.*?)」\sをお気に入りにしました。', "", text)
                    text = re.sub(r'さんの「」\sをお気に入りにしました。', "", text)
                    text = text.replace("【","").replace("】","").replace("＞","").replace("／","").replace(":","").replace("：","").replace("/","").replace("|","").replace(".","").replace("“","").replace("”","")
                    text = text.replace("via","")
                    text = text.replace(row[3],"")
                    lists = row[1].split(" ")
                    for list in lists:
                        text = text.replace(list,"")
                    text = text.lstrip()
                    text = text.rstrip()
                    comp_a = unicodedata.normalize("NFKC", text)
                    table = str.maketrans("", "", string.punctuation  + "「」、。・！")
                    comp_a = comp_a.translate(table)
                    comp_b = unicodedata.normalize("NFKC", row[1])
                    table = str.maketrans("", "", string.punctuation  + "「」、。・！")
                    comp_b = comp_b.translate(table)
                    if text != "" and len(text) > 1 and comp_a not in comp_b:
                        print(tweet.id)


    except:
        sys.exit()
except:
    conn.rollback()

cursor.close()
conn.close()
