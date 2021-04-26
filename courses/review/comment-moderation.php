<?php
require_once('../config.php');
function include_template($name, array $data = []) {
    $name = '../templates/' . $name;
    $result = '';
    if (!is_readable($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require $name;
    $result = ob_get_clean();
    return $result;
}
    if (isset($_GET["ok"])) {
        $com_id = htmlspecialchars(intval($_GET['ok']));
        $res=mysqli_query($connect,"UPDATE commentos SET moderation=1 WHERE id='".$com_id."'");
        $_SESSION["success_messages"] = "Отзыв одобрен и опубликован.";
    }
    if (isset($_GET["del"])) {
        $com_id = htmlspecialchars(intval($_GET['del']));
        $res=mysqli_query($connect,"DELETE FROM commentos WHERE id='".$com_id."'");
        $_SESSION["success_messages"] = "Отзыв удален.";
    }
    if ($_GET["comment"]) {
        $comment = htmlspecialchars($_GET['comment']);
        $com_id = htmlspecialchars(intval($_GET['id']));
        $res=mysqli_query($connect,"SELECT * FROM commentos  WHERE id='".$com_id."'");
        $com=mysqli_fetch_array($res);
    }
    if ($_POST["comment"]!='') {
        $com_id = htmlspecialchars(intval($_POST['com_id']));  
        $res=mysqli_query($connect,"UPDATE commentos
     SET comment_text='".htmlspecialchars($_POST["comment"])."', moderation=1 WHERE id='".$com_id."'");
       $_SESSION["success_messages"] = "Отзыв исправлен, одобрен и опубликован.";
    }

$page_content = include_template('comment-moderation.php', ['com' => $com]);
print($page_content);