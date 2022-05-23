<?php

define("TEMPLATES", "./templates");
define("NOTIFICATIONS", TEMPLATES."/notifications");

define("VERSION", "v0.0.1");

define("ASSETS", ".");
define("CSS", ASSETS."/css");
define("JS", ASSETS."/js");
define("IMGS", ASSETS."/imgs");
define("UI", ASSETS."/graindashboard");
define("UI_CSS", UI."/css");
define("UI_JS", UI."/js");
define("IMGS", ASSETS."/imgs");

// Check if dev or not
    $sub = explode(".", $_SERVER['HTTP_HOST'])[0];
    if($sub!="www"){
        define("DBPREFIX", "");
    }
    else{
        define("DBPREFIX", "dev_");
    }

//tables
define("RIDES_TABLE", DBPREFIX."rides");
define('USERS_TABLE', DBPREFIX.'users');
define('RIDE_REQUESTS', DBPREFIX.'ride_requests');
define('PRICES', DBPREFIX.'prices');

?>