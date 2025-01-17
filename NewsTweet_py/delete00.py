import mysql.connector
import os
import schedule
import sys

def job():
    sys.exit()

schedule.every(20).minutes.do(job)

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit')
cur = conn.cursor()
try:
    cur.execute("SELECT news_id, image FROM news WHERE up < now() - INTERVAL 1 WEEK")
    rows = cur.fetchall()
    for row in rows:
        cur.execute("SELECT news_id FROM comment WHERE news_id = %s", (row[0], ))
        test = cur.fetchall()
        if not test:
            print(row[0])
            print(row[1])
            try:
                if os.path.exists(str('/var/www/html/app/') + row[1]):
                    os.remove(str('/var/www/html/app/') + row[1])
                if os.path.exists(str('/var/www/html/crop/') + row[1]):
                    os.remove(str('/var/www/html/crop/') + row[1])
                if os.path.exists(str('/var/www/html/image/') + row[1]):
                    os.remove(str('/var/www/html/image/') + row[1])
            except:
                pass
            try:
                cur.execute("DELETE FROM news WHERE news_id = %s", (row[0], ))
                cur.execute("DELETE FROM comment WHERE news_id = %s", (row[0], ))
                cur.execute("DELETE FROM news_to_tag WHERE news_id = %s", (row[0], ))
                conn.commit()
            except:
                pass
except:
    conn.rollback()
    raise
