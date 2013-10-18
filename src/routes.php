<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('forum/user/logout', array(
	'as' 	=> 'logout',
	'uses' 	=> 'Eubby\Controllers\UserController@getLogout'
	));

Route::get('forum/user/join', array(
	'as' 	=> 'join',
	'uses' 	=> 'Eubby\Controllers\UserController@getJoin'
	));

Route::post('forum/user/join', array(
	'as' 	=> 'post_join',
	'uses' 	=> 'Eubby\Controllers\UserController@postJoin'
	));

Route::get('forum/user/login', array(
	'as' 	=> 'login',
	'uses' 	=> 'Eubby\Controllers\UserController@getLogin'
	));

Route::post('forum/user/login', array(
	'as' 	=> 'post_login',
	'uses' 	=> 'Eubby\Controllers\UserController@postLogin'
	));

Route::get('forum/profile/{username}', array(
	'as' 	=> 'profile',
	'uses' 	=> 'Eubby\Controllers\ProfileController@getIndex'
	));

Route::get('forum/settings', array(
	'as' 	=> 'settings',
	'uses' 	=> 'Eubby\Controllers\SettingsController@getIndex'
	));

Route::get('forum', array(
	'as' 	=> 'home',
	'uses' 	=> 'Eubby\Controllers\IndexController@getIndex'
	));

Route::get('forum/{slug}/follow', array(
	'as' 	=> 'follow_conversation',
	'uses' 	=> 'Eubby\Controllers\ConversationController@getFollow'
	));

Route::get('forum/{slug}/unfollow', array(
	'as' 	=> 'unfollow_conversation',
	'uses' 	=> 'Eubby\Controllers\ConversationController@getUnfollow'
	));

Route::get('forum/{slug}', array(
	'as' 	=> 'view_conversation',
	'uses' 	=> 'Eubby\Controllers\ConversationController@getView'
	));

Route::get('forum/conversation/start', array(
	'as' 	=> 'start_conversation',
	'uses' 	=> 'Eubby\Controllers\ConversationController@getStart'
	));

Route::post('forum/conversation/start', array(
	'as' 	=> 'post_conversation',
	'uses' 	=> 'Eubby\Controllers\ConversationController@postStart'
	));

Route::post('forum/{slug}', array(
	'as' 	=> 'post_reply',
	'uses' 	=> 'Eubby\Controllers\ConversationController@postReply'
	));

Route::get('forum/conversations/{channel}', array(
	'as' 	=> 'list_conversations',
	'uses' 	=> 'Eubby\Controllers\ConversationController@getList'
	));

Route::post('forum/subscription/addsubscriber', array(
	'as' 	=> 'add_subscriber',
	'uses' 	=> 'Eubby\Controllers\ConversationController@postAddSubscriber'
	));

Route::get('forum/settings/profile', array(
	'as' 	=> 'settings',
	'uses' 	=> 'Eubby\Controllers\SettingsController@getProfile'
	));

Route::post('forum/settings/profile', array(
	'as' 	=> 'post_settings',
	'uses' 	=> 'Eubby\Controllers\SettingsController@postProfile'
	));

Route::get('forum/settings/password', array(
	'as' 	=> 'password_settings',
	'uses' 	=> 'Eubby\Controllers\SettingsController@getPassword'
	));

Route::post('forum/settings/password', array(
	'as' 	=> 'post_password_settings',
	'uses' 	=> 'Eubby\Controllers\SettingsController@postPassword'
	));

Route::get('forum/settings/notifications', array(
	'as' 	=> 'notifications',
	'uses' 	=> 'Eubby\Controllers\SettingsController@getNotifications'
	));

Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
		Route::get('/', array(
			'as' 	=> 'admin_dashboard',
			'uses' 	=> 'Eubby\Controllers\Admin\DashboardController@getIndex'
			));

		Route::get('appearance', array(
			'as' 	=> 'admin_appearance',
			'uses' 	=> 'Eubby\Controllers\Admin\AppearanceController@getIndex'
			));

		Route::get('settings', array(
			'as' 	=> 'admin_settings',
			'uses' 	=> 'Eubby\Controllers\Admin\SettingsController@getIndex'
			));

		Route::get('channels', array(
			'as' 	=> 'admin_channels',
			'uses' 	=> 'Eubby\Controllers\Admin\ChannelsController@getIndex'
			));

		Route::get('channels/edit/{id}', array(
			'as' 	=> 'admin_channels_edit',
			'uses' 	=> 'Eubby\Controllers\Admin\ChannelsController@getEdit'
			));

		Route::post('channels/edit/{id}', array(
			'as' 	=> 'admin_channels_edit_post',
			'uses' 	=> 'Eubby\Controllers\Admin\ChannelsController@postEdit'
			));

		Route::get('channels/create', array(
			'as' 	=> 'admin_channels_create',
			'uses' 	=> 'Eubby\Controllers\Admin\ChannelsController@getCreate'
			));

		Route::post('channels/create', array(
			'as' 	=> 'admin_channels_create_post',
			'uses' 	=> 'Eubby\Controllers\Admin\ChannelsController@postCreate'
			));

		Route::get('channels/delete/{id}', array(
			'as' 	=> 'admin_channels_delete',
			'uses' 	=> 'Eubby\Controllers\Admin\ChannelsController@getDelete'
			));

		Route::get('channels/restore/{id}', array(
			'as' 	=> 'admin_channels_restore',
			'uses' 	=> 'Eubby\Controllers\Admin\ChannelsController@getRestore'
			));

		Route::get('groups', array(
			'as' 	=> 'admin_groups',
			'uses' 	=> 'Eubby\Controllers\Admin\GroupsController@getIndex'
			));
		
		Route::get('groups/create', array(
			'as' 	=> 'admin_groups_create',
			'uses' 	=> 'Eubby\Controllers\Admin\GroupsController@getCreate'
			));

		Route::post('groups/create', array(
			'as' 	=> 'admin_groups_create_post',
			'uses' 	=> 'Eubby\Controllers\Admin\GroupsController@postCreate'
			));

		Route::get('groups/edit/{id}', array(
			'as' 	=> 'admin_groups_edit',
			'uses' 	=> 'Eubby\Controllers\Admin\GroupsController@getEdit'
			));

		Route::post('groups/edit/{id}', array(
			'as' 	=> 'admin_groups_edit_post',
			'uses' 	=> 'Eubby\Controllers\Admin\GroupsController@postEdit'
			));

		Route::get('groups/delete/{id}', array(
			'as' 	=> 'admin_groups_delete',
			'uses' 	=> 'Eubby\Controllers\Admin\GroupsController@getDelete'
			));
});