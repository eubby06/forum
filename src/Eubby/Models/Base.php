<?php namespace Eubby\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Base extends Model {

	public $timestamps 						= true;

	protected $validation_rules 			= array();

	protected $validation_messages 			= array();

	protected $validation_error_messages 	= array();

	protected $validation_object 			= false;

	public function setTableName($name)
	{
		$this->table = $name;
	}

	public function setValidationRules($rules)
	{
		$this->validation_rules = array_merge($this->validation_rules, $rules);
	}

	public function isValid($attributes = null)
	{
		if(empty($this->validation_rules))
		{
			return true;
		}

		if(is_null($attributes))
		{
			$attributes = $this->attributes;
		}

		$this->validation_object = Validator::make(
									$attributes,
									$this->validation_rules,
									$this->validation_messages);

		if($this->validation_object->fails())
		{
			$this->validation_error_messages = $this->validation_object->messages();
			return false;
		}

		return true;
	}

	public function validationErrors()
	{
		return $this->validation_error_messages;
	}

	public function validationRule()
	{
		return $this->validation_rules;
	}
}