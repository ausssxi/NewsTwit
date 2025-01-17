<?php
require "fuzzy_time.php";
ini_set('display_errors', "On");
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
function user_agent() {
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if ((strpos($agent, 'Android') !== false) && (strpos($agent, 'Mobile') !== false) || (strpos($agent, 'iPhone') !== false)) {
        return true;
    }
}
$twitter_id = $_GET["twitter_id"];
$name_screen = $_GET["name_screen"];
$i = 0;
if (isset($_GET["user_id"]) && isset($_GET["offset_self"])) {
    $offset = 20 * $_GET['offset_self'];
    $result = $mysqli->query("SELECT icon FROM user WHERE user_id = '$_GET[user_id]'");
    $row = $result->fetch_assoc();
    $icon = "/thumbnail/" . $row["icon"];
    $result_count = $mysqli->query("SELECT news_id, comment, up FROM comment_self WHERE user_id = '$_GET[user_id]' ORDER BY up DESC LIMIT 20 OFFSET ${offset}");
    while ($row = $result_count->fetch_assoc()) {
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
            <div class='margin-top-24 radius-8 background-white'>
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
                                <div class='overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                                    <a class='color-black underline' href='/profile/id/${twitter_id}'><strong>${name_screen}</strong></a>
                                </div>
                                <div class='margin-top-16 overflow-hidden color-darkgray font-size-12 overflow-ellipsis nowrap line-height-1'>" . convert_to_fuzzy_time($up) . "</div>
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
}
$limit = 20 - $i;
if (isset($_GET["offset"]) && isset($_GET["start"])) {
    $offset = ($_GET["offset"] * 20) + $_GET["start"];
}
if (!isset($_GET["user_id"]) && isset($_GET["twitter_id"])) {
    $result = $mysqli->query("SELECT icon FROM comment WHERE twitter_id = '${twitter_id}' ORDER BY up DESC LIMIT 1");
    if (mysqli_num_rows($result)) {
        $row = $result->fetch_assoc();
        $icon = $row["icon"];
    }
}
$result_count = $mysqli->query("SELECT news_id, tweet, up FROM comment WHERE twitter_id = '${twitter_id}' ORDER BY up DESC LIMIT ${limit} OFFSET $offset");
while ($row = $result_count->fetch_assoc()) {
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
        <div class='margin-top-24 radius-8 background-white'>
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
                            <div class='overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                                <a class='color-black underline' href='/profile/id/${twitter_id}'><strong>${name_screen}</strong></a>
                            </div>
                            <div class='margin-top-16 overflow-hidden color-darkgray font-size-12 overflow-ellipsis nowrap line-height-1'>" . convert_to_fuzzy_time($up) . "</div>
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
?>
