<?php namespace Eubby\Libs\Notification;

use Eubby\Models\Settings;
use Exception, Mail;

class Notifier implements NotifierInterface
{
	protected $settings 		= array();

	protected $model 			= null;

	protected $type 			= null;

	protected $notifiableObj	= null;

	protected $message 			= null;

	protected $messages 		= array();

	protected $errors 			= array();

	protected $user 			= null;

	protected $sender 			= null;

	protected $template 		= null;

	public function __construct(\Eubby\Models\Notification $model)
	{
		$this->model = $model;

		//set mail template for the notification
		$theme = Settings::find(1)->theme;
		$this->template = "theme::{$theme}.mail.notification";
	}

	public function getSettings()
	{
		if (is_null($this->user)) return false;

		if (empty($this->user->profile->notifications)) return array();
		
		return unserialize($this->user->profile->notifications);
	}

	public function setNotifiableObj($obj)
	{
		$this->notifiableObj = $obj;
	}

	public function setSender($sender)
	{
		$this->sender = $sender;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}

	public function setType($type = null)
	{
		if (is_null($type)) 
			$this->type = '0';
		else
			$this->type = $type;
	}

	public function hasOptIn()
	{
		$settings = $this->getSettings();
		$type = $this->type;

		if (in_array($type, $settings)) return true;

		return false;
	}

	public function setMessage($message = null)
	{
		if (!is_null($message) && !is_array($message))
		{
			$this->message = $message;

			return true;
		}

		$this->errors[] = 'Message is empty';

		return false;
	}

	public function getMessages()
	{
		if (is_null($this->user)) return false;

		$this->messages = $this->model->where('user_id','=',$this->user->id)->get();

		if (!empty($this->messages))
		{
			return $this->messages;
		}

		return false;
	}

	public function attemptNotify()
	{
		if (is_null($this->user)) return false;

		if (!is_null($this->message))
		{
			//notify user internally/locally
			$this->notifyInternal();

			//check if user would like to receive email notification
			if ($this->hasOptIn())
			{
				//notify user by email
				$this->notifyByEmail();
			}
			
			return true;
		}

		return false;
	}

	protected function notifyByEmail()
	{
		//set some variables for the mailer
		$data = array(
			'user' 			=> $this->user,
			'sender' 		=> $this->sender,
			'notifiableObj' => $this->notifiableObj,
			'subject' 		=> 'Notification - Flash eSports Forum',
			'statement' 	=> $this->message
			);

		//notify user by email
		Mail::send($this->template, $data, function($message) use ($data)
		{
			$message->from('yonanne@flashcomms.com', 'Flash eSports');
			$message->to($data['user']->email, $data['user']->username)->subject($data['subject']);
		});

		return true;
	}

	protected function notifyInternal()
	{
		//save notifiction to database
		$this->notifiableObj->notifications()->create(array(
			'user_id' => $this->user->id,
			'message' => $this->message,
			'sender_id' => $this->sender->id,
			'created_at' => date('Y-m-d H:i:s'),
			'hidden' => 0
			));

		return true;
	}

	public function getErrors()
	{
		return $this->errors[0];
	}

	public function hideNotification($id)
	{
		$notification = $this->model->find($id);

		if (!is_null($notification))
		{
			$notification->hidden = true;
			$notification->save();

			return true;
		}

		return false;
	}

	public function removeNotification($id)
	{
		$notification = $this->model->find($id);

		if (!is_null($notification))
		{
			$notification->delete();

			return true;
		}

		return false;
	}
}