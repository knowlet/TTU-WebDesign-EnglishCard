<?php
require_once __DIR__.'/class/autoload.php';
$Msg = null;
$user = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user']) && isset($_POST['pwd']) && isset($_POST['repwd'])) {
        try {
            $user = $_POST['user'];
            $pwd = $_POST['pwd'];
            $repwd = $_POST['repwd'];
            if ($pwd !== $repwd)
                throw new Exception("兩次輸入的密碼不一樣");
            (new User)->createAccount($user, $pwd);
            $Msg = "註冊成功！將自動跳轉至登入頁面...";
            header("Refresh: 3; url=index.php");
        } catch (Exception $e) {
            $Msg = $e->getMessage();
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
        <?php if (!is_null($Msg)): ?>
        <div class="msg"><?=$Msg?></div>
        <?php endif ?>
        <div class="container">
            <h1>Sign Up</h1>
            <?php if (!(new Auth)->check()): ?>
            <form method="POST">
                <div class="col c12">
                    <span class="addon">帳號</span><input type="text" class="smooth" name="user" value="<?=is_null($user)?'':$user?>">
                </div>
                <div class="col c12">
                    <span class="addon">密碼</span><input type="password" class="smooth" name="pwd">
                </div>
                <div class="col c12">
                    <span class="addon">確認</span><input type="password" class="smooth" name="repwd">
                </div>
                <div class="col c12">
                    <button type="subimt" class="btn btn-sm btn-b smooth">註冊</button>
                    <a href="index.php" class="btn btn-sm btn-a smooth">登入</a>
                </div>
            </form>
            <?php endif ?>
        </div>
    </body>
</html>
