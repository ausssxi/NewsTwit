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
    cur.execute("SELECT news_id, count(*) AS COUNT FROM comment WHERE up < now() - INTERVAL 40 DAY GROUP BY news_id")
    rows0 = cur.fetchall()
    for row0 in rows0:
        cur.execute("SELECT news_id FROM comment_self WHERE news_id = %s", (row0[0], ))
        self = cur.fetchall()
        if not self:
            if row0[1] < 10:
                cur.execute("SELECT image FROM news WHERE news_id = %s", (row0[0], ))
                rows1 = cur.fetchall()
                for row1 in rows1:
                    print(row0[0])
                    try:
                        if os.path.exists(str('/var/www/html/app/') + row1[0]):
                            os.remove(str('/var/www/html/app/') + row1[0])
                        if os.path.exists(str('/var/www/html/crop/') + row1[0]):
                            os.remove(str('/var/www/html/crop/') + row1[0])
                        if os.path.exists(str('/var/www/html/image/') + row1[0]):
                            os.remove(str('/var/www/html/image/') + row1[0])
                    except:
                        pass
                try:
                    cur.execute("DELETE FROM news WHERE news_id = %s", (row0[0], ))
                    cur.execute("DELETE FROM comment WHERE news_id = %s", (row0[0], ))
                    cur.execute("DELETE FROM news_to_tag WHERE news_id = %s", (row0[0], ))
                    conn.commit()
                except:
                    pass

except:
    conn.rollback()
    raise
