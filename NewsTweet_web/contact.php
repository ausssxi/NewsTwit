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
head("お問い合わせ", "contact");
header_html();
toggle();
?>
<main class='width-auto padding-24'>
    <div class="width-100pe-718 margin-48-auto-0">
        <div class="margin-top-24 font-size-24 line-height-1">
            <strong class="border-bottom-3-double border-color-999">お問い合わせ</strong>
        </div>
        <div class="margin-top-20 line-height-1_5">ご意見ご要望などの各種お問い合わせは下記メールアドレスからご連絡ください。</div>
        <div class="margin-top-20 font-size-24 line-height-1">
            <strong class="border-bottom-3-double border-color-999">メールでのご連絡先</strong>
        </div>
        <div class="margin-top-24 line-height-1">newstweet.jp@gmail.com</div>
        <div class="margin-top-24 font-size-24 line-height-1">
            <strong class="border-bottom-3-double border-color-999">簡易ご意見フォーム</strong>
        </div>
        <div class="margin-top-20 line-height-1_5">こちらからもお送りいただけます。<br>返信が必要なものについてはメールアドレスも記載してください。</div>
        <div id='change'>
        <textarea class='width-224-336 height-64-96' id='message'></textarea>
        <div>
            <button id='msg_btn' type='button'>送信</button>
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
            $("#msg_btn").on('click', function() {
                post();
            });
            function post() {
                var message =　document.getElementById("message").value;
                $.post("/post.php", {
                    "message": message
                }, function(data) {
                    $("#change").html("<div class='margin-top-20 line-height-1_5'>送信ありがとうございました！<br>みなさまのご意見は今後の改善に役立てていきます。</div>");
                });
            }
	      });
    })(jQuery);
</script>
</body>
</html>
