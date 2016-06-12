<nav class="nav" tabindex="-1" onclick="this.focus()">
    <div class="container">
        <a id="logo" class="pagename current" href="#">英文單字卡</a>
        <?php if ((new Auth)->check()): ?>
        <a id="card" class href="card.php">單字卡</a>
        <a id="test" class href="test.php">自我測驗</a>
        <a href="logout.php">登出</a>
        <?php endif ?>
    </div>
</nav>
<button class="btn-close btn btn-sm">×</button>
