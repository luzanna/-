
<?php
session_start();
session_destroy();
//unset($_SESSION['username']);
//print_r($_SESSION['username']);
header('location: /index.php');
