<?php
ini_set('display_errors', "On");
session_start();
require "fuzzy_time.php";
require_once "functions.php";
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
function user_agent() {
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if ((strpos($agent, 'Android') !== false) && (strpos($agent, 'Mobile') !== false) || (strpos($agent, 'iPhone') !== false)) {
        return true;
    }
}
head("プライバシーポリシー", "privacy");
header_html();
toggle();
?>
<main class='width-auto padding-24'>
    <div class="width-100pe-718 margin-48-auto-0">
        <div class="margin-top-24 font-size-36 line-height-1_5">
            <strong>NewsTwit（ニューズツイット）のプライバシーポリシー</strong>
        </div>
        <div class="margin-top-15 font-size-24 line-height-1">
            <strong class="border-bottom-3-double border-color-999">利用者情報の取得</strong>
        </div>
        <div class="margin-top-20 line-height-1_5">本サイト・アプリが利用者の個人情報を取得することはありません。</div>
        <div class="margin-top-20 font-size-24 line-height-1">
            <strong class="border-bottom-3-double border-color-999">利用者情報の利用</strong>
        </div>
        <div class="margin-top-20 line-height-1_5">本サイト・アプリが利用者の個人情報を取得することはありません。</div>
        <div class="margin-top-20 font-size-24 line-height-1">
            <strong class="border-bottom-3-double border-color-999">利用者情報の第三者提供</strong>
        </div>
        <div class="margin-top-20 line-height-1_5">本サイト・アプリが利用者の個人情報を第三者に提供することはありません。</div>
        <div class="margin-top-20 font-size-24 line-height-1">
            <strong class="border-bottom-3-double border-color-999">使用ツール</strong>
        </div>
        <div class="margin-top-20 line-height-1_5">本サイト・アプリでは、広告配信ツールとしてAdSense(Google Inc.)・AdMob(Google Inc.)を使用しており、AdSense・AdMobが利用者の情報を自動取得する場合があります。取得する情報、利用目的、第三者への提供等につきましては、広告配信事業者のプライバシーポリシーよりご確認ください。</div>
        <div class="margin-top-20 font-size-24 line-height-1">
            <strong class="border-bottom-3-double border-color-999">お問い合わせ先</strong>
        </div>
        <div class="margin-top-20 line-height-1_5">何かご不明な点がございましたらお問い合わせください。<br><a href='/contact' target='_blank'><u>お問い合わせ</u></a></div>
    </div>
</main>
<?php
ads_728();
footer();
ads_320();
?>
<script type="text/javascript" src="/jquery-3.3.1.min.js"></script>
<?php
java();
?>
