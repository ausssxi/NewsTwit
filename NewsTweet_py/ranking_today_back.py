import mysql.connector
from datetime import datetime, date, timedelta

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit')
cur = conn.cursor()

for counter in range(30):
    i = counter + 1
    today = datetime.today()
    yesterday = today - timedelta(days=i)
    start = datetime.strftime(yesterday, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(yesterday, '%Y-%m-%d 23:59:59')
    yesterday = datetime.strftime(yesterday, '%Y-%m-%d')
    print(yesterday)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9082120) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 3, yesterday))
       conn.commit()

for counter in range(30):
    i = counter + 1
    today = datetime.today()
    yesterday = today - timedelta(days=i)
    start = datetime.strftime(yesterday, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(yesterday, '%Y-%m-%d 23:59:59')
    yesterday = datetime.strftime(yesterday, '%Y-%m-%d')
    print(yesterday)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081948) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 4, yesterday))
       conn.commit()

for counter in range(30):
    i = counter + 1
    today = datetime.today()
    yesterday = today - timedelta(days=i)
    start = datetime.strftime(yesterday, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(yesterday, '%Y-%m-%d 23:59:59')
    yesterday = datetime.strftime(yesterday, '%Y-%m-%d')
    print(yesterday)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081963) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 5, yesterday))
       conn.commit()

for counter in range(30):
    i = counter + 1
    today = datetime.today()
    yesterday = today - timedelta(days=i)
    start = datetime.strftime(yesterday, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(yesterday, '%Y-%m-%d 23:59:59')
    yesterday = datetime.strftime(yesterday, '%Y-%m-%d')
    print(yesterday)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081976) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 6, yesterday))
       conn.commit()

for counter in range(30):
    i = counter + 1
    today = datetime.today()
    yesterday = today - timedelta(days=i)
    start = datetime.strftime(yesterday, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(yesterday, '%Y-%m-%d 23:59:59')
    yesterday = datetime.strftime(yesterday, '%Y-%m-%d')
    print(yesterday)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081934) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 7, yesterday))
       conn.commit()

for counter in range(30):
    i = counter + 1
    today = datetime.today()
    yesterday = today - timedelta(days=i)
    start = datetime.strftime(yesterday, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(yesterday, '%Y-%m-%d 23:59:59')
    yesterday = datetime.strftime(yesterday, '%Y-%m-%d')
    print(yesterday)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081943) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_today (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 8, yesterday))
       conn.commit()
