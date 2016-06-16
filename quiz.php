<?php
require_once __DIR__.'/class/autoload.php';
$ErrMsg = null;
if (!(new Auth)->check()) {
    $ErrMsg = '尚未登入，將跳轉至登入畫面...';
    header("Refresh: 1; url=test.php");
}

$anss = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$ques = (new Session)->__get('questions');
	(new Session)->remove('questions');
    for ($i = 1; $i <= count($ques); $i++) { 
    	array_push($anss, $_POST['ans' . $i]);
    }
    $result = (new Test)->verifyAnswers($anss, $ques);
    (new Test)->storeRecord($result);
    header("Refresh: 1; url=index.php");
}
$quizs = (new Card)->getCardRandomly(10);
$questions = [];
for ($i = 0; $i < count($quizs); $i++) { 
	$questions[$i] = $quizs[$i]['terms'];
}
(new Session)->__set('questions', $questions);
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
			<?php if ($quizs): ?>
			<form method="POST">
				<table class="col c12 smooth">
					<thead>
						<tr>
							<th class="col c3">Answer</th>
							<th class="col c6">Definitions</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i = 0; $i < count($quizs); $i++): ?>
						<tr>
							<td class="col c3"><input type="text" name="<?php echo 'ans' . ($i+1); ?>"></td>
							<td class="col c6"><?php echo $quizs[$i]['definitions']; ?></td>
						</tr>
						<?php endfor ?>
					</tbody>
				</table>
				<button type="subimt" class="btn btn-sm btn-b smooth">送出</button>
			</form>
			<?php endif ?>
		</div>
        <?php endif ?>
        <?php require_once 'layout/script.php' ?>
    </body>
</html>
