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
$mysqli = new mysqli('localhost', 'root', 'password', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
$result = $mysqli->query("SELECT COUNT(*) FROM `news` WHERE news_id in (SELECT news_id FROM news_to_tag WHERE tag_id = 9081976)");
$row = $result->fetch_row();
$news_count = $row[0];
head("生活（新着）", "new/life");
header_html();
toggle();
new_main($news_count, "生活", "life", 6, "SELECT news_id, title, url, image, description, site_domain_name, up FROM news WHERE news_id in (SELECT news_id FROM news_to_tag WHERE tag_id = 9081976) ORDER BY news_id DESC LIMIT 40");
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
            var count = "<?php echo $news_count; ?>";
            var offset = 1;
            $('.more-button').on('click', function() {
                count = count - 40;
                more();
                offset++;
            });
            function more() {
                if (count > 0) {
                    var more_button = $(".more-button");
                    more_button.addClass("flex align-items-center justify-content-center");
                    more_button.html("<img src ='/loading.gif'>");
                    var getData = {"offset":offset};
                    $.get("/new_life_more_web.php", getData, function(rs) {
                        $(".news-read").append(rs);
                    }).always(function(data) {
                        more_button.removeClass("flex align-items-center justify-content-center");
                        let count_down = count - 40;
                        if (count < 41) {
                            more_button.remove();
                        } else {
                            more_button.html("あと" + count_down + "件");
                        }
                    });
                }
            }
        });
    })(jQuery);
</script>
</body>
</html>
