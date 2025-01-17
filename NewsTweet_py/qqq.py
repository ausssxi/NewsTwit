import re
import mysql.connector
import datetime
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from bs4 import BeautifulSoup
import requests
import unicodedata
import string



options = Options()
options.add_argument('--headless')
options.add_argument('--disable-gpu')
options.add_argument('--disable-extensions')
options.add_argument('--proxy-server="direct://"')
options.add_argument('--proxy-bypass-list=*')
options.add_argument('--blink-settings=imagesEnabled=false')
options.add_argument('--lang=ja')
options.add_argument('--no-sandbox')
options.add_argument('--disable-dev-shm-usage')
options.add_argument("--log-level=3")
options.add_argument('--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36')
options.add_experimental_option("excludeSwitches", ["enable-automation"])
options.add_experimental_option('useAutomationExtension', False)
options.page_load_strategy = 'eager'

chromedriver = '/usr/local/bin/chromedriver'
service = Service(executable_path = chromedriver)
driver = webdriver.Chrome(service = service, options = options)
driver.set_window_size('1200', '1000')
driver.get('https://twitter.com/login')
driver.set_page_load_timeout(5)
WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.NAME, "text")))

username = driver.find_element(By.NAME, "text")
username.send_keys("ausssxi")

button = driver.find_element(By.XPATH, "//div[@style='color: rgb(255, 255, 255);']")
button.click()

WebDriverWait(driver, 1).until(EC.visibility_of_element_located((By.NAME, "password")))

password = driver.find_element(By.NAME, "password")
password.send_keys("au2031sss")

button = driver.find_element(By.XPATH, "//div[@style='color: rgb(255, 255, 255);']")
button.click()

driver.set_page_load_timeout(5)

dt = datetime.datetime.now()
s = str(dt.minute)

conn = mysql.connector.connect(user='root', password='nanoninaze', port = 3306, host='localhost', database='NewsTwit', charset='utf8mb4')
cursor = conn.cursor(buffered=True)
cursor.execute("SELECT news_id, title, url, site_domain_name, up FROM news where news_id = 26246662")
rows = cursor.fetchall()
for row in rows:
    if len(row[2]) < 500:
        title1 = r"" + re.escape(row[1]) + r"(.|\s)*#\S+(\s|$)"
        title2 = r"" + re.escape(row[1]) + r"\s(.{0,40})https?://[\w/:%#\$&\?\(\)~\.=\+\-]+"
        title3 = r"" + re.escape(row[1]) + r"(.{0,40})https?://[\w/:%#\$&\?\(\)~\.=\+\-]+"
        title4 = r"" + re.escape(row[1])

        driver.set_page_load_timeout(5)

        WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.XPATH, "//input[@data-testid='SearchBox_Search_Input']")))

        search = driver.find_element(By.XPATH, "//input[@data-testid='SearchBox_Search_Input']")
        search.send_keys(Keys.CONTROL + 'a', Keys.BACKSPACE)
        search.send_keys(row[2])
        search.send_keys(Keys.RETURN)

        driver.set_page_load_timeout(30)

        WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.XPATH, "//a[@aria-selected='false']")))
        latest = driver.find_element(By.XPATH, "//a[@aria-selected='false']")
        latest.send_keys(Keys.RETURN)

        driver.set_page_load_timeout(10)

        WebDriverWait(driver, 15).until(EC.visibility_of_element_located((By.TAG_NAME, 'article')))
        for i in range(150):
            articles = driver.find_elements(By.TAG_NAME, 'article')
            num = len(articles)
            if (articles[num-2]):
                last = articles[num-2]

                actions = ActionChains(driver);
                actions.move_to_element(last);
                actions.perform();

                driver.set_page_load_timeout(8)
                WebDriverWait(driver, 12).until(EC.visibility_of_element_located((By.TAG_NAME, 'article')))

                for article in driver.find_elements(By.TAG_NAME, 'article'):
                    tag = article.get_attribute('innerHTML')
                    soup = BeautifulSoup(tag, features='lxml')
                    results = soup.select_one(".css-4rbku5.css-18t94o4.css-901oao.r-14j79pv.r-1loqt21.r-xoduu5.r-1q142lx.r-1w6e6rj.r-1tl8opc.r-a023e6.r-16dba41.r-9aw3ui.r-rjixqe.r-bcqeeo.r-3s2u2q.r-qvutc0")
                    if results:
                        href = results.get('href')
                        tweet_id = href.split("/")
                        print(tweet_id[3])
                        cursor.execute("SELECT EXISTS(SELECT * FROM comment WHERE comment_id = %s)", (tweet_id[3],))
                        exists = cursor.fetchone()
                        if exists[0] == 1:
                            break
                    else:
                        break
                    results = soup.find("div", {"data-testid" : "tweetText"})
                    if results:
                        text = results.get_text()
                    else:
                        break
                    results = soup.find("div", {"data-testid" : "User-Name"})
                    user_name = results
                    results = soup.select_one(".css-901oao.css-16my406.css-1hf3ou5.r-1tl8opc.r-bcqeeo.r-qvutc0")
                    name_text = results.get_text()
                    results = user_name.select_one(".css-901oao.css-1hf3ou5.r-14j79pv.r-18u37iz.r-37j5jr.r-1wvb978.r-a023e6.r-16dba41.r-rjixqe.r-bcqeeo.r-qvutc0")
                    screen_text = results.get_text()
                    screen_name = screen_text.lstrip("@")
                    src = soup.select_one("img").get('src')
                    if soup.select_one("time"):
                        time = soup.select_one("time").get('datetime')
                        time = time.replace("T"," ")
                        time = time.replace(".000Z","")
                        usa = datetime.datetime.strptime(time, '%Y-%m-%d %H:%M:%S')
                        japan = usa + datetime.timedelta(hours=9)
                    else:
                        break
                    cursor.execute("SELECT twitter_id FROM comment WHERE screen = %s", (screen_name,))
                    twitter_id = cursor.fetchone()
                    if twitter_id:
                        print(8)
                        print(twitter_id[0])
                    else:
                        cursor.execute("SELECT FLOOR(RAND() * 9223372036854775807) FROM comment WHERE FLOOR(RAND() * 9223372036854775807) NOT IN (SELECT twitter_id FROM comment) LIMIT 1")
                        twitter_id = cursor.fetchone()
                        print(twitter_id[0])
                    if text:
                        print(9)
                        print(text)
                    else:
                        break
                    text = re.sub(re.escape(title1), "", text)
                    text = re.sub(re.escape(title2), "", text)
                    text = re.sub(re.escape(title3), "", text)
                    text = re.sub(re.escape(title4), "", text)
                    text = re.sub(r'（(.*?)）', "", text)
                    text = re.sub(r'\((.*?)\)', "", text)
                    text = re.sub(r'【(.*?)】', "", text)
                    text = re.sub(r'\[(.*?)\]', "", text)
                    text = re.sub(r'〔(.*?)〕', "", text)
                    text = re.sub(r'《(.*?)》', "", text)
                    text = re.sub(r'#\S+(\s|$)', "", text)
                    text = re.sub(r'＃\S+(\s|$)', "", text)
                    text = re.sub(r'[12]\d{3}[/\-年](0?[1-9]|1[0-2])[/\-月](0?[1-9]|[12][0-9]|3[01])日?$', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+さんから', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+さん', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+から', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+より', "", text)
                    text = re.sub(r'他[0-9]+件のコメント', "", text)
                    text = re.sub(r'[0-9]+コメント時', "", text)
                    text = re.sub(r'日本経済新聞', "", text)
                    text = re.sub(r'｜(.*)(\s|$)', "", text)
                    text = re.sub(r'\|(.*)(\s|$)', "", text)
                    text = re.sub(r'-\s(.*)(\s|$)', "", text)
                    text = re.sub(r'■(.*)(\s|$)', "", text)
                    text = re.sub(r'@[a-zA-Z0-9_]+', "", text)
                    text = re.sub(r'https?://[\w/:%#\$&\?\(\)~\.=\+\-]+', "", text)
                    text = re.sub(r'「(.*?)」\sにコメントしました。', "", text)
                    text = re.sub(r'「」\sにコメントしました。', "", text)
                    text = re.sub(r'「(.*?)」にいいね！しました。', "", text)
                    text = re.sub(r'さんの「(.*?)」\sをお気に入りにしました。', "", text)
                    text = re.sub(r'さんの「」\sをお気に入りにしました。', "", text)
                    text = text.replace("【","").replace("】","").replace("＞","").replace("／","").replace(":","").replace("：","").replace("/","").replace("|","").replace(".","").replace("“","").replace("”","")
                    text = text.replace("via","")
                    text = text.replace(row[3],"")
                    lists = row[1].split(" ")
                    for list in lists:
                        text = text.replace(list,"")
                    text = text.lstrip()
                    text = text.rstrip()
                    comp_a = unicodedata.normalize("NFKC", text)
                    table = str.maketrans("", "", string.punctuation  + "「」、。・！")
                    comp_a = comp_a.translate(table)
                    comp_b = unicodedata.normalize("NFKC", row[1])
                    table = str.maketrans("", "", string.punctuation  + "「」、。・！")
                    comp_b = comp_b.translate(table)
                    if text != "" and len(text) > 1 and comp_a not in comp_b:
                        print(text)
                        print(name_text)
                        print(screen_name)
                        print(src)
                        print(japan)
                        try:
                            cursor.execute("INSERT INTO comment (comment_id, news_id, twitter_id, tweet, name, screen, icon, up) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", (tweet_id[3], row[0], twitter_id[0], text, name_text, screen_name, src, japan))
                            conn.commit()
                        except mysql.connector.Error as err:
                            print("Something went wrong: {}".format(err))
cursor.close()
conn.close()
