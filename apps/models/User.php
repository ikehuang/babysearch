<?php

class User extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("users");
	}
}