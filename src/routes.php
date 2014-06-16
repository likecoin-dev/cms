<?php

// Set controllers path shortcut

$pongoControllers = 'Pongo\Cms\Controllers\\';
$apiControllers = 'Pongo\Cms\Controllers\Api\\';

// Back-end routes

Route::group(Config::get('cms::routes.cms_group_routes'), function() use ($pongoControllers)
{

	Route::get('/', function() {

		return "Welcome in PongoCMS!";
	});

	Route::get('testing', array('uses' => $pongoControllers.'TestController@testing', 'as' => 'test'));

	// JS BOOTSTRAP
	Route::get('init.js', array('uses' => $pongoControllers.'BaseController@init', 'as' => 'js.init'));

	// // LOGIN
	Route::get('/', array('uses' => $pongoControllers.'LoginController@index', 'as' => 'cms.index'));
	Route::get('login', array('uses' => $pongoControllers.'LoginController@index', 'as' => 'login.index'));
	Route::get('logout', array('uses' => $pongoControllers.'LogoutController@logout', 'as' => 'logout'));
	Route::get('lang/{lang}', array('uses' => $pongoControllers.'BaseController@changeLang', 'as' => 'lang'));

	// DASHBOARD
	Route::get('dashboard', array('uses' => $pongoControllers.'DashboardController@index', 'as' => 'dashboard'));

	// BLOCKS
	Route::get('block/edit/{page_id}/{block_id}', array('uses' => $pongoControllers.'BlockController@edit', 'as' => 'block.edit'));

	// PAGE
	Route::get('page/edit/{page_id}', array('uses' => $pongoControllers.'PageController@edit', 'as' => 'page.edit'));

	// BLOG
	// Route::get('blog/edit/{post_id?}', array('uses' => $pongoControllers.'BlogController@editPost', 'as' => 'blog.edit'));

	// FILE
	Route::get('file/edit/{file_id}', array('uses' => $pongoControllers.'FileController@edit', 'as' => 'file.edit'));

	// ROLE
	Route::get('roles', array('uses' => $pongoControllers.'RoleController@index', 'as' => 'roles'));
	Route::get('role/edit/{role_id}', array('uses' => $pongoControllers.'RoleController@edit', 'as' => 'role.edit'));

	// // USER
	Route::get('users', array('uses' => $pongoControllers.'UserController@index', 'as' => 'users'));
	Route::get('user/edit/{user_id}', array('uses' => $pongoControllers.'UserController@edit', 'as' => 'user.edit'));	
	Route::any('user/search', array('uses' => $pongoControllers.'UserController@search', 'as' => 'user.search'));
});

// API calls

Route::group(Config::get('cms::routes.api_group_routes'), function() use ($apiControllers)
{

	// LOGIN	
	Route::post('login', array('uses' => $apiControllers.'LoginController@login', 'as' => 'api.login'));

	// GLOBAL SETTINGS
	Route::any('settings/save', array('uses' => $apiControllers.'SettingsController@save', 'as' => 'api.settings.save'));

	// SAVE
	// Route::any('save', array('uses' => $apiControllers.'SaveController@save', 'as' => 'api.save'));
	// Route::any('error', array('uses' => $apiControllers.'SaveController@error', 'as' => 'api.error'));
	// Route::any('expire', array('uses' => $apiControllers.'SaveController@expire', 'as' => 'api.expire'));

	// BLOCK
	Route::post('block/copy', array('uses' => $apiControllers.'BlockController@copy', 'as' => 'api.block.copy'));
	Route::post('block/create', array('uses' => $apiControllers.'BlockController@create', 'as' => 'api.block.create'));
	Route::post('block/delete', array('uses' => $apiControllers.'BlockController@delete', 'as' => 'api.block.delete'));
	Route::post('block/save/content', array('uses' => $apiControllers.'BlockController@saveContent', 'as' => 'api.block.save.content'));
	Route::post('block/save/settings', array('uses' => $apiControllers.'BlockController@saveSettings', 'as' => 'api.block.save.settings'));
	Route::post('block/valid', array('uses' => $apiControllers.'BlockController@valid', 'as' => 'api.block.valid'));
	Route::post('block/zone', array('uses' => $apiControllers.'BlockController@zone', 'as' => 'api.block.zone'));

	// PAGE
	Route::post('page/change/layout', array('uses' => $apiControllers.'PageController@changeLayout', 'as' => 'api.page.change.layout'));
	Route::post('page/copy', array('uses' => $apiControllers.'PageController@copy', 'as' => 'api.page.copy'));
	Route::post('page/create', array('uses' => $apiControllers.'PageController@create', 'as' => 'api.page.create'));
	Route::post('page/delete', array('uses' => $apiControllers.'PageController@delete', 'as' => 'api.page.delete'));
	Route::post('page/lang', array('uses' => $apiControllers.'PageController@lang', 'as' => 'api.page.lang'));
	Route::post('page/load/blocks', array('uses' => $apiControllers.'PageController@loadBlocks', 'as' => 'api.page.load.blocks'));
	Route::post('page/move', array('uses' => $apiControllers.'PageController@move', 'as' => 'api.page.move'));
	Route::post('page/move/blocks', array('uses' => $apiControllers.'PageController@moveBlocks', 'as' => 'api.page.move.blocks'));
	Route::post('page/save/settings', array('uses' => $apiControllers.'PageController@saveSettings', 'as' => 'api.page.save.settings'));
	Route::post('page/save/seo', array('uses' => $apiControllers.'PageController@saveSeo', 'as' => 'api.page.save.seo'));
	Route::post('page/save/layout', array('uses' => $apiControllers.'PageController@saveLayout', 'as' => 'api.page.save.layout'));
	Route::post('page/save/assets', array('uses' => $apiControllers.'PageController@saveAssets', 'as' => 'api.page.save.assets'));
	Route::post('page/valid', array('uses' => $apiControllers.'PageController@valid', 'as' => 'api.page.valid'));

	// FILES
	Route::post('file/create', array('uses' => $apiControllers.'FileController@create', 'as' => 'api.file.create'));
	Route::post('file/delete', array('uses' => $apiControllers.'FileController@delete', 'as' => 'api.file.delete'));
	Route::post('file/upload', array('uses' => $apiControllers.'FileController@upload', 'as' => 'api.file.upload'));
	Route::post('file/valid', array('uses' => $apiControllers.'FileController@valid', 'as' => 'api.file.valid'));	
	// 	Route::any('page/files/create', array('uses' => $apiControllers.'UploadController@pageFilesCreate', 'as' => 'api.page.files.create'));
	// 	Route::any('page/files/delete/{file_id}', array('uses' => $apiControllers.'UploadController@pageFilesDelete', 'as' => 'api.page.files.delete'));

	// CONTENT
	// 	Route::any('element/content/save', array('uses' => $apiControllers.'ElementController@elementContentSave', 'as' => 'api.element.content.save'));

	// ROLE
	// Route::any('role/order', array('uses' => $apiControllers.'RoleController@orderRoles', 'as' => 'api.role.order'));
	Route::post('role/create', array('uses' => $apiControllers.'RoleController@create', 'as' => 'api.role.create'));
	Route::post('role/delete', array('uses' => $apiControllers.'RoleController@delete', 'as' => 'api.role.delete'));
	Route::post('role/move', array('uses' => $apiControllers.'RoleController@move', 'as' => 'api.role.move'));
	Route::post('role/save', array('uses' => $apiControllers.'RoleController@save', 'as' => 'api.role.save'));
	Route::post('role/valid', array('uses' => $apiControllers.'RoleController@valid', 'as' => 'api.role.valid'));
	
	// TAGS
	Route::post('tags', array('uses' => $apiControllers.'TagController@index', 'as' => 'tags'));

	// // USER
	Route::post('user/create', array('uses' => $apiControllers.'UserController@create', 'as' => 'api.user.create'));
	Route::post('user/delete', array('uses' => $apiControllers.'UserController@delete', 'as' => 'api.user.delete'));
	Route::post('user/save/settings', array('uses' => $apiControllers.'UserController@saveSettings', 'as' => 'api.user.save.settings'));
	Route::post('user/save/password', array('uses' => $apiControllers.'UserController@savePassword', 'as' => 'api.user.save.password'));
	Route::post('user/save/details', array('uses' => $apiControllers.'UserController@saveDetails', 'as' => 'api.user.save.details'));
	Route::post('user/save/role', array('uses' => $apiControllers.'UserController@saveRole', 'as' => 'api.user.save.role'));
	Route::post('user/valid', array('uses' => $apiControllers.'UserController@valid', 'as' => 'api.user.valid'));

});


// Front-end routes

Route::group(Config::get('cms::routes.site_group_routes'), function() use ($pongoControllers)
{
	
	Route::any('{all}', array('uses' => $pongoControllers.'SiteController@renderPage', 'as' => 'catchall'))->where('all', '.*');

});

// Handles 404 - Not found

App::missing(function($exception)
{
	// return Response::view('cms::errors.404', array('error' => $exception), 404);
});
