<?php

class DeviceContacts extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("device_contacts");
	}
}