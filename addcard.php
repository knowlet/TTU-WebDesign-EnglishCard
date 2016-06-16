<?php
require_once __DIR__.'/class/autoload.php';
$ErrMsg = null;
if (!(new Auth)->check()) {
    $ErrMsg = '尚未登入，將跳轉至登入畫面...';
    header("Refresh: 1; url=index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['term']) && isset($_POST['definition'])) {
        try {
            $term = $_POST['term'];
            $definition = $_POST['definition'];
            $ErrMsg = (new Card)->addCard($term, $definition);
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
        <?php require_once 'layout/head.php' ?>
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
		</div>
        <?php if ((new Auth)->check()): ?>
        <form method="POST">
            <div class="container">
                <div class="col c12">
                    <span class="addon">單字</span><input type="text" class="smooth" name="term">
                </div>
                <div class="col c12">
                    <span class="addon">定義</span><input type="text" class="smooth" name="definition">
                </div>
                <div class="col c12">
                    <button type="subimt" class="btn btn-sm btn-b smooth">送出</button>
                </div>
            </div>
        </form>
        <?php endif ?>
        <?php require_once 'layout/script.php' ?>
    </body>
</html>
