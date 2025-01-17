<?php
ini_set('display_errors', "On");
session_start();
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
$year = substr($_GET["date"], 0, 4);
$month = substr($_GET["date"], 4, 2);
$today = date("Y").date("m");
$month11 = date("Y", strtotime('-11 month')).date("m", strtotime('-11 month'));
$date = $_GET["date"] . "01";
$lastmonth = strtotime('-1 month' . $date);
$nextmonth = strtotime('+1 month' . $date);
switch ($_GET["category"]) {
    case 1:
        $category = "総合";
        $category_url = "all";
        break;
    case 2:
        $category = "芸能・スポーツ";
        $category_url = "entame";
        break;
    case 3:
        $category = "アニメ・ゲーム";
        $category_url = "anime";
        break;
    case 4:
        $category = "IT・科学";
        $category_url = "it";
        break;
    case 5:
        $category = "教育・学習";
        $category_url = "learn";
        break;
    case 6:
        $category = "生活";
        $category_url = "life";
        break;
    case 7:
        $category = "政治・経済";
        $category_url = "politics";
        break;
    case 8:
        $category = "社会";
        $category_url = "society";
        break;
}
head("${year}年${month}月のコメントランキング（${category}）", "entame");
header_html();
toggle();
$result = $mysqli->query("SELECT COUNT(*) FROM ranking_month WHERE category = $_GET[category] AND date = $_GET[date]");
$row = $result->fetch_row();
$ranking_count = $row[0];
echo "<main class='width-auto padding-24'>";
if ($ranking_count == 0) {
    echo "<div class='margin-top-48 font-size-36-48 text-align-center line-height-1'>
        <strong>404&nbsp;Not&nbsp;Found</strong>
    </div>
    <div class='margin-top-24 text-align-center'><img src='/logo_384.png' class='width-256-767'></div>
    <div class='margin-top-24 text-align-center line-height-1 redirect'>ページが見つかりません</div>";
} else {
    echo "<ul class='flex list-style-type-none width-718-1078 margin-48-auto-0 padding-left-0 font-size-12 nowrap'>
        <li class='breadcrumb line-height-1'><a href='/' class='color-black underline'><strong>トップ</strong></a></li>
        <li class='breadcrumb line-height-1'><a href='/${category_url}' class='color-black underline'><strong>${category}</strong></a></li>
        <li class='breadcrumb line-height-1'><a href='https://newstwit.jp/ranking/month/$_GET[category]/${year}${month}' class='color-black underline'><strong>${year}年${month}月のコメントランキング（${category}）</strong></a></li>
    </ul>
    <div class='flex-media-1126 justify-content-center margin-top-24'>
        <div class='width-100pe-718 margin-0-auto-1125'>
            <div class='radius-8 background-white padding-16'>
                <div class='flex space-between align-items-center'>
                    <div class='font-size-14'>";
                        if ($today > $_GET["date"]) {
                            echo "<a class='color-black underline' href='/ranking/month/$_GET[category]/" . date("Y", $nextmonth) . date("m", $nextmonth) . "'>＜＜&nbsp;翌月</a>";
                        }
                    echo "</div>
                    <div class='text-align-center'>
                        <div class='font-size-14'>
                            <strong>コメントランキング</strong>
                        </div>
                        <div class='font-size-14'>
                            <strong>${year}年${month}月付</strong>
                        </div>
                    </div>
                    <div class='font-size-14'>";
                        if ($_GET["date"] > $month11) {
                            echo "<a class='color-black underline' href='/ranking/month/$_GET[category]/" . date("Y", $lastmonth) . date("m", $lastmonth) . "'>前月&nbsp;＞＞</a>";
                        }
                    echo "</div>
                </div>
            </div>";
            $i = 1;
            $result_count = $mysqli->query("SELECT news_id, count FROM ranking_month WHERE category = $_GET[category] AND date = $_GET[date]");
            while ($row = $result_count->fetch_assoc()) {
                $news_id = $row["news_id"];
                $comment_count = $row["count"];
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
                echo "<div class='width-100pe-718 margin-0-auto-1125'>
                    <div class='margin-top-24'>
                        <strong class ='font-size-24'>${i}</strong><span class ='font-size-12'>位</span>&nbsp;-&nbsp;</span><strong class ='font-size-24'>${comment_count}</strong><span class='font-size-12'>コメント</span>
                    </div>
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
                                <a class='color-darkgray underline' href='/media/site/${site_domain_name}'>${site_domain_name}</a><span class='color-darkgray'>&nbsp;-&nbsp;" . convert_to_fuzzy_time($up) . "</span>
                            </div>
                        </div>
                        <hr class='clear-both height-1 margin-0 border-none f0f0f0-c0c0c0'>
                        <div class='padding-16'>
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
                        </div>
                    </div>
                </div>";
                $i++;
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
                side_ranking("総合", 1, 0);
                side_ranking("芸能・スポーツ", 2, 0);
                side_ranking("アニメ・ゲーム", 3, 0);
                side_ranking("IT・科学", 4, 0);
                side_ranking("教育・学習", 5, 0);
                side_ranking("生活", 6, 0);
                side_ranking("政治・経済", 7, 0);
                side_ranking("社会", 8, 0);
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
                </div>";
                side_ranking("総合", 1, 1);
                side_ranking("芸能・スポーツ", 2, 1);
                side_ranking("アニメ・ゲーム", 3, 1);
                side_ranking("IT・科学", 4, 1);
                side_ranking("教育・学習", 5, 1);
                side_ranking("生活", 6, 1);
                side_ranking("政治・経済", 7, 1);
                side_ranking("社会", 8, 1);
            echo "</div>
        </div>
    </div>";
}
echo "</main>";
ads_728();
footer();
ads_320();
?>
<script type="text/javascript" src="/jquery-3.3.1.min.js"></script>
<?php
java();
?>
