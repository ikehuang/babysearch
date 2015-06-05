<?php

class HumanInfo extends \Phalcon\Mvc\Model {

	public function initialize() {
		//setSource=table name
		$this->setSource("human_info");
	}
}