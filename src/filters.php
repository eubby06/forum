<?php

Route::filter('admin_auth', function()
{
	if (Acl::isGuest()) return Redirect::guest('forum/user/login');

	if (!Acl::isAdmin()) return Redirect::route('home')->withErrors('Warning! Illegal access to the admin section.');
});