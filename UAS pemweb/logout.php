<?php
session_start();
session_unset();
session_destroy();
header("Location: beranda.php");
exit();
?>
