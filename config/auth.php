<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

global $conn; // assume db.php is required before auth.php, or auth.php is required after db.php
$global_theme = 'theme-default';
if(isset($conn)) {
    $uid = $_SESSION['user_id'];
    $theme_q = $conn->query("SELECT theme FROM user_settings WHERE user_id = $uid");
    if($theme_q && $theme_q->num_rows > 0) {
        $tr = $theme_q->fetch_assoc();
        $global_theme = $tr['theme'];
    }
}
?>
