<?php namespace Eubby\Models;

use Eubby\Models\Base;

class Settings extends Base
{
	protected $table 			= 'settings';

	protected $guarded 			= array('id');

	protected $validation_rules = array(
		'title' => 'required');

	public function getTheme()
	{
		return $this->theme ? $this->theme : 'default';
	}
}
