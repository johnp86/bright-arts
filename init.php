<?php
ob_start();
session_start();

mysql_connect('localhost', 'jp232', 'jp232');
mysql_select_db('jp232_imageupload');

include 'func/album.func.php';
include 'func/image.func.php';
include 'func/thumb.func.php';
include 'func/user.func.php';
include 'func/tag.func.php';
include 'func/comment.func.php';
include 'func/like.php';
?>
