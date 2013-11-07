<?php namespace Eubby\Libs\Notifier;

interface NotifierInterface
{

	public function getSettings();

	public function setType($type);
	
	public function setMessage($message);

	public function getMessages();

	public function hasOptIn();

	public function attemptNotify();

	public function setSender($sender);

	public function setUser($user);

	public function getErrors();

	public function hideNotification($id);

	public function removeNotification($id);
	
}