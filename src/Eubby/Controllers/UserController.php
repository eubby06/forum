<?php namespace Eubby\Controllers;

use View, Input, Redirect, Auth, Request;

class UserController extends BaseController
{
	public function getLogout()
	{
		//deactive from sessions table
		$this->session->deactivate(Auth::user()->id);

		//logout from session
		Auth::logout();

		return Redirect::back()->with('success', 'You have logged out successfully.');		
	}
	
	public function getJoin()
	{

		$this->layout->content = View::make("theme::{$this->theme}.frontend.user.join");

		return $this->layout;	
	}

	public function postJoin()
	{
		$user_data = array(
			'username' 					=> Input::get('username'),
			'email' 					=> Input::get('email'),
			'password' 					=> Input::get('password'),
			'password_confirmation' 	=> Input::get('password_confirmation'),
			'ip_address' 				=> Request::getClientIp(),
			'active' 					=> 0
			);

		if ($this->user->isValid($user_data))
		{
			$user = $this->user->create($user_data);

			return Redirect::back()->with('success', 'Hi ' . $user->username . ', please activate your account by clicking on the link in the confirmation email.');
		}

		return Redirect::back()->withInput()->withErrors($this->user->validationErrors());
	}

	public function getLogin()
	{
		$this->layout->content = View::make("theme::{$this->theme}.frontend.user.login");

		return $this->layout;	
	}

	public function postLogin()
	{
		$login_data = array(
			'username' => Input::get('username'),
			'password' => Input::get('password'));

		if (Auth::attempt($login_data, Input::has('remember_me')))
		{
			//add user to session
			$this->session->add(array('user_id' => Auth::user()->id, 'active' => 1, 'ip_address' => Request::getClientIp()));

			return Redirect::route('home')->with('success', 'Hi ' . $login_data['username'] . ', welcome to the forum.');
		}

		return Redirect::back()->withErrors('Invalid username / password combination.');
	}

}