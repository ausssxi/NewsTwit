import mysql.connector

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit')
cur = conn.cursor()

i = 0

cur.execute("SELECT news_id FROM news ORDER BY up DESC, news_id DESC LIMIT 100")
rows1 = cur.fetchall()
cur.execute("DELETE FROM news_new WHERE category = %s", (1,))
conn.commit()
for row1 in rows1:
    news_id = row1[0]
    cur.execute("SELECT COUNT(*) FROM comment_self WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count = row2[0]

    cur.execute("SELECT COUNT(*) FROM comment WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count += row2[0]

    if count > 0:
        cur.execute("INSERT INTO news_new (news_id, count, category) VALUES (%s, %s, %s)", (news_id, count, 1))
        conn.commit()
        i += 1

    if i == 10:
        break

i = 0

cur.execute("SELECT `news_id`, `up` FROM `news` WHERE `news_id` in (SELECT `news_id` FROM news_to_tag WHERE tag_id = 9081975) ORDER BY up DESC LIMIT 60")
rows1 = cur.fetchall()
cur.execute("DELETE FROM news_new WHERE category = %s", (2,))
conn.commit()
for row1 in rows1:
    news_id = row1[0]
    cur.execute("SELECT COUNT(*) FROM comment_self WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count = row2[0]

    cur.execute("SELECT COUNT(*) FROM comment WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count += row2[0]

    if count > 0:
        cur.execute("INSERT INTO news_new (news_id, count, category) VALUES (%s, %s, %s)", (news_id, count, 2))
        conn.commit()
        i += 1

    if i == 10:
        break

i = 0

cur.execute("SELECT `news_id`, `up` FROM `news` WHERE `news_id` in (SELECT `news_id` FROM news_to_tag WHERE tag_id = 9082120) ORDER BY up DESC LIMIT 60")
rows1 = cur.fetchall()
cur.execute("DELETE FROM news_new WHERE category = %s", (3,))
conn.commit()
for row1 in rows1:
    news_id = row1[0]
    cur.execute("SELECT COUNT(*) FROM comment_self WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count = row2[0]

    cur.execute("SELECT COUNT(*) FROM comment WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count += row2[0]

    if count > 0:
        cur.execute("INSERT INTO news_new (news_id, count, category) VALUES (%s, %s, %s)", (news_id, count, 3))
        conn.commit()
        i += 1

    if i == 10:
        break

i = 0

cur.execute("SELECT `news_id`, `up` FROM `news` WHERE `news_id` in (SELECT `news_id` FROM news_to_tag WHERE tag_id = 9081948) ORDER BY up DESC LIMIT 60")
rows1 = cur.fetchall()
cur.execute("DELETE FROM news_new WHERE category = %s", (4,))
conn.commit()
for row1 in rows1:
    news_id = row1[0]
    cur.execute("SELECT COUNT(*) FROM comment_self WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count = row2[0]

    cur.execute("SELECT COUNT(*) FROM comment WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count += row2[0]

    if count > 0:
        cur.execute("INSERT INTO news_new (news_id, count, category) VALUES (%s, %s, %s)", (news_id, count, 4))
        conn.commit()
        i += 1

    if i == 10:
        break

i = 0

cur.execute("SELECT `news_id`, `up` FROM `news` WHERE `news_id` in (SELECT `news_id` FROM news_to_tag WHERE tag_id = 9081963) ORDER BY up DESC LIMIT 60")
rows1 = cur.fetchall()
cur.execute("DELETE FROM news_new WHERE category = %s", (5,))
conn.commit()
for row1 in rows1:
    news_id = row1[0]
    cur.execute("SELECT COUNT(*) FROM comment_self WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count = row2[0]

    cur.execute("SELECT COUNT(*) FROM comment WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count += row2[0]

    if count > 0:
        cur.execute("INSERT INTO news_new (news_id, count, category) VALUES (%s, %s, %s)", (news_id, count, 5))
        conn.commit()
        i += 1

    if i == 10:
        break

i = 0

cur.execute("SELECT `news_id`, `up` FROM `news` WHERE `news_id` in (SELECT `news_id` FROM news_to_tag WHERE tag_id = 9081976) ORDER BY up DESC LIMIT 60")
rows1 = cur.fetchall()
cur.execute("DELETE FROM news_new WHERE category = %s", (6,))
conn.commit()
for row1 in rows1:
    news_id = row1[0]
    cur.execute("SELECT COUNT(*) FROM comment_self WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count = row2[0]

    cur.execute("SELECT COUNT(*) FROM comment WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count += row2[0]

    if count > 0:
        cur.execute("INSERT INTO news_new (news_id, count, category) VALUES (%s, %s, %s)", (news_id, count, 6))
        conn.commit()
        i += 1

    if i == 10:
        break

i = 0

cur.execute("SELECT `news_id`, `up` FROM `news` WHERE `news_id` in (SELECT `news_id` FROM news_to_tag WHERE tag_id = 9081934) ORDER BY up DESC LIMIT 60")
rows1 = cur.fetchall()
cur.execute("DELETE FROM news_new WHERE category = %s", (7,))
conn.commit()
for row1 in rows1:
    news_id = row1[0]
    cur.execute("SELECT COUNT(*) FROM comment_self WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count = row2[0]

    cur.execute("SELECT COUNT(*) FROM comment WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count += row2[0]

    if count > 0:
        cur.execute("INSERT INTO news_new (news_id, count, category) VALUES (%s, %s, %s)", (news_id, count, 7))
        conn.commit()
        i += 1

    if i == 10:
        break

i = 0

cur.execute("SELECT `news_id`, `up` FROM `news` WHERE `news_id` in (SELECT `news_id` FROM news_to_tag WHERE tag_id = 9081943) ORDER BY up DESC LIMIT 60")
rows1 = cur.fetchall()
cur.execute("DELETE FROM news_new WHERE category = %s", (8,))
conn.commit()
for row1 in rows1:
    news_id = row1[0]
    cur.execute("SELECT COUNT(*) FROM comment_self WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count = row2[0]

    cur.execute("SELECT COUNT(*) FROM comment WHERE news_id = %s", (news_id,))
    rows2 = cur.fetchall()
    for row2 in rows2:
        count += row2[0]

    if count > 0:
        cur.execute("INSERT INTO news_new (news_id, count, category) VALUES (%s, %s, %s)", (news_id, count, 8))
        conn.commit()
        i += 1

    if i == 10:
        break

cur.close()
conn.close()
