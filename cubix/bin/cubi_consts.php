<?php

/* ============== CUBI CONFIG PRE-CORE ============================== */

//{$row.fld_latitude},{$row.fld_longtitude}
define('CUBI_DEFAULT_LATITUDE', '39.92');
define('CUBI_DEFAULT_LONGTITUDE', '116.46');

define('CUBI_FUSION_CHART_VERSION', "Pro");

define('CUBI_FORCE_DEFAULT_THEME', 0);

define('CUBI_GROUP_DATA_SHARE', '1');
define('CUBI_DATA_ACL', '1');
//I18n
define('CUBI_DEFAULT_CURRENCY', 'IDR');


//session strict
//0=allow concurrent session
//1=limited to single session
define('CUBI_SESSION_STRICT', '0');

// login page
// define('CUBI_USER_LOGIN_VIEW', "user.view.LoginView");

// cubi services
define('CUBI_USER_EMAIL_SERVICE', "userEmailService");
define('CUBI_VISIBILITY_SERVICE', "visService");
define('CUBI_LOV_SERVICE', "lovService");

define('CUBI_APPBUILDER', '0'); // 0: hidden, 1: show

