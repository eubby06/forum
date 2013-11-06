<?php namespace Eubby\Controllers;

use View, Input, Redirect, Auth, Hash, Validator;

class SettingsController extends BaseController
{
	public function getProfile()
	{

		if (!$this->acl->check()) return Redirect::route('login');

		$user = $this->acl->getUser();
		$profile = ($user->profile) ? $user->profile : new \Eubby\Models\Profile;

		$select_notifications = array(
                        '1' => 'Email me when I am added to a private conversation',
                        '2' => 'Email me when someone posts in a conversation I have followed',
                        '3' => 'Email me when someone mentions me in a post',
                        '4' => 'Automatically follow conversations that I reply to',
                        '5' => 'Automatically follow private conversations that I am added to'
			);

		$user_notifications = ($profile->notifications) ? unserialize($profile->notifications) : array();

		$this->layout->content = View::make("theme::{$this->theme}.frontend.user.profile_settings")
									->with('user', $user)
									->with('profile', $profile)
									->with('select_notifications', $select_notifications)
									->with('user_notifications', $user_notifications);

		return $this->layout;	
	}

	public function postProfile()
	{
		if (!$this->acl->check()) return Redirect::route('login');

		$user = $this->acl->getUser();
		$profile = ($user->profile) ? $user->profile : new \Eubby\Models\Profile;

		$profile->user_id = $user->id;
		$profile->notifications = (Input::get('notification')) ? serialize(Input::get('notification')) : null;
		$profile->location = Input::get('location');
		$profile->about = Input::get('about');
		$profile->privacy = (Input::get('privacy')) ? 1 : 0;

		$profile->save();

		return Redirect::back()->with('success', 'Profile has been updated.');
	}

	public function getPassword()
	{
		if (!$this->acl->check()) return Redirect::route('login');

		$this->layout->content = View::make("theme::{$this->theme}.frontend.user.password_settings");

		return $this->layout;	
	}

	public function postPassword()
	{
		if (!$this->acl->check()) return Redirect::route('login');

		$user = $this->acl->getUser();
		
		//check if current password is correct
		if (!Hash::check(Input::get('current_password'), $user->password))
		{
			return Redirect::back()->withErrors('Current password is not correct.');
		}

		//check if new passwords match
		if ((Input::get('password') != '') && 
			(Input::get('password') == Input::get('password_confirmation')))
		{
			//make sure that current password is not the same as the new one
			if (Hash::check(Input::get('password'), $user->password))
			{
				return Redirect::back()->withErrors('The new password is the same as the current one.');
			}

			//is new email available?
			if (Input::get('email') != '')
			{
				//validate email
				$email_validator = Validator::make(
										array('email' => Input::get('email')),
										array('email' => 'email|unique:users')
									);

				//redirect if email validation fails
				if ($email_validator->fails())
				{
					return Redirect::back()->withErrors('Email is invalid or taken.');
				}

				//set new email if passes
				$user->email = Input::get('email');
			}

			//set new password and update database
			$user->password = Input::get('password');
			$user->update();

			return Redirect::back()->with('success', 'Password has been changed.');
		}

		return Redirect::back()->withErrors('Passwords do not match.');
	}

	public function getNotifications()
	{
		if (!$this->acl->check()) return Redirect::route('login');

		$user = $this->acl->getUser();

		$notifications = $user->notifications()->where('hidden','=',0)->paginate(2);

		$this->layout->content = View::make("theme::{$this->theme}.frontend.user.notifications")
									->with('user', $user)
									->with('notifications', $notifications);

		return $this->layout;	
	}
}