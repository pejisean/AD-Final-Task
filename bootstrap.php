<?php
define('BASE_PATH', realpath(__DIR__));
define('UTILS_PATH', BASE_PATH.'/utils/');
define('HANDLERS_PATH', BASE_PATH.'/handlers/');
define('DUMMIES_PATH', BASE_PATH.'/staticDatas/');

//Start session upon startup
if (session_status() == PHP_SESSION_NONE){
    session_start();
}



chdir(BASE_PATH);
