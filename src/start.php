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
define('LEVEL', Session::get('LEVEL', 0));
define('LANG', Session::get('LANG', app('Pongo')->settings('language')));
define('CMSLANG', Session::get('CMSLANG', app('Pongo')->settings('language')));
define('EDITOR', Session::get('EDITOR'));

define('XPAGE', app('Pongo')->settings('per_page'));
define('DEFORDER', app('Pongo')->system('default_order'));

/**
 * SetLocale on run-time
 */

setlocale(LC_ALL, app('Pongo')->system('locale.'.CMSLANG));