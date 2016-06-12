<?php
require_once __DIR__.'/class/autoload.php';
(new Auth)->logout();
header("Location: index.php");
