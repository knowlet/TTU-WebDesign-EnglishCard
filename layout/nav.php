<?php
(new Auth)->isValid();
?>
<nav class="nav" tabindex="-1" onclick="this.focus()">
    <div class="container">
        <a id="logo" class="pagename current" href=".">英文單字卡</a>
        <?php if ((new Auth)->check()): ?>
        <a id="card" class href="card.php">單字卡</a>
        <a id="test" class href="test.php">自我測驗</a>
        <?php
		    try {
		        if((new Admin))
		        	echo '<a id="admin" class href="admin.php">管理員</a>';
		    } catch (Exception $e) {
		    }
        ?>
        <a href="logout.php">登出</a>
        <?php endif ?>
    </div>
</nav>
<button class="btn-close btn btn-sm">×</button>
