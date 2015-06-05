<?php

class LostContacts extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("lost_contacts");
	}
}