<?php

define("TEMPLATES", "./templates");
define("NOTIFICATIONS", TEMPLATES."/notifications");

define("VERSION", "v0.0.1");

define("DBPREFIX", "");


define("ASSETS", "");
define("CSS", ASSETS."/css");
define("JS", ASSETS."/js");
define("IMGS", ASSETS."/imgs");
define("UI", ASSETS."/graindashboard");
define("UI_CSS", UI."/css");
define("UI_JS", UI."/js");

// define("DBPREFIX", "");
//tables
define("RESER", DBPREFIX."reservations");
define('USERS', DBPREFIX.'users');
define('CUST', DBPREFIX.'customers');
define('TABLES', DBPREFIX.'tables');
define('MENU', DBPREFIX.'menu');

?>
