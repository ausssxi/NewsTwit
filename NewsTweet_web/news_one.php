<?php
require "fuzzy_time.php";
$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8mb4");
$result_comment_self = $mysqli->query("SELECT user_id, comment, up FROM comment_self WHERE news_id = '$_GET[id]' ORDER BY up DESC, news_id DESC LIMIT 1");
while ($row = $result_comment_self->fetch_assoc()) {
    $user_id = $row["user_id"];
    $comment = $row["comment"];
    $up = $row["up"];
    $result = $mysqli->query("SELECT twitter_id, name, screen, icon FROM user WHERE user_id = '${user_id}'");
    while ($row = $result->fetch_assoc()) {
        $name_screen = $row["name"] . "@" . $row["screen"];
        echo "<div class='padding-right-16 padding-bottom-13 padding-left-16'>
            <div class='flex'>
                <a href='/profile/id/$row[twitter_id]'>
                    <img src='/thumbnail/$row[icon]' class='width-42 height-42 radius-50'>
                </a>
                <div class='min-width margin-left-16'>
                    <div class='overflow-hidden font-size-14 overflow-ellipsis nowrap line-height-1'>
                        <a class='color-black underline' href='/profile/id/$row[twitter_id]'><strong>${name_screen}</strong></a>
                    </div>
                    <div class='margin-top-16 overflow-hidden color-darkgray font-size-12 overflow-ellipsis nowrap line-height-1'>" . convert_to_fuzzy_time($up) . "</div>
                </div>
            </div>
            <div class='margin-top-16 font-size-12 pre-line line-height-1_5'>${comment}</div>
        </div>
        <hr class='clear-both height-1 margin-top-0 margin-right-0 margin-bottom-16 margin-left-0 border-none f0f0f0-c0c0c0'>";
    }
}
?>
</body>
</html>
