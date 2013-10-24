<?php namespace Eubby\Libs\Acl;

use Eubby\Models\Conversation;

interface AccessControlInterface
{
	public function getUser();

	public function logout();

	public function attempt($data, $remember);

	public function check();

	public function isAdmin();

	public function isModerator();

	public function isMember();

	public function isGuest();

	public function isUserActivated();

	public function allowedToComment($channel_id);

	public function allowedToView($channel_id);

	public function lastVisit(Conversation $conversation);

	public function logVisit(Conversation $conversation);
	
}