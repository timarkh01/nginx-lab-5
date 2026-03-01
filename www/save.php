<?php
session_start();

setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

header("Location: index.php");
exit();