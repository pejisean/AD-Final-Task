<?php
require_once UTILS_PATH . '/auth.util.php';

AuthUtil::startSession();
$currentUser = AuthUtil::getCurrentUser();
$isLoggedIn = AuthUtil::isLoggedIn();