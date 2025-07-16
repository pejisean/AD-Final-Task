<?php
define('BASE_PATH', realpath(__DIR__));
define('UTILS_PATH', BASE_PATH . '/utils/');
define('HANDLERS_PATH', BASE_PATH . '/handlers/');
define('DUMMIES_PATH', BASE_PATH . '/staticDatas/');
define('COMPONENTS_PATH', BASE_PATH . '/components/');
define('PAGES_PATH', BASE_PATH . '/pages/');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

chdir(BASE_PATH);