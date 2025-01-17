<?php
function header_html() {
    global $twitter_id_session;
    echo "<header class='flex space-around align-items-center fixed top-0 width-100pe height-48 index-9999 background-black text-align-center'>
        <div class='color-white pointer'>
            <i class='fas fa-bars font-size-12'></i>
            <div class='font-size-9'>
                <strong>メニュー</strong>
            </div>
        </div>
        <div class='font-size-0 none-767'>
            <span class='color-white font-size-9'>Twitterで話題のニュースをお届け</span><br>
            <strong>
                <span class='color-white font-size-18'>NewsTwit</span>
            </strong>
        </div>
        <div class='relative'>
            <input type='text' placeholder='キーワード' name='text' class='width-128-256 height-32 padding-left-12 border-none radius-20 outline-none'>
            <span class='absolute top-7 right-12 width-20 height-20 pointer search-icon'></span>
        </div>";
        if (isset($_SESSION["id"])) {
            global $mysqli;
            $result = $mysqli->query("SELECT twitter_id, icon FROM user WHERE user_id = '$_SESSION[id]'");
            $row = $result->fetch_assoc();
            $twitter_id_session = $row["twitter_id"];
            $icon = $row["icon"];
            echo "<img class='width-32 height-32 radius-50 pointer' src='/thumbnail/${icon}'>";
        } else {
            echo "<span class='color-white font-size-12'>
                <a href='/login.php' class='color-white font-size-12'>ログイン</a>
            </span>";
        }
    echo "</header>";
}

function toggle() {
    global $twitter_id_session;
    echo "<div class='fixed toggle-menu top-48 width-192 height-441 index-9999 background-white y-scroll'>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/' class='color-black underline'>
                 <strong>トップ</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/all' class='color-black underline'>
                 <strong>総合</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/entame' class='color-black underline'>
                 <strong>芸能・スポーツ</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/anime' class='color-black underline'>
                 <strong>アニメ・ゲーム</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/it' class='color-black underline'>
                 <strong>IT・科学</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/learn' class='color-black underline'>
                 <strong>教育・学習</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/life' class='color-black underline'>
                 <strong>生活</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/politics' class='color-black underline'>
                 <strong>政治・経済</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/society' class='color-black underline'>
                 <strong>社会</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/new/all' class='color-black underline'>
                 <strong>新着</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/ranking/today/1/" . date('Ymd', strtotime('-1 day')) . "' class='color-black underline'>
                <strong>コメントランキング</strong>
            </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/about' class='color-black underline'><strong>このサイトについて</strong></a>
        </div>
    </div>
    <div class='fixed toggle-menu top-48 index-9999 width-160 right-0 background-white'>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
        <a href='/profile/id/${twitter_id_session}' class='color-black underline'>
            <strong>あなたのコメント</strong>
        </a>
        </div>
        <div class='toggle-item height-48 padding-left-16 line-height-48'>
            <a href='/logout.php' class='color-black underline'>
                <strong>ログアウト</strong>
            </a>
        </div>
    </div>";
}

function footer() {
  echo "<hr class='clear-both height-1 margin-0 border-none background-black'>
      <footer class='flex-768 justify-content-center width-100pe margin-bottom-24-74 font-size-12 text-align-center'>
          <div class='line-height-1 margin-top-24 margin-right-24-768'>
              <a class='color-black underline' href='/about'>このサイトについて</a>
          </div>
          <div class='margin-top-24 margin-right-24-768 line-height-1'>
              <a class='color-black underline' href='/contact'>ご意見・お問い合わせ</a>
          </div>
          <div class='margin-top-24 margin-right-24-768 line-height-1'>
              <a class='color-black underline' href='/privacy'>プライバシーポリシー</a>
          </div>
          <div class='margin-top-24 margin-right-24-768 line-height-1'>
              <a class='color-black underline' href='/media/list'>掲載メディア一覧</a>
          </div>
          <div class='flex justify-content-center margin-top-24-15 line-height-12'>
              <div class='margin-right-24'>
                  <a href='https://apps.apple.com/jp/app/newstweet-%E3%83%8B%E3%83%A5%E3%83%BC%E3%82%BA%E3%83%84%E3%82%A4%E3%83%BC%E3%83%88/id1531315934' target='_blank'><img class='vertical-align-top' src='/Download_on_the_App_Store_Badge_JP_RGB_blk_100317.svg' height='30'></a>
              </div>
              <div>
                  <a href='https://twitter.com/NewsTweet_jp' target='_blank'><img class='vertical-align-top' src='/Logo blue.svg' width='30' height='30'></a>
              </div>
          </div>
      </footer>";
}

function ads_728() {
    echo "<div class='margin-bottom-24 text-align-center none-767 none-1126'>
        <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3690883624273126' crossorigin='anonymous'></script>
        <!-- 728×90 -->
        <ins class='adsbygoogle' style='display:inline-block;width:728px;height:90px' data-ad-client='ca-pub-3690883624273126' data-ad-slot='4647362491'></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>";
}

function ads_320() {
    echo "<div class='fixed bottom-0 width-100pe height-50 index-9999 text-align-center none-768'>
        <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3690883624273126' crossorigin='anonymous'></script>
        <!-- 320x50 -->
        <ins class='adsbygoogle' style='display:inline-block;width:320px;height:50px' data-ad-client='ca-pub-3690883624273126' data-ad-slot='1102088903'></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>";
}

function head($category_name, $category_href) {
    echo "<!DOCTYPE html>
    <html lang='ja'>
      <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no'>
          <meta name='description' content='NewsTwitはTwitterでコメントしたニュースを、まとめたソーシャルニュースサイトです。Twitterで注目されているニュースがわかります。'>
          <link rel='stylesheet' type='text/css' href='/style.css'>
          <link rel='stylesheet' type='text/css' href='https://use.fontawesome.com/releases/v5.11.2/css/all.css'>
          <link rel='canonical' href='https://newstwit.jp/${category_href}'>
          <title>NewsTwit - ${category_name}</title>
          <!-- Global site tag (gtag.js) - Google Analytics -->
          <script async src='https://www.googletagmanager.com/gtag/js?id=UA-149633438-1'></script>
          <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', 'UA-149633438-1');
          </script>
      </head>
      <body>";
}

function side_ranking($category_name, $category_number, $flag) {
    echo "<div class='margin-top-24 font-size-12-14 line-height-1'>";
        if ($flag == 0) {
            echo "<a href='/ranking/today/${category_number}/" . date("Y", strtotime("-1 day")) . date("m", strtotime("-1 day")) . date("d", strtotime("-1 day")) . "' class='color-black underline'>
            <strong>${category_name}（デイリーコメントランキング）</strong>";
        } else {
            echo "<a href='/ranking/month/${category_number}/" . date("Y", strtotime("-1 day")) . date("m", strtotime("-1 day")) . "' class='color-black underline'>
            <strong>${category_name}（マンスリーコメントランキング）</strong>";
        }
        echo "</a>
    </div>
    <div class='margin-top-24 width-100pe-336 radius-8 background-white'>";
        global $mysqli;
        if ($flag == 0) {
            $ranking_table = "ranking_today";
            $date = date('Y-m-d', strtotime("-1 day"));
        } else {
            $ranking_table = "ranking_month";
            $date = date("Y").date("m");
        }
        $result = $mysqli->query("SELECT news_id, count FROM ${ranking_table} WHERE category = ${category_number} and date = '${date}'");
        while ($row = $result->fetch_assoc()) {
            $news_id = $row["news_id"];
            $count = $row["count"];
            $result = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
            $row = $result->fetch_assoc();
            if (is_null($row["image"])) {
                $image = "noimage.jpeg";
            } else {
                $filename = "/var/www/html/app/" . $row["image"];
                if (file_exists($filename)) {
                    $image = $row["image"];
                } else {
                    $image = "noimage.jpeg";
                }
            }
            echo "<div class='flex'>
                <a class='inline-flex black-link black-visited red-opacity' href='/news/${news_id}'>
                    <img src='/app/${image}' class='width-111 radius-8-0-0'>
                    <div class='height-74'>
                        <div class='width-100pe-225 height-74 padding-top-12 padding-right-16 padding-left-16 overflow-hidden radius-0-8-8-0 font-size-14 break-all line-height-1_5 border-box webkit-box webkit-vertical webkit-clamp-3'>
                            <strong>$row[title]</strong>
                        </div>
                    </div>
                </a>
            </div>
            <div class='padding-16 overflow-hidden border-box font-size-12 overflow-ellipsis nowrap line-height-1'>
                <a class='color-darkgray underline' href='/media/site/$row[site_domain_name]'>$row[site_domain_name]</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($row['up']) . "</span>
            </div>";
        }
    echo "</div>";
}

function popular_main($category_name, $category_href, $category_number) {
    global $mysqli;
    echo "<main class='width-auto padding-24'>
        <ul class='flex list-style-type-none width-718-1078 margin-48-auto-0 padding-left-0 font-size-12 nowrap'>
            <li class='breadcrumb line-height-1'><a href='/' class='color-black underline'><strong>トップ</strong></a></li>
            <li class='breadcrumb line-height-1'><a href='/${category_href}' class='color-black underline'><strong>${category_name}</strong></a></li>
        </ul>
        <div class='width-718-1078 margin-24-auto-0 font-size-24 line-height-1'>
              <strong>${category_name}</strong>
        </div>
        <div class='flex-media-1126 justify-content-center margin-top-24'>
            <div>";
                $i = 0;
                $result_count = $mysqli->query("SELECT * FROM news_count WHERE category = ${category_number} ORDER BY count DESC, news_id DESC LIMIT 20");
                while ($row = $result_count->fetch_assoc()) {
                    $news_id = $row["news_id"];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count = $row[0];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count += $row[0];
                    $result_news = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                    $row = $result_news->fetch_assoc();
                    $title = $row["title"];
                    if (is_null($row["image"])) {
                        $image = "noimage.jpeg";
                    } else {
                        if (user_agent() == false) {
                            $filename = "app";
                        } else {
                            $filename = "crop";
                        }
                        if (file_exists("/var/www/html/${filename}/$row[image]")) {
                            $image = $row["image"];
                        } else {
                            $image = "noimage.jpeg";
                        }
                    }
                    $site_domain_name = $row["site_domain_name"];
                    $up = $row["up"];
                    $result = $mysqli->query("SELECT twitter_id, tweet, name, screen, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1");
                    $row = $result->fetch_assoc();
                    $twitter_id = $row["twitter_id"];
                    $tweet = $row["tweet"];
                    $icon = $row["icon"];
                    $screen = $row["screen"];
                    $name_screen = $row["name"] . "@" . $screen;
                    $margin_top24 = "";
                    if ($i != 0) {
                        $margin_top24 = "margin-top-24";
                    }
                    echo "<div class='width-100pe-718 margin-0-auto-1125'>
                        <div class='${margin_top24} radius-8 background-white'>
                            <div class='height-64-768 padding-top-16-768 padding-right-16-768 padding-bottom-4-768 padding-left-16-768'>
                                <a class='inline-flex-768 black-link black-visited red-opacity' href='/news/${news_id}'>
                                    <img class='width-100pe-767 height-64-768 radius-8-8-0-0 radius-8-768 vertical-align-top' src='/${filename}/${image}'>
                                    <div class='margin-top_4-768 padding-top-12-767 padding-right-16-767 padding-left-16 overflow-hidden-768 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-3-768'>
                                        <strong>${title}</strong>
                                    </div>
                                </a>
                            </div>
                            <div class='padding-top-12 padding-right-16 padding-left-16 padding-bottom-16'>
                                <div class='font-size-12 line-height-1'>
                                    <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                                </div>
                            </div>
                            <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                            if ($comment_count != 0) {
                                echo "<div class='padding-16'>
                                    <div class='flex'>
                                        <a href='/profile/id/${twitter_id}'>
                                            <img src='${icon}' class='width-32 height-32 radius-50'>
                                        </a>
                                        <div class='min-width'>
                                            <div class='padding-bottom-12 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1 border-box'>
                                                <a class='color-black underline' href='/profile/id/${twitter_id}'>
                                                    <strong>$name_screen</strong>
                                                </a>
                                            </div>
                                            <div class='padding-left-16 overflow-hidden font-size-14 pre-line line-height-1_5'>${tweet}</div>
                                        </div>
                                    </div>
                                    <div class='flex padding-top-12'>";
                                        if ($comment_count < 4) {
                                            $result = $mysqli->query("SELECT twitter_id, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 0, 3");
                                        } else {
                                            $result = $mysqli->query("SELECT twitter_id, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1, 3");
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<a href='/profile/id/$row[twitter_id]'>
                                                <img src='$row[icon]' class='width-24 height-24 margin-right-6 radius-50 vertical-align-top'>
                                            </a>";
                                        }
                                        echo "<div class='font-size-12 line-height-24'>
                                            <strong>${comment_count}</strong>コメント
                                        </div>
                                    </div>
                                </div>";
                            } else {
                                echo "<div class='padding-top-16 padding-left-16 padding-bottom-16 border-box font-size-14 line-height-1'>まだコメントはありません</div>";
                            }
                        echo "</div>
                    </div>";
                    $i++;
                }
                if ($category_number == 1) {
                    $news_count = 100;
                } else {
                    $news_count = 60;
                }
                if ($news_count > 20) {
                    $count_down = $news_count - 20;
                    echo "<span class='news-read'></span>
                    <div class='margin-top-24'>
                        <button class='block width-50pe height-48 margin-auto background-white border-width-1 border-style-solid border-color-black radius-3 color-black font-size-16 text-align-center decoration-none line-height-48 transition-400ms more-button' type='submit'>
                            あと${count_down}件
                        </button>
                    </div>";
                }
            echo "</div>
            <div class='margin-left-24-768 none-768-1125'>
                <div class='none-767'>
                    <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3690883624273126' crossorigin='anonymous'></script>
                    <!-- 336×280 -->
                    <ins class='adsbygoogle' style='display:inline-block;width:336px;height:280px' data-ad-client='ca-pub-3690883624273126' data-ad-slot='3962796783'></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <div class='margin-top-24 font-size-14 line-height-1'>
                    <a href='/ranking/today/${category_number}/" . date("Y", strtotime("-1 day")) . date("m", strtotime("-1 day")) . date("d", strtotime("-1 day")) . "' class='color-black underline'>
                        <strong>${category_name}（コメントランキング）</strong>
                    </a>
                </div>
                <div class='width-100pe-336 margin-top-24 radius-8 background-white'>";
                $i = 1;
                $date = date('Y-m-d', strtotime("-1 day"));
                $result_ranking = $mysqli->query("SELECT news_id, count FROM ranking_today WHERE category = ${category_number} and date = '${date}'");
                while ($row = $result_ranking->fetch_assoc()) {
                    $news_id = $row["news_id"];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count = $row[0];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count += $row[0];
                    $result = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                    $row = $result->fetch_assoc();
                    if (is_null($row["image"])) {
                        $image = "noimage.jpeg";
                    } else {
                        $filename = "/var/www/html/app/" . $row["image"];
                        if (file_exists($filename)) {
                            $image = $row["image"];
                        } else {
                            $image = "noimage.jpeg";
                        }
                    }
                    echo "<div class='width-100pe-336 padding-bottom-16 border-box'>
                        <div class='font-size-14 padding-16 border-box line-height-1'>
                            <strong>$i</strong><span class='font-size-12'>位&nbsp;-&nbsp;</span><strong>${comment_count}</strong><span class='font-size-12'>コメント</span>
                        </div>
                        <hr class='clear-both height-1 margin-0 border-none linear-gradient-dashed'>
                        <a class='inline-flex height-58 padding-16 black-link black-visited red-opacity' href='/news/${news_id}'>
                            <img class='height-58 radius-8' src='/app/${image}'>
                            <div class='margin-left-16'>
                                <div class='height-61 margin-top_3 overflow-hidden font-size-14 break-all line-height-1_5 border-box webkit-box webkit-vertical webkit-clamp-3'>
                                    <strong>$row[title]</strong>
                                </div>
                            </div>
                        </a>
                        <div class='padding-left-16 font-size-12 line-height-1'>
                            <a class='color-darkgray underline' href='/media/site/$row[site_domain_name]'>$row[site_domain_name]</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($row['up']) . "</span>
                        </div>
                    </div>";
                    if ($i != 20) {
                        echo "<hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                    }
                $i++;
            }
            echo "</div>
            <div class='margin-top-24 none-767'>
                <script type='text/javascript'>
                    rakuten_design='slide';
                    rakuten_affiliateId='12ea5223.d4a53d6c.12ea5224.9a86d468';
                    rakuten_items='ctsmatch';
                    rakuten_genreId='0';
                    rakuten_size='336x280';
                    rakuten_target='_blank';
                    rakuten_theme='gray';
                    rakuten_border='off';
                    rakuten_auto_mode='on';
                    rakuten_genre_title='off';
                    rakuten_recommend='on';
                    rakuten_ts='1638160942761';
                </script>
            <script type='text/javascript' src='https://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget.js'></script>
            </div>
            <div class='margin-top-24 font-size-14 line-height-1'>
                <a href='/new/${category_href}' class='color-black underline'>
                    <strong>${category_name}（新着）</strong>
                </a>
            </div>
            <div class='width-100pe-336 margin-top-24 radius-8 background-white'>";
                $i = 1;
                $result_ranking = $mysqli->query("SELECT news_id FROM news_new WHERE category = ${category_number}");
                while ($row = $result_ranking->fetch_assoc()) {
                    $news_id = $row["news_id"];
                    $result = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                    $row = $result->fetch_assoc();
                    if (is_null($row["image"])) {
                        $image = "noimage.jpeg";
                    } else {
                        $filename = "/var/www/html/app/" . $row["image"];
                        if (file_exists($filename)) {
                            $image = $row["image"];
                        } else {
                            $image = "noimage.jpeg";
                        }
                    }
                    echo "<div class='width-100pe-336 padding-16 border-box'>
                        <a class='inline-flex height-58 padding-bottom-16 black-link black-visited red-opacity' href='/news/${news_id}'>
                            <img class='height-58 radius-8' src='/app/${image}'>
                            <div class='margin-left-16'>
                                <div class='height-61 margin-top_3 overflow-hidden font-size-14 break-all line-height-1_5 border-box webkit-box webkit-vertical webkit-clamp-3'>
                                    <strong>$row[title]</strong>
                                </div>
                            </div>
                        </a>
                        <div class='font-size-12 line-height-1'>
                            <a class='color-darkgray underline' href='/media/site/$row[site_domain_name]'>$row[site_domain_name]</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($row['up']) . "</span>
                        </div>
                    </div>";
                    if ($i != 10) {
                        echo "<hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                    }
                    $i++;
                }
            echo "</div>
        </div>
    </main>";
}

function popular_more($popular_sql) {
    global $mysqli;
    $result_count = $mysqli->query($popular_sql);
    while ($row = $result_count->fetch_assoc()) {
        $news_id = $row["news_id"];
        $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
        $row = $result->fetch_row();
        $comment_count = $row[0];
        $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
        $row = $result->fetch_row();
        $comment_count += $row[0];
        $result_news = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
        $row = $result_news->fetch_assoc();
        $title = $row["title"];
        if (is_null($row["image"])) {
            $image = "noimage.jpeg";
        } else {
            if (user_agent() == false) {
                $filename = "app";
            } else {
                $filename = "crop";
            }
            if (file_exists("/var/www/html/${filename}/$row[image]")) {
                $image = $row["image"];
            } else {
                $image = "noimage.jpeg";
            }
        }
        $site_domain_name = $row["site_domain_name"];
        $up = $row["up"];
        $result = $mysqli->query("SELECT twitter_id, tweet, name, screen, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1");
        $row = $result->fetch_assoc();
        $twitter_id = $row["twitter_id"];
        $tweet = $row["tweet"];
        $icon = $row["icon"];
        $screen = $row["screen"];
        $name_screen = $row["name"] . "@" . $screen;
        echo "<div class='width-100pe-718 margin-0-auto-1125'>
            <div class='margin-top-24 radius-8 background-white'>
                <div class='height-64-768 padding-top-16-768 padding-right-16-768 padding-bottom-4-768 padding-left-16-768'>
                    <a class='inline-flex-768 black-link black-visited red-opacity' href='/news/${news_id}'>
                        <img class='width-100pe-767 height-64-768 radius-8-8-0-0 radius-8-768 vertical-align-top' src='/${filename}/${image}'>
                        <div class='margin-top_4-768 padding-top-12-767 padding-right-16-767 padding-left-16 overflow-hidden-768 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-3-768'>
                            <strong>${title}</strong>
                        </div>
                    </a>
                </div>
                <div class='padding-top-12 padding-right-16 padding-left-16 padding-bottom-16'>
                    <div class='font-size-12 line-height-1'>
                        <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                    </div>
                </div>
                <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                if ($comment_count != 0) {
                    echo "<div class='padding-16'>
                        <div class='flex'>
                            <a href='/profile/id/${twitter_id}'>
                                <img src='${icon}' class='width-32 height-32 radius-50'>
                            </a>
                            <div class='min-width'>
                                <div class='padding-bottom-12 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1 border-box'>
                                    <a class='color-black underline' href='/profile/id/${twitter_id}'>
                                        <strong>$name_screen</strong>
                                    </a>
                                </div>
                                <div class='padding-left-16 overflow-hidden font-size-14 pre-line line-height-1_5'>${tweet}</div>
                            </div>
                        </div>
                        <div class='flex padding-top-12'>";
                            if ($comment_count < 4) {
                                $result = $mysqli->query("SELECT twitter_id, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 0, 3");
                            } else {
                                $result = $mysqli->query("SELECT twitter_id, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1, 3");
                            }
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='/profile/id/$row[twitter_id]'>
                                    <img src='$row[icon]' class='width-24 height-24 margin-right-6 radius-50 vertical-align-top'>
                                </a>";
                            }
                            echo "<div class='font-size-12 line-height-24'>
                                <strong>${comment_count}</strong>コメント
                            </div>
                        </div>
                    </div>";
                } else {
                    echo "<div class='padding-top-16 padding-left-16 padding-bottom-16 border-box font-size-14 line-height-1'>まだコメントはありません</div>";
                }
            echo "</div>
        </div>";
    }
}

function popular_java($category_number, $category_name) {
            echo "<script>
                (function($) {
                    $(function () {
                        $(document).on('click', function(e) {
                            if (!$(e.target).closest('.toggle-menu').length && !$(e.target).closest('div.pointer').length && !$(e.target).closest('img.pointer').length) {
                                $('div.width-192').removeAttr('id', 'show');
                                $('div.width-160').removeAttr('id', 'show');
                            } else if ($(e.target).closest('div.pointer').length) {
                                if ($('div.width-192').attr('id') === 'show') {
                                    $('div.width-192').removeAttr('id', 'show');
                                } else {
                                    $('div.width-192').attr('id', 'show');
                                    $('div.width-160').removeAttr('id', 'show');
                                }
                            } else if ($(e.target).closest('img.pointer').length) {
                                if ($('div.width-160').attr('id') === 'show') {
                                    $('div.width-160').removeAttr('id', 'show');
                                } else {
                                    $('div.width-160').attr('id', 'show');
                                    $('div.width-192').removeAttr('id', 'show');
                                }
                            }
                        });
                        $('.search-icon').first().on('click', function() {
                            var text =　$('.outline-none').first().val();
                            if (text) {
                                location.href = '/search/'　+ text;
                            }
                        });
                        $('.outline-none').first().keypress(function(e) {
                            if (e.which === 13) {
                                var text =　$('.outline-none').first().val();
                                if (text) {
                                    location.href = '/search/'　+ text;
                                }
                            }
                        });
                        if (${category_number} == 1) {
                            var count = 100;
                        } else {
                            var count = 60;
                        }
                        var offset = 1;
                        $('.more-button').on('click', function() {
                            count = count - 20;
                            more();
                            offset++;
                        });
                        function more() {
                            if (count > 0) {
                                var more_button = $('.more-button');
                                more_button.addClass('flex align-items-center justify-content-center');
                                more_button.html('<img src =\'/loading.gif\'>');
                                var getData = {'offset':offset};
                                $.get('/${category_name}_more_web.php', getData, function(rs) {
                                    $('.news-read').append(rs);
                                }).always(function(data) {
                                    more_button.removeClass('flex align-items-center justify-content-center');
                                    let count_down = count - 20;
                                    if (count < 21) {
                                        more_button.remove();
                                    } else {
                                        more_button.html('あと' + count_down + '件');
                                    }
                                });
                            }
                        }
                    });
                })(jQuery);
            </script>
        </body>
    </html>";
}

function java() {
            echo "<script>
                (function($) {
                    $(function () {
                        $(document).on('click', function(e) {
                            if (!$(e.target).closest('.toggle-menu').length && !$(e.target).closest('div.pointer').length && !$(e.target).closest('img.pointer').length) {
                                $('div.width-192').removeAttr('id', 'show');
                                $('div.width-160').removeAttr('id', 'show');
                            } else if ($(e.target).closest('div.pointer').length) {
                                if ($('div.width-192').attr('id') === 'show') {
                                    $('div.width-192').removeAttr('id', 'show');
                                } else {
                                    $('div.width-192').attr('id', 'show');
                                    $('div.width-160').removeAttr('id', 'show');
                                }
                            } else if ($(e.target).closest('img.pointer').length) {
                                if ($('div.width-160').attr('id') === 'show') {
                                    $('div.width-160').removeAttr('id', 'show');
                                } else {
                                    $('div.width-160').attr('id', 'show');
                                    $('div.width-192').removeAttr('id', 'show');
                                }
                            }
                        });
                        $('.search-icon').first().on('click', function() {
                            var text =　$('.outline-none').first().val();
                            if (text) {
                                location.href = '/search/'　+ text;
                            }
                        });
                        $('.outline-none').first().keypress(function(e) {
                            if (e.which === 13) {
                                var text =　$('.outline-none').first().val();
                                if (text) {
                                    location.href = '/search/'　+ text;
                                }
                            }
                        });
                    });
                })(jQuery);
            </script>
        </body>
    </html>";
}

function new_main($news_count, $category_name, $category_href, $category_number, $category_url) {
    global $mysqli;
    echo "<main class='width-auto padding-24'>
        <ul class='flex list-style-type-none width-718-1078 margin-48-auto-0 padding-left-0 font-size-12 nowrap'>
            <li class='breadcrumb line-height-1'><a href='/' class='color-black underline'><strong>トップ</strong></a></li>
            <li class='breadcrumb line-height-1'><a href='/${category_href}' class='color-black underline'><strong>${category_name}</strong></a></li>
            <li class='breadcrumb line-height-1'><a href='/new/${category_href}' class='color-black underline'><strong>${category_name}（新着）</strong></a></li>
        </ul>
        <div class='width-718-1078 margin-24-auto-0 font-size-24 line-height-1'>
              <strong>${category_name}（新着）</strong>
        </div>
        <div class='flex-media-1126 justify-content-center margin-top-24'>
            <div>";
                $i = 0;
                $result_count = $mysqli->query($category_url);
                while ($row = $result_count->fetch_assoc()) {
                    $news_id = $row["news_id"];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count = $row[0];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count += $row[0];
                    $result_news = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                    $row = $result_news->fetch_assoc();
                    $title = $row["title"];
                    if (is_null($row["image"])) {
                        $image = "noimage.jpeg";
                    } else {
                        if (user_agent() == false) {
                            $filename = "app";
                        } else {
                            $filename = "crop";
                        }
                        if (file_exists("/var/www/html/${filename}/$row[image]")) {
                            $image = $row["image"];
                        } else {
                            $image = "noimage.jpeg";
                        }
                    }
                    $site_domain_name = $row["site_domain_name"];
                    $up = $row["up"];
                    $result = $mysqli->query("SELECT twitter_id, tweet, name, screen, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1");
                    if (mysqli_num_rows($result)) {
                        $row = $result->fetch_assoc();
                        $twitter_id = $row["twitter_id"];
                        $tweet = $row["tweet"];
                        $icon = $row["icon"];
                        $screen = $row["screen"];
                        $name_screen = $row["name"] . "@" . $screen;
                    }
                    $margin_top24 = "";
                    if ($i != 0) {
                        $margin_top24 = "margin-top-24";
                    }
                    echo "<div class='width-100pe-718 margin-0-auto-1125'>
                        <div class='${margin_top24} radius-8 background-white'>
                            <div class='height-64-768 padding-top-16-768 padding-right-16-768 padding-bottom-4-768 padding-left-16-768'>
                                <a class='inline-flex-768 black-link black-visited red-opacity' href='/news/${news_id}'>
                                    <img class='width-100pe-767 height-64-768 radius-8-8-0-0 radius-8-768 vertical-align-top' src='/${filename}/${image}'>
                                    <div class='margin-top_4-768 padding-top-12-767 padding-right-16-767 padding-left-16 overflow-hidden-768 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-3-768'>
                                        <strong>${title}</strong>
                                    </div>
                                </a>
                            </div>
                            <div class='padding-top-12 padding-right-16 padding-left-16 padding-bottom-16'>
                                <div class='font-size-12 line-height-1'>
                                    <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                                </div>
                            </div>
                            <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                            if ($comment_count != 0) {
                                echo "<div class='padding-16'>
                                    <div class='flex'>
                                        <a href='/profile/id/${twitter_id}'>
                                            <img src='${icon}' class='width-32 height-32 radius-50'>
                                        </a>
                                        <div class='min-width'>
                                            <div class='padding-bottom-12 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1 border-box'>
                                                <a class='color-black underline' href='/profile/id/${twitter_id}'>
                                                    <strong>$name_screen</strong>
                                                </a>
                                            </div>
                                            <div class='padding-left-16 overflow-hidden font-size-14 pre-line line-height-1_5'>${tweet}</div>
                                        </div>
                                    </div>
                                    <div class='flex padding-top-12'>";
                                        if ($comment_count < 4) {
                                            $result = $mysqli->query("SELECT twitter_id, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 0, 3");
                                        } else {
                                            $result = $mysqli->query("SELECT twitter_id, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1, 3");
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<a href='/profile/id/$row[twitter_id]'>
                                                <img src='$row[icon]' class='width-24 height-24 margin-right-6 radius-50 vertical-align-top'>
                                            </a>";
                                        }
                                        echo "<div class='font-size-12 line-height-24'>
                                            <strong>${comment_count}</strong>コメント
                                        </div>
                                    </div>
                                </div>";
                            } else {
                                echo "<div class='padding-top-16 padding-left-16 padding-bottom-16 border-box font-size-14 line-height-1'>まだコメントはありません</div>";
                            }
                        echo "</div>
                    </div>";
                    $i++;
                }
                if ($news_count > 40) {
                    $count_down = $news_count - 40;
                    echo "<span class='news-read'></span>
                    <div class='margin-top-24'>
                        <button class='block width-50pe height-48 margin-auto background-white border-width-1 border-style-solid border-color-black radius-3 color-black font-size-16 text-align-center decoration-none line-height-48 transition-400ms more-button' type='submit'>
                            あと${count_down}件
                        </button>
                    </div>";
                }
            echo "</div>
            <div class='margin-left-24-768 none-768-1125'>
                <div class='none-767'>
                    <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3690883624273126' crossorigin='anonymous'></script>
                    <!-- 336×280 -->
                    <ins class='adsbygoogle' style='display:inline-block;width:336px;height:280px' data-ad-client='ca-pub-3690883624273126' data-ad-slot='3962796783'></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <div class='margin-top-24 font-size-14 line-height-1'>
                    <a href='/ranking/today/${category_number}/" . date("Y", strtotime("-1 day")) . date("m", strtotime("-1 day")) . date("d", strtotime("-1 day")) . "' class='color-black underline'>
                        <strong>${category_name}（コメントランキング）</strong>
                    </a>
                </div>
                <div class='width-100pe-336 margin-top-24 radius-8 background-white'>";
                $i = 1;
                $date = date('Y-m-d', strtotime("-1 day"));
                $result_ranking = $mysqli->query("SELECT news_id, count FROM ranking_today WHERE category = ${category_number} and date = '${date}'");
                while ($row = $result_ranking->fetch_assoc()) {
                    $news_id = $row["news_id"];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count = $row[0];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count += $row[0];
                    $result = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                    $row = $result->fetch_assoc();
                    if (is_null($row["image"])) {
                        $image = "noimage.jpeg";
                    } else {
                        $filename = "/var/www/html/app/" . $row["image"];
                        if (file_exists($filename)) {
                            $image = $row["image"];
                        } else {
                            $image = "noimage.jpeg";
                        }
                    }
                    echo "<div class='width-100pe-336 padding-bottom-16 border-box'>
                        <div class='font-size-14 padding-16 border-box line-height-1'>
                            <strong>$i</strong><span class='font-size-12'>位&nbsp;-&nbsp;</span><strong>${comment_count}</strong><span class='font-size-12'>コメント</span>
                        </div>
                        <hr class='clear-both height-1 margin-0 border-none linear-gradient-dashed'>
                        <a class='inline-flex height-58 padding-16 black-link black-visited red-opacity' href='/news/${news_id}'>
                            <img class='height-58 radius-8' src='/app/${image}'>
                            <div class='margin-left-16'>
                                <div class='height-61 margin-top_3 overflow-hidden font-size-14 break-all line-height-1_5 border-box webkit-box webkit-vertical webkit-clamp-3'>
                                    <strong>$row[title]</strong>
                                </div>
                            </div>
                        </a>
                        <div class='padding-left-16 font-size-12 line-height-1'>
                            <a class='color-darkgray underline' href='/media/site/$row[site_domain_name]'>$row[site_domain_name]</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($row['up']) . "</span>
                        </div>
                    </div>";
                    if ($i != 20) {
                        echo "<hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                    }
                $i++;
            }
            echo "</div>
            <div class='margin-top-24 none-767'>
                <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3690883624273126' crossorigin='anonymous'></script>
                <!-- 336×280 -->
                <ins class='adsbygoogle' style='display:inline-block;width:336px;height:280px' data-ad-client='ca-pub-3690883624273126' data-ad-slot='3962796783'></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div class='margin-top-24 font-size-14 line-height-1'>
                <a href='/${category_href}' class='color-black underline'>
                    <strong>${category_name}（総合）</strong>
                </a>
            </div>
            <div class='width-100pe-336 margin-top-24 radius-8 background-white'>";
                $i = 1;
                $result_ranking = $mysqli->query("SELECT news_id FROM news_count WHERE category = ${category_number}");
                while ($row = $result_ranking->fetch_assoc()) {
                    $news_id = $row["news_id"];
                    $result = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                    $row = $result->fetch_assoc();
                    if (is_null($row["image"])) {
                        $image = "noimage.jpeg";
                    } else {
                        $filename = "/var/www/html/app/" . $row["image"];
                        if (file_exists($filename)) {
                            $image = $row["image"];
                        } else {
                            $image = "noimage.jpeg";
                        }
                    }
                    echo "<div class='width-100pe-336 padding-16 border-box'>
                        <a class='inline-flex height-58 padding-bottom-16 black-link black-visited red-opacity' href='/news/${news_id}'>
                            <img class='height-58 radius-8' src='/app/${image}'>
                            <div class='margin-left-16'>
                                <div class='height-61 margin-top_3 overflow-hidden font-size-14 break-all line-height-1_5 border-box webkit-box webkit-vertical webkit-clamp-3'>
                                    <strong>$row[title]</strong>
                                </div>
                            </div>
                        </a>
                        <div class='font-size-12 line-height-1'>
                            <a class='color-darkgray underline' href='/media/site/$row[site_domain_name]'>$row[site_domain_name]</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($row['up']) . "</span>
                        </div>
                    </div>";
                    if ($i != 10) {
                        echo "<hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                    }
                    $i++;
                }
            echo "</div>
        </div>
    </main>";
}

function new_more($new_sql) {
    global $mysqli;
    $result_news = $mysqli->query($new_sql);
    while ($row = $result_news->fetch_assoc()) {
        $news_id = $row["news_id"];
        $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
        $count = $result->fetch_row();
        $comment_count = $count[0];
        $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
        $count = $result->fetch_row();
        $comment_count += $count[0];
        $title = $row["title"];
        if (is_null($row["image"])) {
            $image = "noimage.jpeg";
        } else {
            if (user_agent() == false) {
                $filename = "app";
            } else {
                $filename = "crop";
            }
            if (file_exists("/var/www/html/${filename}/$row[image]")) {
                $image = $row["image"];
            } else {
                $image = "noimage.jpeg";
            }
        }
        $site_domain_name = $row["site_domain_name"];
        $up = $row["up"];
        $result = $mysqli->query("SELECT twitter_id, tweet, name, screen, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1");
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 1) {
            $row = $result->fetch_assoc();
            $twitter_id = $row["twitter_id"];
            $tweet = $row["tweet"];
            $icon = $row["icon"];
            $screen = $row["screen"];
            $name_screen = $row["name"] . "@" . $screen;
        }
        echo "<div class='width-100pe-718 margin-0-auto-1125'>
            <div class='margin-top-24 radius-8 background-white'>
                <div class='height-64-768 padding-top-16-768 padding-right-16-768 padding-bottom-4-768 padding-left-16-768'>
                    <a class='inline-flex-768 black-link black-visited red-opacity' href='/news/${news_id}'>
                        <img class='width-100pe-767 height-64-768 radius-8-8-0-0 radius-8-768 vertical-align-top' src='/${filename}/${image}'>
                        <div class='margin-top_4-768 padding-top-12-767 padding-right-16-767 padding-left-16 overflow-hidden-768 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-3-768'>
                            <strong>${title}</strong>
                        </div>
                    </a>
                </div>
                <div class='padding-top-12 padding-right-16 padding-left-16 padding-bottom-16'>
                    <div class='font-size-12 line-height-1'>
                        <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                    </div>
                </div>
                <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                if ($comment_count != 0) {
                    echo "<div class='padding-16'>
                        <div class='flex'>
                            <a href='/profile/id/${twitter_id}'>
                                <img src='${icon}' class='width-32 height-32 radius-50'>
                            </a>
                            <div class='min-width'>
                                <div class='padding-bottom-12 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1 border-box'>
                                    <a class='color-black underline' href='/profile/id/${twitter_id}'>
                                        <strong>$name_screen</strong>
                                    </a>
                                </div>
                                <div class='padding-left-16 overflow-hidden font-size-14 pre-line line-height-1_5'>${tweet}</div>
                            </div>
                        </div>
                        <div class='flex padding-top-13'>";
                            if ($comment_count < 4) {
                                $result = $mysqli->query("SELECT twitter_id FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 0, 3");
                            } else {
                                $result = $mysqli->query("SELECT twitter_id FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1, 3");
                            }
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='/profile/id/$row[twitter_id]'>";
                                $result_icon = $mysqli->query("SELECT icon FROM comment WHERE twitter_id = '$row[twitter_id]' ORDER BY up DESC LIMIT 1");
                                if (mysqli_num_rows($result_icon)) {
                                    $row = $result_icon->fetch_assoc();
                                }
                                    echo "<img src='$row[icon]' class='width-24 height-24 margin-right-6 radius-50 vertical-align-top'>
                                </a>";
                            }
                            echo "<div class='font-size-12 line-height-24'>
                                <strong>${comment_count}</strong>コメント
                            </div>
                        </div>
                    </div>";
                } else {
                    echo "<div class='padding-top-16 padding-left-16 padding-bottom-16 border-box font-size-14 line-height-1'>まだコメントはありません</div>";
                }
            echo "</div>
        </div>";
    }
}

function word_main($news_count, $list, $word_sql, $word, $side_flag) {
    global $mysqli;
    echo "<main class='width-auto padding-24'>";
    if ($news_count == 0) {
        echo "<div class='margin-top-48 font-size-36-48 text-align-center line-height-1'>
            <strong>404&nbsp;Not&nbsp;Found</strong>
        </div>
        <div class='margin-top-24 text-align-center'><img src='/logo_384.png' class='width-256-767'></div>
        <div class='margin-top-24 text-align-center line-height-1 redirect'>ページが見つかりません</div>";
    } else {
        echo "<ul class='flex list-style-type-none width-718-1078 margin-48-auto-0 padding-left-0 font-size-12 nowrap'>
            <li class='breadcrumb line-height-1'><a href='/' class='color-black underline'><strong>トップ</strong></a></li>
            <li class='breadcrumb line-height-1'>${word}</li>
        </ul>
        <div class='width-718-1078 margin-24-auto-0 font-size-14 line-height-1'>
              <strong>${word}</strong>の${list}&nbsp;-&nbsp;${news_count}件
        </div>
        <div class='flex-media-1126 justify-content-center margin-top-24'>
            <div>";
                $i = 0;
                $result_count = $mysqli->query($word_sql);
                while ($row = $result_count->fetch_assoc()) {
                    $news_id = $row["news_id"];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count = $row[0];
                    $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
                    $row = $result->fetch_row();
                    $comment_count += $row[0];
                    $result_news = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                    $row = $result_news->fetch_assoc();
                    $title = $row["title"];
                    if (is_null($row["image"])) {
                        $image = "noimage.jpeg";
                    } else {
                        if (user_agent() == false) {
                            $filename = "app";
                        } else {
                            $filename = "crop";
                        }
                        if (file_exists("/var/www/html/${filename}/$row[image]")) {
                            $image = $row["image"];
                        } else {
                            $image = "noimage.jpeg";
                        }
                    }
                    $site_domain_name = $row["site_domain_name"];
                    $up = $row["up"];
                    $result = $mysqli->query("SELECT twitter_id, tweet, name, screen, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1");
                    $num_rows = mysqli_num_rows($result);
                    if ($num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $twitter_id = $row["twitter_id"];
                        $tweet = $row["tweet"];
                        $icon = $row["icon"];
                        $screen = $row["screen"];
                        $name_screen = $row["name"] . "@" . $screen;
                    }
                    $margin_top24 = "";
                    if ($i != 0) {
                        $margin_top24 = "margin-top-24";
                    }
                    echo "<div class='width-100pe-718 margin-0-auto-1125'>
                        <div class='${margin_top24} radius-8 background-white'>
                            <div class='height-64-768 padding-top-16-768 padding-right-16-768 padding-bottom-4-768 padding-left-16-768'>
                                <a class='inline-flex-768 black-link black-visited red-opacity' href='/news/${news_id}'>
                                    <img class='width-100pe-767 height-64-768 radius-8-8-0-0 radius-8-768 vertical-align-top' src='/${filename}/${image}'>
                                    <div class='margin-top_4-768 padding-top-12-767 padding-right-16-767 padding-left-16 overflow-hidden-768 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-3-768'>
                                        <strong>${title}</strong>
                                    </div>
                                </a>
                            </div>
                            <div class='padding-top-16 padding-right-16 padding-left-16 padding-bottom-16'>
                                <div class='font-size-12 line-height-1'>
                                    <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                                </div>
                            </div>
                            <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                            if ($comment_count != 0) {
                                echo "<div class='padding-16'>
                                    <div class='flex'>
                                        <a href='/profile/id/${twitter_id}'>
                                            <img src='${icon}' class='width-32 height-32 radius-50'>
                                        </a>
                                        <div class='min-width'>
                                            <div class='padding-bottom-12 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1 border-box'>
                                                <a class='color-black underline' href='/profile/id/${twitter_id}'>
                                                    <strong>$name_screen</strong>
                                                </a>
                                            </div>
                                            <div class='padding-left-16 overflow-hidden font-size-14 pre-line line-height-1_5'>${tweet}</div>
                                        </div>
                                    </div>
                                    <div class='flex padding-top-13'>";
                                        if ($comment_count < 4) {
                                            $result = $mysqli->query("SELECT twitter_id FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 0, 3");
                                        } else {
                                            $result = $mysqli->query("SELECT twitter_id FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1, 3");
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<a href='/profile/id/$row[twitter_id]'>";
                                            $result_icon = $mysqli->query("SELECT icon FROM comment WHERE twitter_id = '$row[twitter_id]' ORDER BY up DESC LIMIT 1");
                                            if (mysqli_num_rows($result_icon)) {
                                                $row = $result_icon->fetch_assoc();
                                            }
                                                echo "<img src='$row[icon]' class='width-24 height-24 margin-right-6 radius-50 vertical-align-top'>
                                            </a>";
                                        }
                                        echo "<div class='font-size-12 line-height-24'>
                                            <strong>${comment_count}</strong>コメント
                                        </div>
                                    </div>
                                </div>";
                            } else {
                                echo "<div class='padding-top-16 padding-left-16 padding-bottom-16 border-box font-size-14 line-height-1'>まだコメントはありません</div>";
                            }
                        echo "</div>
                    </div>";
                    $i++;
                }
                if ($news_count > 20) {
                    $count_down = $news_count - 20;
                    echo "<span class='news-read'></span>
                    <div class='margin-top-24'>
                        <button class='block width-50pe height-48 margin-auto background-white border-width-1 border-style-solid border-color-black radius-3 color-black font-size-16 text-align-center decoration-none line-height-48 transition-400ms more-button' type='submit'>
                            あと${count_down}件
                        </button>
                    </div>";
                }
                echo "<div class='margin-top-24 line-height-1'>
                    <strong>最新のコメント</strong>
                </div>";
                $result_with = $mysqli->query("SELECT DISTINCT news_id, twitter_id, tweet, name, screen, icon, up FROM `comment` ORDER BY comment_id DESC LIMIT 20");
                while ($row = $result_with->fetch_assoc()) {
                    $news_id = $row["news_id"];
                    $twitter_id_with = $row["twitter_id"];
                    $tweet = $row["tweet"];
                    $screen = $row["screen"];
                    $name_screen_with = $row["name"] . "@" . $screen;
                    $icon = $row["icon"];
                    $up = $row["up"];
                    $result = $mysqli->query("SELECT title FROM news WHERE news_id = '${news_id}'");
                    $row = $result->fetch_assoc();
                    echo "<div class='margin-top-24 width-100pe-718 radius-8 background-white'>
                        <div class='padding-top-16 padding-right-16 padding-bottom-13 padding-left-16'>
                            <div class='flex'>
                                <a href='/profile/id/${twitter_id_with}'>
                                    <img src='${icon}' class='width-42 height-42 radius-50'>
                                </a>
                                <div class='min-width margin-left-16'>
                                    <div class='padding-bottom-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                                        <a class='color-black underline' href='/profile/id/${twitter_id_with}'><strong>${name_screen_with}</strong></a>
                                    </div>
                                    <div class='overflow-hidden color-darkgray font-size-12 overflow-ellipsis nowrap line-height-1'>" . convert_to_fuzzy_time($up) . "</div>
                                </div>
                            </div>
                            <div class='margin-top-12 font-size-14 pre-line line-height-1_5'>${tweet}</div>
                        </div>
                        <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>
                        <div class='padding-top-12 padding-right-16 padding-bottom-12 padding-left-16 line-height-1_5 border-box'>
                            <a class='color-black underline' href='/news/${news_id}'>
                                <strong>$row[title]</strong>
                            </a>
                        </div>
                    </div>";
                }
                echo "</div>
                <div class='margin-left-24-768 none-768-1125'>
                    <div class='none-767'>
                        <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3690883624273126' crossorigin='anonymous'></script>
                        <!-- 336×280 -->
                        <ins class='adsbygoogle' style='display:inline-block;width:336px;height:280px' data-ad-client='ca-pub-3690883624273126' data-ad-slot='3962796783'></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                    <div class='margin-top-24 line-height-1'>
                        <strong>注目のワード</strong>
                    </div>
                    <div class='width-100pe-336 margin-top-24 padding-left-16 padding-bottom-16 radius-8 background-white border-box'>";
                    $array = [];
                    $result = $mysqli->query("SELECT DISTINCT tag_id FROM news_to_tag WHERE news_id IN (SELECT news_id FROM news_count WHERE category = 1 ORDER BY count DESC)");
                    while ($row = $result->fetch_assoc()) {
                        $array[] = $row["tag_id"];
                    }
                    arsort($array);
                    foreach ($array as $tag_id) {
                        $result = $mysqli->query("SELECT tag FROM tag WHERE tag_id = ${tag_id}");
                        $row = $result->fetch_assoc();
                        echo "<a class='inline-block background-dcdcdc height-30 margin-top-16 margin-right-16 padding-right-8 padding-left-8 border-width-1 border-style-solid border-color-black radius-4 color-black font-size-14 line-height-30 pointer tag-button' href='/tag/${tag_id}'>$row[tag]</a>";
                    }
                    echo "</div>";
                    $array = [];
                    $result = $mysqli->query("SELECT site_domain_name FROM news GROUP BY site_domain_name having count(*) >= 20");
                    while ($row = $result->fetch_assoc()) {
                        $array[] = $row["site_domain_name"];
                    }
                    $key = array_rand($array);
                    echo "<div class='margin-top-24 none-767'>
                        <script type='text/javascript'>
                            rakuten_design='slide';
                            rakuten_affiliateId='12ea5223.d4a53d6c.12ea5224.9a86d468';
                            rakuten_items='ctsmatch';
                            rakuten_genreId='0';
                            rakuten_size='336x280';
                            rakuten_target='_blank';
                            rakuten_theme='gray';
                            rakuten_border='off';
                            rakuten_auto_mode='on';
                            rakuten_genre_title='off';
                            rakuten_recommend='on';
                            rakuten_ts='1638160942761';
                        </script>
                        <script type='text/javascript' src='https://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget.js'></script>
                    </div>
                    <div class='margin-top-24 line-height-1'>
                        <div class='font-size-12'>
                            <strong>その他の提供メディア</strong>
                        </div>
                        <div class='margin-top-16 font-size-14'>
                            <a href='/media/site/" . $array[$key] . "' class='color-black underline'>
                                <strong>" . $array[$key] . "</strong>
                            </a>
                        </div>
                    </div>
                    <div class='width-100pe-336 margin-top-24 radius-8 background-white'>";
                        $result_ranking = $mysqli->query("SELECT news_id FROM news WHERE site_domain_name = '" . $array[$key] . "' ORDER BY UP DESC LIMIT 20");
                        while ($row = $result_ranking->fetch_assoc()) {
                            $news_id = $row["news_id"];
                            $result = $mysqli->query("SELECT title, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                            $row = $result->fetch_assoc();
                            if (is_null($row["image"])) {
                                $image = "noimage.jpeg";
                            } else {
                                $filename = "/var/www/html/app/" . $row["image"];
                                if (file_exists($filename)) {
                                    $image = $row["image"];
                                } else {
                                    $image = "noimage.jpeg";
                                }
                            }
                            echo "<div class='width-100pe-336 padding-16 border-box'>
                                <a class='inline-flex height-58 padding-bottom-16 black-link black-visited red-opacity' href='/news/${news_id}'>
                                    <img class='height-58 radius-8' src='/app/${image}'>
                                    <div class='margin-left-16'>
                                        <div class='height-61 margin-top_3 overflow-hidden font-size-14 break-all line-height-1_5 border-box webkit-box webkit-vertical webkit-clamp-3'>
                                            <strong>$row[title]</strong>
                                        </div>
                                    </div>
                                </a>
                                <div class='font-size-12 line-height-1'>
                                    <a class='color-darkgray underline' href='/media/site/$row[site_domain_name]'>$row[site_domain_name]</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($row['up']) . "</span>
                                </div>
                            </div>
                            <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                        }
                    echo "</div>
                </div>
            </div>
        </div>";
    }
    echo "</main>";
}

function word_more($word_sql) {
    global $mysqli;
    $result_news_id = $mysqli->query($word_sql);
    while ($row = $result_news_id->fetch_assoc()) {
        $news_id = $row["news_id"];
        $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
        $count = $result->fetch_row();
        $comment_count = $count[0];
        $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
        $count = $result->fetch_row();
        $comment_count += $count[0];
        $result_news = $mysqli->query("SELECT title, url, image, description, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
        $row = $result_news->fetch_assoc();
        $title = $row["title"];
        if (is_null($row["image"])) {
            $image = "noimage.jpeg";
        } else {
            if (user_agent() == false) {
                $filename = "app";
            } else {
                $filename = "crop";
            }
            if (file_exists("/var/www/html/${filename}/$row[image]")) {
                $image = $row["image"];
            } else {
                $image = "noimage.jpeg";
            }
        }
        $site_domain_name = $row["site_domain_name"];
        $up = $row["up"];
        $result = $mysqli->query("SELECT twitter_id, tweet, name, screen, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1");
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 1) {
            $row = $result->fetch_assoc();
            $twitter_id = $row["twitter_id"];
            $tweet = $row["tweet"];
            $icon = $row["icon"];
            $screen = $row["screen"];
            $name_screen = $row["name"] . "@" . $screen;
        }
        echo "<div class='width-100pe-718 margin-0-auto-1125'>
            <div class='margin-top-24 radius-8 background-white'>
                <div class='height-64-768 padding-top-16-768 padding-right-16-768 padding-bottom-4-768 padding-left-16-768'>
                    <a class='inline-flex-768 black-link black-visited red-opacity' href='/news/${news_id}'>
                        <img class='width-100pe-767 height-64-768 radius-8-8-0-0 radius-8-768 vertical-align-top' src='/${filename}/${image}'>
                        <div class='margin-top_4-768 padding-top-12-767 padding-right-16-767 padding-left-16 overflow-hidden-768 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-3-768'>
                            <strong>${title}</strong>
                        </div>
                    </a>
                </div>
                <div class='padding-top-12 padding-right-16 padding-left-16 padding-bottom-16'>
                    <div class='font-size-12 line-height-1'>
                        <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                    </div>
                </div>
                <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                if ($comment_count != 0) {
                    echo "<div class='padding-16'>
                        <div class='flex'>
                            <a href='/profile/id/${twitter_id}'>
                                <img src='${icon}' class='width-32 height-32 radius-50'>
                            </a>
                            <div class='min-width'>
                                <div class='padding-bottom-12 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1 border-box'>
                                    <a class='color-black underline' href='/profile/id/${twitter_id}'>
                                        <strong>$name_screen</strong>
                                    </a>
                                </div>
                                <div class='padding-left-16 overflow-hidden font-size-14 pre-line line-height-1_5'>${tweet}</div>
                            </div>
                        </div>
                        <div class='flex padding-top-13'>";
                            if ($comment_count < 4) {
                                $result = $mysqli->query("SELECT twitter_id FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 0, 3");
                            } else {
                                $result = $mysqli->query("SELECT twitter_id FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1, 3");
                            }
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='/profile/id/$row[twitter_id]'>";
                                $result_icon = $mysqli->query("SELECT icon FROM comment WHERE twitter_id = '$row[twitter_id]' ORDER BY up DESC LIMIT 1");
                                if (mysqli_num_rows($result_icon)) {
                                    $row = $result_icon->fetch_assoc();
                                }
                                    echo "<img src='$row[icon]' class='width-24 height-24 margin-right-6 radius-50 vertical-align-top'>
                                </a>";
                            }
                            echo "<div class='font-size-12 line-height-24'>
                                <strong>${comment_count}</strong>コメント
                            </div>
                        </div>
                    </div>";
                } else {
                    echo "<div class='padding-top-16 padding-left-16 padding-bottom-16 border-box font-size-14 line-height-1'>まだコメントはありません</div>";
                }
            echo "</div>
        </div>";
    }
}
