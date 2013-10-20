<?php

if(! function_exists('theme_path'))
{
	function theme_path($file = null)
	{
	  return Config::get('forum::theme.path').Config::get('forum::theme.name').'/'.$file;
	}
}

if(! function_exists('theme_frontend'))
{
	function theme_frontend($file = null)
	{
	  return Config::get('forum::theme.path').Config::get('forum::theme.name').'/frontend/'.$file;
	}
}

if(! function_exists('theme_backend'))
{
	function theme_backend($file = null)
	{
	  return Config::get('forum::theme.path').Config::get('forum::theme.name').'/backend/'.$file;
	}
}

if(! function_exists('theme_asset'))
{
	function theme_asset($file = null)
	{
	  return url(Config::get('forum::theme.path').Config::get('forum::theme.name').'/assets/'.$file);
	}
}