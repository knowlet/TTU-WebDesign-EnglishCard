<?php
require_once __DIR__.'/class/autoload.php';
$ErrMsg = null;
if (!(new Auth)->check()) {
    $ErrMsg = '尚未登入，將跳轉至登入畫面...';
    header("Refresh: 1; url=index.php");
} else {
    try {
        $isAdmin = (new Admin)->isAdmin();
        $userList = (new Admin)->getUserList();
    } catch (Exception $e) {
        $ErrMsg = $e->getMessage();
        header("Refresh: 1; url=index.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    try {
        if (isset($_GET['delAct'])) {
            $delAct = $_GET['delAct'];
            (new Admin)->delUser($delAct);
            header("Refresh: 1; url=admin.php");
        }
        if (isset($_GET['resAct'])) {
            $resAct = $_GET['resAct'];
            (new Admin)->resumeUser($resAct);
            header("Refresh: 1; url=admin.php");
        }
        if (isset($_GET['setAdm'])) {
            $setAdm = $_GET['setAdm'];
            (new Admin)->promoteUser($setAdm);
            header("Refresh: 1; url=admin.php");
        }
        if (isset($_GET['ustAdm'])) {
            $ustAdm = $_GET['ustAdm'];
            (new Admin)->demoteUser($ustAdm);
            header("Refresh: 1; url=admin.php");
        }
    } catch (Exception $e) {
        $ErrMsg = $e->getMessage();
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
            <?php if ((new Auth)->check() && $isAdmin): ?>
            <table class="table">
                <thead>
                    <tr class="">
                        <th class="">Action</th>
                        <th class="">Id</th>
                        <th class="">Username</th>
                        <th class="">Privilege</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($userList); $i++): ?>
                    <tr class="">
                        <td class="">
                            <?php if (!($userList[$i]['uid'] == (new Session)->auth['uid'])): ?>
                                <?php if ($userList[$i]['valid'] == 'Y'): ?>
                                <a href="?delAct=<?=$userList[$i]['uid']?>">帳戶停權</a>
                                <?php else: ?>
                                <a href="?resAct=<?=$userList[$i]['uid']?>">恢復帳戶</a>
                                <?php endif ?>
                                <?php if ($userList[$i]['privilege'] == 2): ?>
                                <a href="?setAdm=<?=$userList[$i]['uid']?>">設為管理員</a>
                                <?php else: ?>
                                <a href="?ustAdm=<?=$userList[$i]['uid']?>">設為使用者</a>
                                <?php endif ?>
                            <?php else: ?>
                                <?php echo "It's You!!!"; ?>
                            <?php endif ?>

                        </td>
                        <td class=""><?php echo $userList[$i]['uid']; ?></td>
                        <td class=""><?php echo $userList[$i]['username']; ?></td>
                        <td class=""><?php echo $userList[$i]['privilege'] == 1 ? "Admin" : "User"; ?></td>
                    </tr>
                    <?php endfor ?>
                </tbody>
            </table>
            <?php else: ?>
            <h1>Hello, <?=(new Session)->auth['username']?></h1>
            <?php endif ?>
        </div>
        <?php require_once 'layout/script.php' ?>
    </body>
</html>
