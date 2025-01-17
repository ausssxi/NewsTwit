import mysql.connector

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit')
cur = conn.cursor()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 9 HOUR GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 100")
rows = cur.fetchall()
cur.execute("DELETE FROM news_count WHERE category = %s", (1,))
conn.commit()
for row in rows:
    cur.execute("INSERT INTO news_count (news_id, count, category) VALUES (%s, %s, %s)", (row[0], row[1], 1))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 18 HOUR AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081975) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 60")
rows = cur.fetchall()
cur.execute("DELETE FROM news_count WHERE category = %s", (2,))
conn.commit()
for row in rows:
    cur.execute("INSERT INTO news_count (news_id, count, category) VALUES (%s, %s, %s)", (row[0], row[1], 2))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 18 HOUR AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9082120) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 60")
rows = cur.fetchall()
cur.execute("DELETE FROM news_count WHERE category = %s", (3,))
conn.commit()
for row in rows:
    cur.execute("INSERT INTO news_count (news_id, count, category) VALUES (%s, %s, %s)", (row[0], row[1], 3))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 18 HOUR AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081948) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 60")
rows = cur.fetchall()
cur.execute("DELETE FROM news_count WHERE category = %s", (4,))
conn.commit()
for row in rows:
    cur.execute("INSERT INTO news_count (news_id, count, category) VALUES (%s, %s, %s)", (row[0], row[1], 4))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 18 HOUR AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081963) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 60")
rows = cur.fetchall()
cur.execute("DELETE FROM news_count WHERE category = %s", (5,))
conn.commit()
for row in rows:
    cur.execute("INSERT INTO news_count (news_id, count, category) VALUES (%s, %s, %s)", (row[0], row[1], 5))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 18 HOUR AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081976) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 60")
rows = cur.fetchall()
cur.execute("DELETE FROM news_count WHERE category = %s", (6,))
conn.commit()
for row in rows:
    cur.execute("INSERT INTO news_count (news_id, count, category) VALUES (%s, %s, %s)", (row[0], row[1], 6))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 18 HOUR AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081934) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 60")
rows = cur.fetchall()
cur.execute("DELETE FROM news_count WHERE category = %s", (7,))
conn.commit()
for row in rows:
    cur.execute("INSERT INTO news_count (news_id, count, category) VALUES (%s, %s, %s)", (row[0], row[1], 7))
    conn.commit()

cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` >= now() - INTERVAL 18 HOUR AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081943) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 60")
rows = cur.fetchall()
cur.execute("DELETE FROM news_count WHERE category = %s", (8,))
conn.commit()
for row in rows:
    cur.execute("INSERT INTO news_count (news_id, count, category) VALUES (%s, %s, %s)", (row[0], row[1], 8))
    conn.commit()

cur.close()
conn.close()
