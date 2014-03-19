<?php

/**
 * Define User constants
 *
 * Valued in LoginController@login POST
 */

define('USERID', Session::get('USERID'));
define('USERNAME', Session::get('USERNAME'));
define('EMAIL', Session::get('EMAIL'));
define('ROLEID', Session::get('ROLEID'));
define('ROLENAME', Session::get('ROLENAME'));
define('LEVEL', Session::get('LEVEL'));
define('LANG', Session::get('LANG'));
define('CMSLANG', Session::get('CMSLANG', Config::get('cms::settings.language')));
define('EDITOR', Session::get('EDITOR'));

/**
 * SetLocale on run-time
 */

setlocale(LC_ALL, Config::get('cms::system.locale.'.CMSLANG));