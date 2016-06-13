<?php
require_once __DIR__.'/class/autoload.php';
$ErrMsg = null;
if (!(new Auth)->check()) {
    $ErrMsg = '尚未登入，將跳轉至登入畫面...';
    header("Refresh: 1; url=index.php");
}
$list = (new Card)->getVocabularyList();
$selected = rand(0, count($list) - 1);
$card = (new Card)->getCard($list[$selected][0]);
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
			<?php if ((new Auth)->check()): ?>
            <h1>Hello, <?=(new Session)->auth['username']?></h1>
            <div class="col c12">
                <h1><?php echo $card[0]; ?></h1>
                <?php foreach (array_combine($card[1], $card[2]) as $define => $ex): ?>
                <p><strong><?php echo $define; ?></strong></p>
                <p><?php echo $ex; ?></p>
                <?php endforeach ?>
            </div>
            <?php endif ?>
        </div>
        <?php require_once 'layout/script.php' ?>
    </body>
</html>
