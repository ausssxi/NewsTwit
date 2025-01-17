<?php
ini_set('display_errors', "On");
session_start();
require "fuzzy_time.php";
require_once "functions.php";
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
$date_yesterday = date('Y-m-d', strtotime("-1 day"));

function index_main($category_name, $category_href, $category_number) {
    echo "<div class='margin-bottom-24 padding-16 radius-8 background-dfdfdf border-box'>
        <div class='flex-768 space-between-768'>
            <div class='font-size-24 line-height-1'>
                <strong>${category_name}</strong>
            </div>
            <div class='font-size-14 line-height-14 none-767'>
                <a href='/${category_href}' class='color-black underline'>${category_name}&nbsp;記事一覧を見る</a>
            </div>
        </div>
        <div class='flex-768 justify-content-center'>";
            global $mysqli;
            $result_news_count = $mysqli->query("SELECT news_id FROM news_count WHERE category = ${category_number} ORDER BY count DESC LIMIT 3");
            while ($row = $result_news_count->fetch_assoc()) {
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
                    $filename = "/var/www/html/crop/$row[image]";
                    if (file_exists($filename)) {
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
                $name_screen = $row["name"] . "@" . $row["screen"];
                echo "<div class='width-100pe-218 margin-top-16 radius-8 background-white margin-right-16-768'>
                    <a class='black-link black-visited red-opacity' href='/news/${news_id}'>
                        <img class='width-100pe-218 radius-8-8-0-0 vertical-align-top' src='/crop/${image}'>
                        <div class='height-84-768 padding-top-12 padding-right-16 padding-left-16 overflow-hidden break-all border-box webkit-box-768 webkit-vertical-768 webkit-clamp-3-768'>
                            <strong>${title}</strong>
                        </div>
                    </a>
                    <div class='min-width'>
                        <div class='padding-top-12 padding-right-16 padding-bottom-16 padding-left-16 overflow-hidden font-size-12 overflow-ellipsis nowrap line-height-1'>
                            <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                        </div>
                    </div>
                    <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>
                    <div class='padding-16 border-box'>
                        <div class='flex'>
                            <a href='/profile/id/${twitter_id}'>
                                <img src='${icon}' class='width-32 height-32 radius-50'>
                            </a>
                            <div class='min-width'>
                                <div class='padding-bottom-12 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1 border-box'>
                                    <a class='color-black underline' href='/profile/id/${twitter_id}'>
                                        <strong>${name_screen}</strong>
                                    </a>
                                </div>
                                <div class='padding-left-16 overflow-hidden font-size-14 pre-line-767 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-4 height-84-768'>${tweet}</div>
                            </div>
                        </div>
                        <div class='flex padding-top-13'>";
                            $result = $mysqli->query("SELECT twitter_id, icon FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1, 3");
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='/profile/id/$row[twitter_id]'>
                                    <img src='$row[icon]' class='width-24 height-24 margin-right-6 radius-50 vertical-align-top'>
                                </a>";
                            }
                            echo "<div class='font-size-12 line-height-24'>
                                <strong>${comment_count}</strong>コメント
                            </div>
                        </div>
                    </div>
                </div>";
            }
            echo "<div class='padding-top-16 font-size-14 text-align-right line-height-1 border-box none-768'>
                <a href='/${category_href}' class='color-black underline none-768'>${category_name}&nbsp;記事一覧を見る</a>
            </div>
        </div>
    </div>";
}

function index_side_new($category_href, $category_name, $category_number) {
    echo "<div class='margin-top-24 font-size-12-14 line-height-1'>
        <a href='/new/${category_href}' class='color-black underline'>
            <strong>${category_name}（新着）</strong>
        </a>
    </div>
    <div class='margin-top-24 width-100pe-336 radius-8 background-white'>";
        global $mysqli;
        $result = $mysqli->query("SELECT news_id, count FROM news_new WHERE category = ${category_number}");
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
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="NewsTwitはTwitterでコメントしたニュースを、まとめたソーシャルニュースサイトです。Twitterで注目されているニュースがわかります。">
        <link rel="stylesheet" type="text/css" href="/style.css">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="canonical" href="https://newstwit.jp/">
        <title>NewsTwit｜Twitterで注目されているニュースが分かる</title>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-149633438-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-149633438-1');
        </script>
        <script type="text/javascript" src="/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <?php
        header_html();
        toggle();
        ?>
        <main class='width-auto padding-top-24 padding-right-24 padding-left-24'>
            <div class='flex-media-1126 justify-content-center margin-top-48'>
                <div class='width-100pe-718 margin-right-auto-1125 margin-left-auto-1125'>
                    <?php
                    index_main("総合", "all", 1);
                    index_main("芸能・スポーツ", "entame", 2);
                    index_main("アニメ・ゲーム", "anime", 3);
                    index_main("IT・科学", "it", 4);
                    index_main("教育・学習", "learn", 5);
                    index_main("生活", "life", 6);
                    index_main("政治・経済", "politics", 7);
                    index_main("社会", "society", 8);
                    ?>
                </div>
                <div class='margin-left-24-768 none-768-1125'>
                    <div class='none-767'>
                        <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3690883624273126' crossorigin='anonymous'></script>
                        <!-- 336×280 -->
                        <ins class='adsbygoogle' style='display:inline-block;width:336px;height:280px' data-ad-client='ca-pub-3690883624273126' data-ad-slot='3962796783'></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                    <?php
                    side_ranking("総合", 1, 0);
                    side_ranking("芸能・スポーツ", 2, 0);
                    side_ranking("アニメ・ゲーム", 3, 0);
                    side_ranking("IT・科学", 4, 0);
                    side_ranking("教育・学習", 5, 0);
                    side_ranking("生活", 6, 0);
                    side_ranking("政治・経済", 7, 0);
                    side_ranking("社会", 8, 0);
                    ?>
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
                    <?php
                    index_side_new("all", "総合", 1);
                    index_side_new("entame", "芸能・スポーツ", 2);
                    index_side_new("anime", "アニメ・ゲーム", 3);
                    index_side_new("it", "IT・科学", 4);
                    index_side_new("learn", "教育・学習", 5);
                    index_side_new("life", "生活", 6);
                    index_side_new("politics", "政治・経済", 7);
                    index_side_new("society", "社会", 8);
                    ?>
                    <div class='height-24'></div>
                </div>
            </div>
        </main>
        <?php
        ads_728();
        footer();
        ads_320();
        ?>
        <script type="text/javascript" src="/jquery-3.3.1.min.js"></script>
        <script>
            (function($) {
                $(function () {
                    $(document).on('click', function(e) {
          	            if (!$(e.target).closest('.toggle-menu').length && !$(e.target).closest('div.pointer').length && !$(e.target).closest('img.pointer').length) {
	    	                    $('div.width-192').removeAttr('id', 'show');
                            $('div.width-160').removeAttr('id', 'show');
	                      } else if ($(e.target).closest('div.pointer').length) {
	                 	        if ($("div.width-192").attr('id') === "show") {
			                          $('div.width-192').removeAttr('id', 'show');
		                        } else {
			                          $('div.width-192').attr('id', 'show');
                                $('div.width-160').removeAttr('id', 'show');
		                        }
                        } else if ($(e.target).closest('img.pointer').length) {
                            if ($("div.width-160").attr('id') === "show") {
                                $('div.width-160').removeAttr('id', 'show');
                            } else {
                                $('div.width-160').attr('id', 'show');
                                $('div.width-192').removeAttr('id', 'show');
                            }
                        }
                    });

                    $(".search-icon").first().on('click', function() {
                        var text =　$(".outline-none").first().val();
                        if (text) {
                            location.href = '/search/'　+ text;
                        }
                    });

                    $(".outline-none").first().keypress(function(e) {
                        if (e.which === 13) {
                            var text =　$(".outline-none").first().val();
                            if (text) {
                                location.href = '/search/'　+ text;
                            }
                        }
                    });
	              });
            })(jQuery);
        </script>
    </body>
</html>
