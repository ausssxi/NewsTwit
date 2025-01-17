import mysql.connector
from datetime import datetime, date, timedelta

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit')
cur = conn.cursor()

today = datetime.today()
day30 = today - timedelta(days=30)
start = datetime.strftime(today, '%Y-%m-%d 00:00:00')
end = datetime.strftime(today, '%Y-%m-%d 23:59:59')
today = datetime.strftime(today, '%Y-%m-%d')
day30 = datetime.strftime(day30, '%Y-%m-%d')

cur.execute("DELETE FROM ranking_today WHERE date = %s", (today,))
cur.execute("DELETE FROM ranking_today WHERE date = %s", (day30,))
conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
rows = cur.fetchall()
for row in rows:
    cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 1, today))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081975) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
rows = cur.fetchall()
for row in rows:
    cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 2, today))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9082120) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
rows = cur.fetchall()
for row in rows:
    cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 3, today))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081948) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
rows = cur.fetchall()
for row in rows:
    cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 4, today))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081963) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
rows = cur.fetchall()
for row in rows:
    cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 5, today))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081976) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
rows = cur.fetchall()
for row in rows:
    cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 6, today))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081934) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
rows = cur.fetchall()
for row in rows:
    cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 7, today))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081943) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
rows = cur.fetchall()
for row in rows:
    cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 8, today))
    conn.commit()

cur.close()
conn.close()
