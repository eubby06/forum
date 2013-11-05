<?php namespace Eubby\Controllers;

use Input, Response, Redirect;

class NotificationsController extends BaseController 
{
	public function getRemove($nid)
	{

		if ($nid)
		{
			if ($this->notifier->removeNotification($nid))
			{
				return Redirect::back()->with('success', 'Notification has been removed.');	
			}	
		}

		return Redirect::back()->withErrors('Notification could not be found.');

	}

	public function getHide($nid)
	{

		if ($nid)
		{
			if ($this->notifier->hideNotification($nid))
			{
				return Redirect::back()->with('success', 'Notification has been hidden.');		
			}	
		}

		return Redirect::back()->withErrors('Notification could not be found.');
	}

	public function postAjaxRemove()
	{
		//redirect if user is not found
		$nid = Input::get('nid') ? Input::get('nid') : null;

		if ($nid)
		{
			if ($this->notifier->removeNotification($nid))
			{
				return Response::json(array('result' => 'success', 'message' => 'Notification has been removed.'));	
			}	
		}

		return Response::json(array('result' => 'fail', 'message' => 'Notification could not be found.'));
	}

	public function postAjaxHide()
	{
		//redirect if user is not found
		$nid = Input::get('nid') ? Input::get('nid') : null;

		if ($nid)
		{
			if ($this->notifier->hideNotification($nid))
			{
				return Response::json(array('result' => 'success', 'message' => 'Notification has been hidden.'));	
			}	
		}

		return Response::json(array('result' => 'fail', 'message' => 'Notification could not be found.'));
	}
}