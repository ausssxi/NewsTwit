<?php
ini_set('display_errors', "On");
session_start();
require "fuzzy_time.php";
require __DIR__ . '/vendor/autoload.php';
require_once "functions.php";
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
if (isset($_SESSION["id"])) {
    $flag = 1;
    $session = $_SESSION["id"];
} else {
    $flag = 0;
    $session = 0;
}
$result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '$_GET[id]'");
$row = $result->fetch_row();
$comment_count_self = $row[0];
$comment_count = $comment_count_self;
$result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '$_GET[id]'");
$row = $result->fetch_row();
$comment_count += $row[0];
$result = $mysqli->query("SELECT title, url, image, description, site_domain_name, up FROM news WHERE news_id = '$_GET[id]'");
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0) {
    $title = "404&nbsp;Not&nbsp;Found";
}
$row = $result->fetch_assoc();
if (is_null($row["image"])) {
    $image = "noimage.jpeg";
} else {
    $filename = "/var/www/html/crop/" . $row["image"];
    if (file_exists($filename)) {
        $image = $row["image"];
    } else {
        $image = "noimage.jpeg";
    }
    $title = $row["title"];
    $url = $row["url"];
    $description = $row["description"];
    $site_domain_name = $row["site_domain_name"];
    $up = $row["up"];
}
$og_url = "https://newstwit.jp/news/$_GET[id]";
$title_comment_count = "${title}（${comment_count}件のコメント）";
?>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@NewsTweet_jp" />
        <meta property="og:url" content="<?php echo $og_url; ?>" />
        <meta property="og:title" content="<?php echo $title_comment_count; ?>" />
        <meta property="og:description" content="<?php echo $description; ?>" />
        <meta property="og:image" content="https://newstwit.jp/crop/<?php echo $image; ?>" />
        <link rel="stylesheet" type="text/css" href="/style.css">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
        <link rel="canonical" href="https://newstwit.jp/news/<?php echo $_GET["id"]; ?>">
        <title><?php echo $title; ?></title>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-149633438-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-149633438-1');
        </script>
    </head>
    <body>
        <?php
        header_html();
        toggle();
        ?>
        <main class='width-auto padding-24'>
        <?php
        if ($num_rows == 0) {
            echo "<div class='margin-top-48 font-size-36-48 text-align-center line-height-1'>
                <strong>404&nbsp;Not&nbsp;Found</strong>
            </div>
            <div class='margin-top-24 text-align-center'><img src='/logo_384.png' class='width-256-767'></div>
            <div class='margin-top-24 text-align-center line-height-1 redirect'>ページが見つかりません</div>";
        } else {
            $array = [];
            $result = $mysqli->query("SELECT tag_id FROM news_to_tag WHERE news_id = $_GET[id]");
            while ($row = $result->fetch_assoc()) {
                $array[] = $row["tag_id"];
            }
            foreach ($array as $tag_id) {
                switch ($tag_id) {
                    case 9081975:
                        $category = "<a href='/entame' class='color-black underline'><strong>芸能・スポーツ</strong></a>";
                        break;
                    case 9082120:
                        $category = "<a href='/anime' class='color-black underline'><strong>アニメ・ゲーム</strong></a>";
                        break;
                    case 9081948:
                        $category = "<a href='/it' class='color-black underline'><strong>IT・科学</strong></a>";
                        break;
                    case 9081963:
                        $category = "<a href='/learn' class='color-black underline'><strong>教育・学習</strong></a>";
                        break;
                    case 9081976:
                        $category = "<a href='/life' class='color-black underline'><strong>生活</strong></a>";
                        break;
                    case 9081934:
                        $category = "<a href='/politics' class='color-black underline'><strong>政治・経済</strong></a>";
                        break;
                    case 9081943:
                        $category = "<a href='/society' class='color-black underline'><strong>社会</strong></a>";
                        break;
                }
            }
            echo "<ul class='flex list-style-type-none width-718-1078 margin-48-auto-0 padding-left-0 font-size-12 nowrap'>
                <li class='breadcrumb line-height-1'><a href='/' class='color-black underline'><strong>トップ</strong></a></li>
                <li class='breadcrumb line-height-1'>${category}</li>
                <li class='breadcrumb overflow-hidden overflow-ellipsis line-height-1'>${title}</li>
            </ul>
            <div class='flex-media-1126 justify-content-center margin-top-24'>
                <div class='width-100pe-718 margin-0-auto-1125'>
                    <div class='radius-8 background-white'>
                        <a class='black-link black-visited red-opacity' href='${url}' target='_blank'>
                            <img class='width-100pe radius-8-8-0-0 vertical-align-top' src='/crop/${image}'>
                            <div class='padding-top-12 padding-right-16 padding-left-16'>
                                <div class='line-height-1_5'>
                                    <strong>${title}</strong>
                                </div>
                            </div>
                        </a>
                        <div class='padding-top-9 padding-right-16 padding-left-16 padding-bottom-16'>
                            <div class='color-darkgray font-size-12 pre-line line-height-1_5'>${description}</div>";
                            if ($description) {
                                echo "<div class='margin-top-13 font-size-12 line-height-1'>";
                            } else {
                                echo "<div class='margin-top-12 font-size-12 line-height-1'>";
                            }
                                echo "<a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                            </div>
                            <div class='margin-top-12 font-size-0'>";
                                foreach ($array as $tag_id) {
                                    $result = $mysqli->query("SELECT tag FROM tag WHERE tag_id = ${tag_id}");
                                    $row = $result->fetch_assoc();
                                    echo "<a class='inline-block background-dcdcdc height-19 margin-top-4 margin-right-4 padding-right-4 padding-left-4 border-width-1 border-style-solid border-color-black radius-4 color-black font-size-11 line-height-19 pointer tag-button' href='/tag/${tag_id}'>$row[tag]</a>";
                                }
                            echo "</div>
                            <div class='margin-top-16'>
                                <a class='block width-50pe height-48 margin-auto border-width-1 border-style-solid border-color-black radius-3 color-black text-align-center decoration-none line-height-48 transition-400ms article-button' href='${url}' target='_blank'>
                                    記事を読む
                                </a>
                            </div>
                        </div>
                    </div>";
                    if ($comment_count > 0 || isset($_SESSION["id"])) {
                        echo "<div class='margin-top-24 padding-top-16 radius-8 background-white border-box'>";
                        if (isset($_SESSION["id"])) {
                            $result = $mysqli->query("SELECT icon FROM user WHERE user_id = $_SESSION[id]");
                            $row = $result->fetch_assoc();
                            echo "<div class='padding-right-16 padding-bottom-16 padding-left-16'>
                                <div class='flex'>
                                    <img src='/thumbnail/$row[icon]' class='width-42 height-42 margin-right-16 radius-50'>
                                    <textarea class='width-100pe height-42 block textarea' placeholder='コメントを書く'></textarea>
                                </div>
                                <div class='margin-top-16 color-darkgray text-align-right'>
                                    <span class='margin-right-8 font-size-12'>シェアする</span><i class='fab fa-twitter fa-lg margin-right-8'></i><button class='border-width-1 border-style-solid border-color-black radius-4 color-black font-size-14 post-button' type='button'>コメントを投稿する</button>
                                </div>
                            </div>";
                        }
                        if ($comment_count > 0 && isset($_SESSION["id"])) {
                            echo "<hr class='clear-both height-1 margin-top-0 margin-right-0 margin-bottom-16 margin-left-0 border-none f0f0f0-c0c0c0'>";
                        }
                        echo "<span class='post-read'></span>";
                        $i = 0;
                        $result_comment_self = $mysqli->query("SELECT user_id, comment, up FROM comment_self WHERE news_id = '$_GET[id]' ORDER BY up DESC, news_id DESC LIMIT 20");
                        while ($row = $result_comment_self->fetch_assoc()) {
                            $user_id = $row["user_id"];
                            $comment = $row["comment"];
                            $up = $row["up"];
                            $result = $mysqli->query("SELECT twitter_id, name, screen, icon FROM user WHERE user_id = '${user_id}'");
                            $row = $result->fetch_assoc();
                            $name_screen = $row["name"] . "@" . $row["screen"];
                            echo "<div class='padding-right-16 padding-bottom-13 padding-left-16'>
                                <div class='flex'>
                                    <a href='/profile/id/$row[twitter_id]'>
                                        <img src='/thumbnail/$row[icon]' class='width-42 height-42 radius-50'>
                                    </a>
                                    <div class='min-width margin-left-16'>
                                        <div class='padding-bottom-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                                            <a class='color-black underline' href='/profile/id/$row[twitter_id]'><strong>${name_screen}</strong></a>
                                        </div>
                                        <div class='overflow-hidden color-darkgray font-size-12 overflow-ellipsis nowrap line-height-1'>" . convert_to_fuzzy_time($up) . "</div>
                                    </div>
                                </div>
                                <div class='margin-top-12 font-size-14 pre-line line-height-1_5'>${comment}</div>
                            </div>";
                            if ($comment_count < 20) {
                                if ($i < ($comment_count - 1)) {
                                    echo "<hr class='clear-both height-1 margin-top-0 margin-right-0 margin-bottom-16 margin-left-0 border-none f0f0f0-c0c0c0'>";
                                } elseif ($i == ($comment_count - 1)) {
                                    echo "<div class='height-12 radius-0-0-8-8 background-white'>
                                    </div>";
                                }
                            }  elseif ($i < 19) {
                                echo "<hr class='clear-both height-1 margin-top-0 margin-right-0 margin-bottom-16 margin-left-0 border-none f0f0f0-c0c0c0'>";
                            }
                            $i++;
                        }
                        $limit = 20 - $i;
                        $result = $mysqli->query("SELECT twitter_id, tweet, name, screen, up FROM comment WHERE news_id = '$_GET[id]' ORDER BY up DESC, news_id DESC LIMIT ${limit}");
                        while ($row = $result->fetch_assoc()) {
                            $result_icon = $mysqli->query("SELECT icon FROM comment WHERE twitter_id = '$row[twitter_id]' ORDER BY up DESC LIMIT 1");
                            if (mysqli_num_rows($result_icon)) {
                                $row_icon = $result_icon->fetch_assoc();
                            }
                            $name_screen = $row["name"] . "@" . $row["screen"];
                            echo "<div class='padding-right-16 padding-bottom-13 padding-left-16'>
                                <div class='flex'>
                                    <a href='/profile/id/$row[twitter_id]'>
                                        <img src='$row_icon[icon]' class='width-42 height-42 radius-50'>
                                    </a>
                                    <div class='min-width margin-left-16'>
                                        <div class='padding-bottom-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                                            <a class='color-black underline' href='/profile/id/$row[twitter_id]'><strong>${name_screen}</strong></a>
                                        </div>
                                        <div class='overflow-hidden color-darkgray font-size-12 overflow-ellipsis nowrap line-height-1'>" . convert_to_fuzzy_time($row["up"]) . "</div>
                                    </div>
                                </div>
                                <div class='margin-top-12 font-size-14 pre-line line-height-1_5'>$row[tweet]</div>
                            </div>";
                            if ($comment_count < 20) {
                                if ($i < ($comment_count - 1)) {
                                    echo "<hr class='clear-both height-1 margin-top-0 margin-right-0 margin-bottom-16 margin-left-0 border-none f0f0f0-c0c0c0'>";
                                }
                            }  elseif ($i < 19) {
                                echo "<hr class='clear-both height-1 margin-top-0 margin-right-0 margin-bottom-16 margin-left-0 border-none f0f0f0-c0c0c0'>";
                            }
                            $i++;
                        }
                        echo "<span class='comment-read'></span>";
                        if ($comment_count > 20) {
                            $count_down = $comment_count - 20;
                            echo "<div class='padding-bottom-16'>
                                <button class='block width-50pe height-48 margin-auto background-white border-width-1 border-style-solid border-color-black radius-3 color-black font-size-16 text-align-center decoration-none line-height-48 transition-400ms article-button more' ontouchstart=''　type='submit'>あと${count_down}件</button>
                            </div>";
                        }
                        echo "</div>";
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
                    </div>";
                        $i = 0;
                        $result_with = $mysqli->query("SELECT DISTINCT news_id FROM news_to_tag WHERE news_id != '$_GET[id]' AND tag_id = (SELECT tag_id FROM news_to_tag WHERE news_id = '$_GET[id]' ORDER BY tag_id ASC LIMIT 1) ORDER BY news_id DESC LIMIT 20");
                        if (mysqli_num_rows($result_with) != 0) {
                            echo "<div class='margin-top-24 line-height-1'>
                                <strong>合わせて読みたい</strong>
                            </div>";
                            while ($row = $result_with->fetch_assoc()) {
                                if ($i == 10) {
                                    break;
                                }
                                $news_id = $row["news_id"];
                                $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE news_id = '${news_id}'");
                                $count = $result->fetch_row();
                                $comment_count_with = $count[0];
                                $result = $mysqli->query("SELECT COUNT(*) FROM comment WHERE news_id = '${news_id}'");
                                $count = $result->fetch_row();
                                $comment_count_with += $count[0];
                                $result_news = $mysqli->query("SELECT title, url, image, site_domain_name, up FROM news WHERE news_id = '${news_id}'");
                                $row = $result_news->fetch_assoc();
                                $title = $row["title"];
                                $url = $row["url"];
                                $site_domain_name = $row["site_domain_name"];
                                $up = $row["up"];
                                if (is_null($row["image"])) {
                                    $image = "noimage.jpeg";
                                } else {
                                    $filename = "/var/www/html/crop/" . $row["image"];
                                    if (file_exists($filename)) {
                                        $image = $row["image"];
                                    } else {
                                        $image = "noimage.jpeg";
                                    }
                                }
                                if ($comment_count_with > 0) {
                                    $result = $mysqli->query("SELECT twitter_id, tweet, name, screen, icon, up FROM comment WHERE news_id = '${news_id}' ORDER BY up DESC LIMIT 1");
                                    $row = $result->fetch_assoc();
                                    $twitter_id = $row["twitter_id"];
                                    $tweet = $row["tweet"];
                                    $icon = $row["icon"];
                                    $name_screen = $row["name"] . "@" . $row["screen"];
                                    echo "<div class='width-100pe-336 margin-top-24 radius-8 background-white'>
                                        <a class='black-link black-visited red-opacity' href='/news/${news_id}'>
                                            <img class='width-100pe-336 radius-8-8-0-0 vertical-align-top' src='/crop/${image}'>
                                            <div class='height-84-768 padding-top-12 padding-right-16 padding-left-16 overflow-hidden line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-3-768 border-box'>
                                                <strong>${title}</strong>
                                            </div>
                                        </a>
                                        <div class='padding-top-12 padding-left-16 padding-bottom-13 padding-right-16 font-size-12 line-height-1'>
                                            <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                                        </div>
                                        <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>
                                        <div class='padding-16'>
                                            <div class='flex'>
                                                <a href='/profile/id/${twitter_id}'>
                                                    <img src='${icon}' class='width-32 height-32 radius-50'>
                                                </a>
                                                <div class='min-width'>
                                                    <div class='height-17 padding-bottom-10 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                                                        <a class='color-black underline' href='/profile/id/${twitter_id}'>
                                                            <strong>${name_screen}</strong>
                                                        </a>
                                                    </div>
                                                    <div class='height-84-768 padding-left-16 overflow-hidden font-size-14 pre-line-767 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-4'>${tweet}</div>
                                                </div>
                                            </div>
                                            <div class='flex padding-top-12'>";
                                                if ($comment_count_with < 4) {
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
                                                    <strong>${comment_count_with}</strong>コメント
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                    $i++;
                                }
                            }
                        }

                echo "</div>
            </div>";
        }
        ?>
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

                    var id = "<?php echo $_GET['id']; ?>";
                    var count = "<?php echo $comment_count; ?>";
                    var count_self = "<?php echo $comment_count_self; ?>";
                    var limit = 0;
                    var limit_self = 0;
                    var flag = "<?php echo $flag; ?>";
                    if (Number(flag)) {
                        var user_id = "<?php echo $session; ?>";
                    }
                    var offset = 0;
                    var offset_self = 1;
                    var bool = 0;
                    if (count_self > 0) {
                        limit = count_self % 20;
                    } else {
                        offset = 1;
                    }

                    $(function() {
                        $('.more').on('click', function() {
                            count = count - 20;
                            more();
                            if (count_self <= (offset_self * 20)) {
                                offset++;
                            }
                            offset_self++;
                        });

                        if($(".post-button").length) {
                            $('.post-button').on('click', function() {
                                post();
                            });
                        }

                        if($(".fa-twitter").length) {
                            $('.fa-twitter').on('click', function() {
                                $(this).toggleClass('isActive');
                                if (bool) {
                                    bool = 0;
                                } else {
                                    bool = 1;
                                }
                            });
                        }
                    });

                    function more() {
                        if (count > 0) {
                            var more = $(".more");
                            more.addClass("flex align-items-center justify-content-center");
                            more.html("<img src ='/loading.gif'>");
                            var getData = {"offset":offset,"offset_self":offset_self,"id":id,"limit":limit,"limit_self":limit_self};
                            $.get("/news_more.php", getData, function(rs) {
                                $(".comment-read").append(rs);
                            }).always(function(data) {
                                more.removeClass("flex align-items-center justify-content-center");
                                let count_down = count - 20;
                                if (count < 21) {
                                    more.remove();
                                } else {
                                    more.html("あと" + count_down + "件");
                                }
                            });
                        }
                    }
                    function post() {
                        var textarea_val =　$('.textarea').val();
                        $.post("/post.php", {
                            "news_id":id, "user_id":user_id, "comment":textarea_val, "bool":bool
                        }, function(data) {
                            $('textarea').toggleClass('animation-duration-0_8 animation-delay-0_5 animation-iteration-count-2 animation-direction-alternate animation-play-state-running expansion');
                            window.setTimeout(function() {
                                $(".textarea").val("");
                                window.setTimeout(function() {
                                    $('textarea').toggleClass('animation-duration-0_8 animation-delay-0_5 animation-iteration-count-2 animation-direction-alternate animation-play-state-running expansion');
                                    $.get("/news_one.php", {"id":id}, function(rs) {
                                        $(".post-read").prepend(rs);
                                        limit_self++;
                                    });
                                }, 1500);
                            }, 1000);
                        });
                    }
                    $(function() {
                        if($(".redirect").length) {
                            setTimeout(function() {
                                window.location.href = "/";
                            }, 3000);
                        }
                    });
                });
            })(jQuery);
        </script>
    </body>
</html>
