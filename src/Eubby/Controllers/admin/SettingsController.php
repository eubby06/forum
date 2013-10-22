<?php namespace Eubby\Controllers\Admin;

use View, Input, Redirect, Auth, Config, App, File;

class SettingsController extends AdminController
{
	public function getIndex()
	{
		$settings = $this->settings->find(1);

		$this->layout->content = View::make("theme::{$this->theme}.backend.settings")
									->with('settings', $settings);
		return $this->layout;
	}

	public function postUpdate()
	{
		$settings = $this->settings->find(1);

		$data = array(
			'title' => Input::get('title'),
			'language' => Input::get('language'),
			'home_page' => Input::get('home_page')[0],
			'registration' => Input::get('registration')[0],
			'member_privacy' => Input::get('member_privacy')[0],
			'editing_permission' => Input::get('editing_permission')[0]
			);

		if ($settings->isValid($data))
		{
			$settings->update($data);
			return Redirect::back()->with('success', 'Forum settings has been updated.');
		}

		return Redirect::back()->withInput()->withErrors($settings->errorMessages());
	}

	//only for writing into a file
	public function getWrite($settings = array())
	{

		$path = $this->getConfigFile('settings.php');
		$content = str_replace(
				array('##title##', '##theme##'),
				array($title, $theme),
				File::get($path)
			);

		return File::put($path, $content);
	}

	//only for writing into a file
	protected function getConfigFile($file)
	{
		$config_path = App::make('config.path');

		if (file_exists($config_path.$file))
		{
			return $config_path.$file;
		}

		return null;
	}
}