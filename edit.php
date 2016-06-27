<?php
require_once __DIR__.'/class/autoload.php';
$ErrMsg = null;
if (!(new Auth)->check()) {
    $ErrMsg = '尚未登入，將跳轉至登入畫面...';
    header("Refresh: 1; url=index.php");
}

$list = (new Card)->getCardList();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['delCard'])) {
        try {
            $delCard = $_GET['delCard'];
            $ErrMsg = (new Card)->delCard($delCard);
            header("Refresh: 1; url=edit.php");
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
			<?php if ((new Auth)->check()): ?>
            <h1>Hello, <?=(new Session)->auth['username']?></h1>
                <div class="col c12">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>單字</td>
                                <td>定義</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $card):?>
                            <tr>
                                <td>
                                    <a class="ico" href="?delCard=<?=$card['terms']?>"><i class="ico">ⓧ</i></a>
                                </td>
                                <td><?php echo $card['terms']; ?></td>
                                <td><?php echo $card['definitions']; ?></td>   
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>
        <?php require_once 'layout/script.php' ?>
    </body>
</html>
