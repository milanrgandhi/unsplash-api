<?php
################ Set key and other configuration details ##############

define('API_KEY', '5f3ef4a8aece346436b3da1256896fcd4aeee226643f234b9d37e7a7579f4990');
define('PAGE_COUNT', '30');
define('DOWNLOADFOLDERNAME', 'downloadimgs');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$cur_dir = explode('\\', getcwd());
$current_dir = strtolower($cur_dir[count($cur_dir)-1]);

define('LOCALDIR', $current_dir);

define('SERVER_HOSTNAME', $_SERVER['HTTP_HOST']);





?>