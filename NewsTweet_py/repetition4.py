import psutil
import subprocess

for proc in psutil.process_iter():
    if proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping1.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping2.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping3.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping4.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping5.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping6.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping7.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping8.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping9.py']:
        break
    elif proc.cmdline() == ['/usr/local/bin/python3', '/home/sakura/python/scraping0.py']:
        break
else:
    subprocess.run(['/usr/bin/killall', 'chrome'])
    subprocess.run(['/usr/bin/killall', 'chromedriver'])
    subprocess.run(['/usr/bin/killall', 'webdriver'])
    subprocess.run(['/usr/local/bin/python3', '/home/sakura/python/scraping4.py'])
