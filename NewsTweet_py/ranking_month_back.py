import mysql.connector
from datetime import datetime, date, timedelta
from dateutil.relativedelta import relativedelta

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit')
cur = conn.cursor()

for counter in range(12):
    i = counter + 1
    today = datetime.today()
    month12 = today - relativedelta(months=i)
    first_day = month12.replace(day=1)
    last_day = (month12 + relativedelta(months=1)).replace(day=1) - timedelta(days=1)
    start = datetime.strftime(first_day, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(last_day, '%Y-%m-%d 23:59:59')
    month12 = datetime.strftime(month12, '%Y%m')
    print(start)
    print(end)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_month (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 1, month12))
       conn.commit()

for counter in range(12):
    i = counter + 1
    today = datetime.today()
    month12 = today - relativedelta(months=i)
    first_day = month12.replace(day=1)
    last_day = (month12 + relativedelta(months=1)).replace(day=1) - timedelta(days=1)
    start = datetime.strftime(first_day, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(last_day, '%Y-%m-%d 23:59:59')
    month12 = datetime.strftime(month12, '%Y%m')
    print(start)
    print(end)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081975) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_month (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 2, month12))
       conn.commit()

for counter in range(12):
    i = counter + 1
    today = datetime.today()
    month12 = today - relativedelta(months=i)
    first_day = month12.replace(day=1)
    last_day = (month12 + relativedelta(months=1)).replace(day=1) - timedelta(days=1)
    start = datetime.strftime(first_day, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(last_day, '%Y-%m-%d 23:59:59')
    month12 = datetime.strftime(month12, '%Y%m')
    print(start)
    print(end)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9082120) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_month (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 3, month12))
       conn.commit()

for counter in range(12):
    i = counter + 1
    today = datetime.today()
    month12 = today - relativedelta(months=i)
    first_day = month12.replace(day=1)
    last_day = (month12 + relativedelta(months=1)).replace(day=1) - timedelta(days=1)
    start = datetime.strftime(first_day, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(last_day, '%Y-%m-%d 23:59:59')
    month12 = datetime.strftime(month12, '%Y%m')
    print(start)
    print(end)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081948) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_month (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 4, month12))
       conn.commit()

for counter in range(12):
    i = counter + 1
    today = datetime.today()
    month12 = today - relativedelta(months=i)
    first_day = month12.replace(day=1)
    last_day = (month12 + relativedelta(months=1)).replace(day=1) - timedelta(days=1)
    start = datetime.strftime(first_day, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(last_day, '%Y-%m-%d 23:59:59')
    month12 = datetime.strftime(month12, '%Y%m')
    print(start)
    print(end)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081963) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_month (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 5, month12))
       conn.commit()

for counter in range(12):
    i = counter + 1
    today = datetime.today()
    month12 = today - relativedelta(months=i)
    first_day = month12.replace(day=1)
    last_day = (month12 + relativedelta(months=1)).replace(day=1) - timedelta(days=1)
    start = datetime.strftime(first_day, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(last_day, '%Y-%m-%d 23:59:59')
    month12 = datetime.strftime(month12, '%Y%m')
    print(start)
    print(end)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081976) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_month (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 6, month12))
       conn.commit()

for counter in range(12):
    i = counter + 1
    today = datetime.today()
    month12 = today - relativedelta(months=i)
    first_day = month12.replace(day=1)
    last_day = (month12 + relativedelta(months=1)).replace(day=1) - timedelta(days=1)
    start = datetime.strftime(first_day, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(last_day, '%Y-%m-%d 23:59:59')
    month12 = datetime.strftime(month12, '%Y%m')
    print(start)
    print(end)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081934) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_month (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 7, month12))
       conn.commit()

for counter in range(12):
    i = counter + 1
    today = datetime.today()
    month12 = today - relativedelta(months=i)
    first_day = month12.replace(day=1)
    last_day = (month12 + relativedelta(months=1)).replace(day=1) - timedelta(days=1)
    start = datetime.strftime(first_day, '%Y-%m-%d 00:00:00')
    end = datetime.strftime(last_day, '%Y-%m-%d 23:59:59')
    month12 = datetime.strftime(month12, '%Y%m')
    print(start)
    print(end)

    cur.execute("SELECT `news_id`, count(*) AS COUNT FROM comment WHERE `up` BETWEEN %s AND %s AND `news_id` in (SELECT `news_id` FROM news_to_tag WHERE `tag_id` = 9081943) GROUP BY `news_id` ORDER BY COUNT DESC, news_id DESC LIMIT 20", (start, end))
    rows = cur.fetchall()
    for row in rows:
       cur.execute("INSERT INTO ranking_month (news_id, count, category, date) VALUES (%s, %s, %s, %s)", (row[0], row[1], 8, month12))
       conn.commit()

cur.close()
conn.close()
