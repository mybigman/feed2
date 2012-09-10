<?php
class User extends Mongor\Model {

	static $collection = 'users';

	static function rules()
	{
		return [
			'username' => 'required|min:9',
			'password' => 'required|min:9'
		];
	}
}