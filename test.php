<?php
require_once __DIR__.'/class/autoload.php';
$ErrMsg = null;
if (!(new Auth)->check()) {
    $ErrMsg = '尚未登入，將跳轉至登入畫面...';
    header("Refresh: 1; url=index.php");
}

$records = (new Test)->getRecords();
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
        <?php if ((new Auth)->check()): ?>
    	<div class="container">
			<?php if (!$records): ?>
	        <h2>No record here.</h2>
	        <h2>How about have a exam now?</h2>
	        <?php endif ?>
	        <a class="btn btn-a btn-sm smooth href="#">Start Exam</a>
	        <?php if ($records): ?>
			<table class="col c12 smooth">
				<thead>
					<tr>
						<th class="col c1">序號</th>
						<th class="col c2">成績</th>
						<th class="col c4">測驗時間</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = count($records)-1; $i >= 0; $i--): ?>
					<tr>
						<td class="col c1"><?php echo $i+1; ?></td>
						<td class="col c2"><?php echo $records[$i]['score']; ?></td>
						<td class="col c4"><?php echo $records[$i]['dates']; ?></td>
					</tr>
					<?php endfor ?>
				</tbody>
			</table>
			<?php endif ?>
		</div>
        <?php endif ?>
        <?php require_once 'layout/script.php' ?>
    </body>
</html>
