<?php
ini_set('display_errors', "On");
session_start();

use Abraham\TwitterOAuth\TwitterOAuth;

require "fuzzy_time.php";
require __DIR__ . '/vendor/autoload.php';
require_once "functions.php";
function user_agent() {
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if ((strpos($agent, 'Android') !== false) && (strpos($agent, 'Mobile') !== false) || (strpos($agent, 'iPhone') !== false)) {
        return true;
    }
}
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
if (isset($_GET['id'])) {
    $twitter_id = $_GET["id"];
}
if (isset($_GET['screen'])) {
    $CK = 'FH0NETnaKpBKLRZI8203prRIT';
    $CS = 'gFQOm2j1admDvprpa5ACFUCcZ2rR3xlwKZLyPxgjhLemK6dSzQ';
    $AT = '1316013293786419208-752iONfcwYc2Uji6qii6SGKdhD3g3N';
    $AS = 'TCm6sGozMVBU4269FRqCo1RhoKEL5no1NpCnuf0GnO7KQ';
    $connect = new TwitterOAuth( $CK, $CS, $AT, $AS );
    $userinfo = $connect->get('users/show', ['screen_name' => $_GET['screen']]);
    $twitter_id = $userinfo->id;
}
$user_comment_count = null;
$comment_count_self = null;
$comment_count_twitter = null;
$user_id = null;
$name = null;
$screen = null;
$result = $mysqli->query("SELECT user_id, name, screen FROM user WHERE twitter_id = '${twitter_id}'");
if (mysqli_num_rows($result)) {
    $row = $result->fetch_assoc();
    $user_id = $row["user_id"];
    $name = $row["name"];
    $screen = $row["screen"];
    $result = $mysqli->query("SELECT COUNT(*) FROM comment_self WHERE user_id = '${user_id}'");
    $row = $result->fetch_row();
    $comment_count_self = $row[0];
    $user_comment_count += $comment_count_self;
}
$result = $mysqli->query("SELECT name, screen, COUNT(*) FROM comment WHERE twitter_id = '${twitter_id}'");
$row = $result->fetch_row();
if($row[0]) {
    $name = $row[0];
    $screen = $row[1];
}
$comment_count_twitter = $row[2];
$user_comment_count += $comment_count_twitter;
$name_screen = $name . "@" . $screen;
$i = 0;
$j = 0;
head("${name_screen}のコメント一覧", "id/${twitter_id}");
header_html();
toggle();
echo "<main class='width-auto padding-24'>";
if ($user_comment_count == 0) {
    echo "<div class='margin-top-48 font-size-36-48 text-align-center line-height-1'>
        <strong>404&nbsp;Not&nbsp;Found</strong>
    </div>
    <div class='margin-top-24 text-align-center'><img src='/logo_384.png' class='width-256-767'></div>
    <div class='margin-top-24 text-align-center line-height-1 redirect'>ページが見つかりません</div>";
} else {
    $result_icon = $mysqli->query("SELECT icon FROM comment WHERE twitter_id = '${twitter_id}' ORDER BY up DESC LIMIT 1");
    if (mysqli_num_rows($result_icon)) {
        $row = $result_icon->fetch_assoc();
        $icon = $row["icon"];
    } else {
        $result_icon = $mysqli->query("SELECT icon FROM user WHERE twitter_id = '${twitter_id}'");
        while ($row = $result_icon->fetch_assoc()) {
            $icon = "/thumbnail/" . $row["icon"];
        }
    }
    echo "<ul class='flex list-style-type-none width-718-1078 margin-48-auto-0 padding-left-0 font-size-12 nowrap'>
        <li class='breadcrumb line-height-1'><a href='/' class='color-black underline'><strong>トップ</strong></a></li>
        <li class='breadcrumb line-height-1'>${name_screen}</li>
    </ul>
    <div class='flex-media-1126 justify-content-center margin-top-24'>
        <div class='width-100pe-718 margin-0-auto-1125'>
            <div class='radius-8 background-white padding-top-16 padding-left-16 padding-bottom-16'>
                <div class='flex'>
                    <img src='${icon}' class='width-46 height-46 radius-50'>
                    <div class='padding-left-16 min-width'>
                        <div class='padding-bottom-16 padding-right-16 overflow-hidden overflow-ellipsis nowrap line-height-1 border-box'>
                            <strong>${name_screen}</strong>
                        </div>
                        <div class='font-size-14 line-height-1'>${user_comment_count}件のコメント一覧</div>
                    </div>
                </div>
            </div>";
            if (isset($user_id)) {
                $result_count = $mysqli->query("SELECT comment_id, news_id, comment, up FROM comment_self WHERE user_id = '${user_id}' ORDER BY up DESC LIMIT 20");
                while ($row = $result_count->fetch_assoc()) {
                    $div_self = "div_self" . $i;
                    $button_self = "button_self" . $i;
                    $comment_id = $row["comment_id"];
                    $news_id = $row["news_id"];
                    $comment = $row["comment"];
                    $up = $row["up"];
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
                    echo "<div class='width-100pe-718 margin-0-auto-1125'>
                        <div class='margin-top-24 radius-8 background-white ${div_self}'>
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
                                    <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($row["up"]) . "</span>
                                </div>
                            </div>
                            <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                            if ($comment_count != 0) {
                                echo "<div class='padding-16'>
                                    <div class='flex'>
                                        <a href='/profile/id/${twitter_id}'>
                                            <img src='${icon}' class='width-42 height-42 radius-50'>
                                        </a>
                                        <div class='min-width margin-left-16'>
                                            <div class='padding-bottom-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                                                <a class='color-black underline' href='/profile/id/${twitter_id}'><strong>${name_screen}</strong></a>
                                            </div>
                                            <div class='overflow-hidden color-darkgray font-size-12 overflow-ellipsis nowrap line-height-1'>" . convert_to_fuzzy_time($up) . "</div>
                                        </div>
                                    </div>
                                    <div class='margin-top-12 font-size-14 pre-line line-height-1_5'>${comment}</div>
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
                                        if ($twitter_id_session == $twitter_id) {
                                            echo "<div class='flex space-between width-100pe'>";
                                        }
                                        echo "<div class='font-size-12 line-height-24'>
                                            <strong>${comment_count}</strong>コメント
                                        </div>";
                                        if ($twitter_id_session == $twitter_id) {
                                                echo "<div>
                                                    <button class='height-24 font-size-12 line-height-12 ${button_self}' type='button' value='${comment_id}'>削除</button>
                                                </div>
                                            </div>";
                                        }
                                    echo "</div>
                                </div>";
                            } else {
                                echo "<div class='padding-top-16 padding-left-16 padding-bottom-16 border-box font-size-14 line-height-1'>まだコメントはありません</div>";
                            }
                        echo "</div>
                    </div>";
                    $i++;
                }
            }
            $limit = 20 - $i;
            $result_count = $mysqli->query("SELECT news_id, tweet, up FROM comment WHERE twitter_id = '${twitter_id}' ORDER BY up DESC LIMIT ${limit}");
            while ($row = $result_count->fetch_assoc()) {
                $div = "div" . $j;
                $button = "button" . $j;
                $news_id = $row["news_id"];
                $tweet = $row["tweet"];
                $up = $row["up"];
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
                echo "<div class='width-100pe-718 margin-0-auto-1125'>
                    <div class='margin-top-24 radius-8 background-white ${div}'>
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
                                <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($row["up"]) . "</span>
                            </div>
                        </div>
                        <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>";
                        if ($comment_count != 0) {
                            echo "<div class='padding-16'>
                                <div class='flex'>
                                    <a href='/profile/id/${twitter_id}'>
                                        <img src='${icon}' class='width-42 height-42 radius-50'>
                                    </a>
                                    <div class='min-width margin-left-16'>
                                        <div class='padding-bottom-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                                            <a class='color-black underline' href='/profile/id/${twitter_id}'><strong>${name_screen}</strong></a>
                                        </div>
                                        <div class='overflow-hidden color-darkgray font-size-12 overflow-ellipsis nowrap line-height-1'>" . convert_to_fuzzy_time($up) . "</div>
                                    </div>
                                </div>
                                <div class='margin-top-12 font-size-14 pre-line line-height-1_5'>${tweet}</div>
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
                                    if ($twitter_id_session == $twitter_id) {
                                        echo "<div class='flex space-between width-100pe'>";
                                    }
                                    echo "<div class='font-size-12 line-height-24'>
                                        <strong>${comment_count}</strong>コメント
                                    </div>";
                                    if ($twitter_id_session == $twitter_id) {
                                            echo "<div>
                                                <button class='height-24 font-size-12 line-height-12 ${button}' type='button' value='${comment_id}'>削除</button>
                                            </div>
                                        </div>";
                                    }
                                echo "</div>
                            </div>";
                        } else {
                            echo "<div class='padding-top-16 padding-left-16 padding-bottom-16 border-box font-size-14 line-height-1'>まだコメントはありません</div>";
                        }
                    echo "</div>
                </div>";
            }
            if ($user_comment_count > 20) {
                $count_down = $user_comment_count - 20;
                echo "<span class='news-read'></span>
                <div class='margin-top-24'>
                    <button class='block width-50pe height-48 margin-auto background-white border-width-1 border-style-solid border-color-black radius-3 color-black font-size-16 text-align-center decoration-none line-height-48 transition-400ms more-button' type='submit'>
                        あと${count_down}件
                    </button>
                </div>";
            }
            echo "<div class='margin-top-24 line-height-1'>
                <strong>話題のニュース</strong>
            </div>";
            $result_count = $mysqli->query("SELECT * FROM news_count WHERE category = 1 ORDER BY count DESC, news_id DESC LIMIT 10");
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
                $twitter_id_comment = $row["twitter_id"];
                $tweet = $row["tweet"];
                $icon = $row["icon"];
                $screen = $row["screen"];
                $name_screen_topic = $row["name"] . "@" . $screen;
                $margin_top24 = "";
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
                                    <a href='/profile/id/${twitter_id_comment}'>
                                        <img src='${icon}' class='width-32 height-32 radius-50'>
                                    </a>
                                    <div class='min-width'>
                                        <div class='padding-bottom-12 padding-left-16 overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1 border-box'>
                                            <a class='color-black underline' href='/profile/id/${twitter_id_comment}'>
                                                <strong>$name_screen_topic</strong>
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
                <strong>最新のコメント</strong>
            </div>";
            $result_with = $mysqli->query("SELECT DISTINCT news_id, twitter_id, tweet, name, screen, icon, up FROM `comment` ORDER BY comment_id DESC LIMIT 10");
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
                echo "<div class='margin-top-24 width-100pe-336 radius-8 background-white'>
                    <div class='padding-16'>
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
                        <div class='height-84-768 margin-top-12 overflow-hidden font-size-14 pre-line-767 line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-4'>${tweet}</div>
                    </div>
                    <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>
                    <div class='height-84-768 padding-top-12 padding-right-16 padding-left-16 overflow-hidden line-height-1_5 webkit-box-768 webkit-vertical-768 webkit-clamp-3-768 border-box'>
                        <a class='color-black underline' href='/news/${news_id}'>
                            <strong>$row[title]</strong>
                        </a>
                    </div>
                    <div class='height-12'></div>
                </div>";
            }
        echo "</div>
    </div>";
}
echo "</main>";
ads_728();
footer();
ads_320();
?>
<script type="text/javascript" src="/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
            var count = "<?php echo $user_comment_count; ?>";
            var count_self = "<?php echo $comment_count_self; ?>";
            var count_twitter = "<?php echo $comment_count_twitter; ?>";
            var user_id = "<?php echo $user_id; ?>";
            var twitter_id = "<?php echo $twitter_id; ?>";
            var name_screen = "<?php echo $name_screen; ?>";
            var self_limit = Math.ceil(count_self / 20);
            var offset_self = 1;
            var offset = 0;
            if (count_self == 0) {
                var start = 20;
            } else {
                var start = count_self % 20;
            }
            $('.more-button').on('click', function() {
                count = count - 20;
                more();
            });
            function more() {
                if (count > 0) {
                    var more_button = $(".more-button");
                    more_button.addClass("flex align-items-center justify-content-center");
                    more_button.html("<img src ='/loading.gif'>");
                    if (self_limit > 0) {
                        var getData = {"offset_self":offset_self,"user_id":user_id,"twitter_id":twitter_id,"name_screen":name_screen};
                        self_limit--;
                        offset_self++;
                    } else {
                        var getData = {"offset":offset,"twitter_id":twitter_id,"name_screen":name_screen,"start":start};
                        offset++;
                    }
                    $.get("/profile_more_web.php", getData, function(rs) {
                        $(".news-read").append(rs);
                    }).always(function(data) {
                        more_button.removeClass("flex align-items-center justify-content-center");
                        let count_down = count - 20;
                        if (count < 21) {
                            more_button.remove();
                        } else {
                            more_button.html("あと" + count_down + "件");
                        }
                    });
                }
            }

            var i = "<?php echo $i; ?>";
            for (let ii = i - 1; ii >= 0; ii--) {
                var button_self = "button_self" + ii;
                $("." + button_self).on('click', function() {
                    var val = $(this).val();
                    var div_self = "div_self" + ii;
                    var options = {
                        title: 'コメントを削除しますか？',
                        text: 'この操作は取り消せません。',
                        icon: 'warning',
                        buttons: ["キャンセル", "削除"],
                        dangerMode: true
                    }
                    swal(options).then(function(value) {
                        if(value) {
                            $.post("/post.php", {
                                "comment_self": val
                            }, function(data) {
                                $('.' + div_self).remove();
                            });
                        }
                    });
                });
            }

            var j = "<?php echo $j; ?>";
            for (let jj = j - 1; jj > 0; jj--) {
                var button = "button" + jj;
                $("." + button).on('click', function() {
                    var val = $(this).val();
                    var div = "div" + jj;
                    var options = {
                        title: 'コメントを削除しますか？',
                        text: 'この操作は取り消せません。',
                        icon: 'warning',
                        buttons: ["キャンセル", "削除"],
                        dangerMode: true
                    }
                    swal(options).then(function(value) {
                        if(value) {
                            $.post("/post.php", {
                                "comment_id": val
                            }, function(data) {
                                $('.' + div).remove();
                            });
                        }
                    });
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
