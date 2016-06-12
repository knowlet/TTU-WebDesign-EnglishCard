<?php
require_once __DIR__.'/class/autoload.php';
$ErrMsg = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user']) && isset($_POST['pwd'])) {
        try {
            $user = $_POST['user'];
            $pwd = $_POST['pwd'];
            (new User)->createAccount($user, $pwd);
        } catch (Exception $e) {
            $ErrMsg = $e->getMessage();
        }

    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>英文單字卡</title>
        <link rel="stylesheet" href="http://mincss.com/entireframework.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php require_once 'layout/nav.php' ?>
        <?php if (!is_null($ErrMsg)): ?>
        <div class="msg"><?=$ErrMsg?></div>
        <?php endif ?>
        <div class="container">
            <p>語言能力的提升，拓展字彙量是非常重要的一步。</p>
            <p>為了增加單字量，隨時複習是一個非常有效且普遍使用的做法。</p>
            <p>因此，我們提出這個單字卡系統，可以隨時使用單字卡背誦單字，這套系統也提供測驗系統，提供使用者隨時檢測自己的學習進度。</p>
            <p>Sign Up</p>
        </div>
        <?php if (!(new Auth)->check()): ?>
        <form method="POST" novalidate>
            <div class="container">
                <div class="col c12">
                    <span class="addon">帳號</span><input type="email" class="smooth" name="user">
                </div>
                <div class="col c12">
                    <span class="addon">密碼</span><input type="password" class="smooth" name="pwd">
                </div>
                <div class="col c12">
                    <button type="subimt" class="btn btn-sm btn-b smooth">註冊</button>
                    <a href="index.php" class="btn btn-sm btn-a smooth">登入</a>
                </div>
            </div>
        </form>
        <?php endif ?>
    </body>
</html>
