import mysql.connector
import os

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='readot')
cur = conn.cursor()
try:
    cur.execute("SELECT news_id, count(*) AS COUNT FROM comment WHERE up < now() - INTERVAL 1 WEEK GROUP BY news_id LIMIT 2000")
    rows0 = cur.fetchall()
    for row0 in rows0:
        if row0[1] < 10:
            cur.execute("SELECT image FROM news WHERE news_id = %s", (row0[0], ))
            rows1 = cur.fetchall()
            for row1 in rows1:
                print(row0[0])
                try:
                    if os.path.exists(str('/var/www/html/crop/') + row1[0]):
                        os.remove(str('/var/www/html/crop/') + row1[0])
                    if os.path.exists(str('/var/www/html/image/') + row1[0]):
                        os.remove(str('/var/www/html/image/') + row1[0])
                except:
                    pass
            try:
                cur.execute("DELETE FROM news WHERE news_id = %s", (row0[0], ))
                cur.execute("DELETE FROM comment WHERE news_id = %s", (row0[0], ))
                conn.commit()
            except:
                pass

except:
    conn.rollback()
    raise
