from bs4 import BeautifulSoup
import requests
import urllib.parse
import mysql.connector

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit', charset='utf8mb4')
cursor = conn.cursor()

html = requests.get("https://news.yahoo.co.jp/media")
soup = BeautifulSoup(html.text, "html.parser")
for a in soup.find_all("a", class_="sc-bYnzgO kProUK"):
    if a.get_text() != "デビュー":
        media = a.get_text()
        try:
            cursor.execute("INSERT INTO media (media_name) VALUES (%s)", (media, ))
        except:
            pass
conn.commit()
cursor.close()
conn.close()
