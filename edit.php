<?php
require_once __DIR__.'/class/autoload.php';
$ErrMsg = null;
if (!(new Auth)->check()) {
    $ErrMsg = '尚未登入，將跳轉至登入畫面...';
    header("Refresh: 1; url=index.php");
}

$list = (new Card)->getCardList();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        try {
            $delete = $_POST['delete'];
            $ErrMsg = (new Card)->delCard($delete);
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
            <?php foreach ($list as $card):?>
            <form method="POST">
                <div class="col c12">
                    <div class="col c3">
                        <textarea><?php echo $card['terms']; ?></textarea>
                    </div>
                    <div class="col c8">
                        <textarea><?php echo $card['definitions']; ?></textarea>
                    </div>
                    <div class="col c1">
                        <input type="hidden" name="delete" value="<?php echo $card['terms']; ?>">
                        <button class="smooth" type="subimt"><i class="ico">ⓧ</i></button>
                    </div>
                </div>
            </form>
            <?php endforeach ?>
            <?php endif ?>
        </div>
        <?php require_once 'layout/script.php' ?>
    </body>
</html>
