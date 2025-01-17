# coding:utf-8

import feedparser
import re
from urllib.parse import urlparse
import uuid
import mysql.connector
import requests
from PIL import Image
from bs4 import BeautifulSoup
import datetime
import urllib.parse
import schedule
import sys
import os

def job():
    sys.exit()

schedule.every(20).minutes.do(job)

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit', charset='utf8mb4')
cursor = conn.cursor()

def hatena_parser(rss, site_name):
    feed = feedparser.parse(rss)
    for entry in feed['entries']:
        title = entry['title']
        title = re.sub(r'(.*)Twitter:', "", title)
        title = re.sub(r'https?://[\w/:%#\$&\?\(\)~\.=\+\-]+', "", title)
        title = re.sub(r'（(.*?)）', "", title)
        title = re.sub(r'\((.*?)\)', "", title)
        title = re.sub(r'【(.*?)】', "", title)
        title = re.sub(r'\[(.*?)\]', "", title)
        title = re.sub(r'〔(.*?)〕', "", title)
        title = re.sub(r'〈(.*?)〉', "", title)
        title = re.sub(r'《(.*?)》', "", title)
        if site_name is not None:
            title = title.replace('-' + site_name, '').replace('|' + site_name, '').replace('｜' + site_name, '').replace('：' + site_name, '').replace(':' + site_name, '').replace('／' + site_name, '').replace('/' + site_name, '').replace('- ' + site_name, '').replace('| ' + site_name, '').replace('｜ ' + site_name, '').replace('： ' + site_name, '').replace(': ' + site_name, '').replace('／ ' + site_name, '').replace('/ ' + site_name, '')
        else:
            title = re.sub(r'：(.*)', "", title)
            title = re.sub(r':(.*)', "", title)
            title = re.sub(r'／(.*)', "", title)
            title = re.sub(r'\/(.*)', "", title)
        title = re.sub(r'-(\s)+(.*)', "", title)
        title = re.sub(r'\|(.*)', "", title)
        title = re.sub(r'｜(.*)', "", title)
        if site_name is not None:
            title = title.replace(site_name, '')
        title = title.replace('"', '')
        title = title.lstrip("　").rstrip("　").strip()
        url = entry['link']
        if site_name is not None:
            site_domain_name = site_name
        else:
            parse = urlparse(url)
            site_domain_name = parse.netloc

        image_url = None
        image_name = None
        if entry.get('hatena_imageurl') is not None:
            image_url = entry['hatena_imageurl']
            image_name = image_url.lstrip("https://")
            image_name = image_name.replace('/', '')
            image_name = image_name.replace('.', '')
            image_name = image_name.replace('?', '')
            image_name = image_name.replace('%', '')
            image_name = image_name.replace('&', '')
            image_name = image_name[:1019]
            if image_url.endswith(".png"):
                image_name += ".png"
            elif image_url.endswith(".jpeg"):
                image_name += ".jpeg"
            else:
                image_name += ".jpg"

        description = entry['description']
        up = entry['updated']
        up = up.replace('T', ' ').replace('Z', '')
        up = datetime.datetime.strptime(up, "%Y-%m-%d %H:%M:%S")
        up += datetime.timedelta(hours=9)

        if title:
            print (title)
            print (url)
            print (image_name)
            try:
                if rss != "https://b.hatena.ne.jp/entrylist?mode=rss":
                    try:
                        cursor.execute("UPDATE news SET title = %s WHERE url = %s", (title, url))
                        conn.commit()
                    except:
                        pass
                try:
                    cursor.execute("INSERT INTO news (title, url, image, description, site_domain_name, up) VALUES (%s, %s, %s, %s, %s, %s)", (title, url, image_name, description, site_domain_name, up))
                    if image_url is not None:
                        with open(str('/var/www/html/image/') + image_name,'wb') as file:
                            file.write(requests.get(image_url).content)
                            image_data = Image.open(str('/var/www/html/image/') + image_name)
                            image_data.mode != "RGB"
                            image_data = image_data.convert("RGB")
                            if image_data.width > 718:
                                left = round((image_data.width - 718) / 2)
                                right = left + 718
                                new_height = round(718 / 3)
                                upper = round(image_data.height / 2) - round(new_height / 2)
                                lower = upper + new_height
                                crop = image_data.crop((left, upper, right, lower))
                                crop.save(str('/var/www/html/crop/') + image_name)
                                print("2222")
                            else:
                                new_height = image_data.width / 3
                                upper = round(image_data.height / 2) - round(new_height / 2)
                                lower = upper + new_height
                                crop = image_data.crop((0, upper, image_data.width, lower))
                                crop.save(str('/var/www/html/crop/') + image_name)
                                print("どんまい")
                            quality = 75
                            while True:
                                if int(os.path.getsize(str('/var/www/html/crop/') + image_name)) < 10000:
                                    print("yokohama")
                                    break
                                crop.save(str('/var/www/html/crop/') + image_name, quality = quality, optimize = False)
                                if quality >= 5:
                                    quality -= 10
                                else:
                                    print("川崎")
                                    break
                            new_height = image_data.width / 1.5
                            upper = round(image_data.height / 2) - round(new_height / 2)
                            lower = upper + new_height
                            crop = image_data.crop((0, upper, image_data.width, lower))
                            crop.save(str('/var/www/html/app/') + image_name)
                            quality = 75
                            while True:
                                if int(os.path.getsize(str('/var/www/html/app/') + image_name)) < 10000:
                                    print("yokohama")
                                    break
                                crop.save(str('/var/www/html/app/') + image_name, quality = quality, optimize = False)
                                if quality >= 5:
                                    quality -= 10
                                else:
                                    print("川崎")
                                    break
                except:
                    pass
                for tags in entry['tags']:
                    try:
                        cursor.execute("INSERT INTO tag SET tag = %s", (tags['term'],))
                    except:
                        pass
                conn.commit()
                try:
                    cursor.execute("SELECT news_id FROM news WHERE url = %s", (url,))
                    rows = cursor.fetchall()
                    for row in rows:
                        url_parse = urllib.parse.quote(url)
                        rss_url = "https://b.hatena.ne.jp/entrylist?url=" + url_parse + "&mode=rss"
                        feed_nest = feedparser.parse(rss_url)
                        for entry_nest in feed_nest['entries']:
                            for tags_nest in entry_nest['tags']:
                                cursor.execute("SELECT tag_id FROM tag WHERE tag = %s", (tags_nest['term'],))
                                columns = cursor.fetchall()
                                for column in columns:
                                    try:
                                        cursor.execute("INSERT INTO news_to_tag (news_id, tag_id) VALUES (%s, %s)", (row[0], column[0]))
                                    except:
                                        pass
                except:
                    pass
                conn.commit()
            except:
                conn.rollback()
                raise

today = str(datetime.date.today())
cursor.execute("SELECT * FROM `media` WHERE 1")
rows = cursor.fetchall()
for row in rows:
    media = row[0]
    media_parse = urllib.parse.quote(media)
    media_url = "https://b.hatena.ne.jp/search/title?q=" + media_parse + "&sort=recent&date_begin=" + today + "&users=1&mode=rss"
    hatena_parser(media_url, media)

hatena_parser("https://b.hatena.ne.jp/entrylist?mode=rss", None)
cursor.close()
conn.close()
