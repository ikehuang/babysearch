<?php

class GuestbookController extends \Phalcon\Mvc\Controller {

	private $_imei;
	private $_token;
	private $_api_key;
	private $_email;
	
	//private $_test_imei;
	//private $_test_token;
	//private $_test_key;
	//private $_test_email;
	
	private $_apikey;
	
	public function initialize() {
		$this->_request = new \Phalcon\Http\Request();
	
		//$this->view->disable();
		//$this->response->setContentType('application/json', 'UTF-8');
		$this->_imei = $this->_request->getPost('imei');
		$this->_token = $this->_request->getPost('token');
		$this->_email = strtolower($this->_request->getPost('email'));
		$this->_api_key = $this->_request->getPost('api_key');
		
		//test code for getting data
		//$this->_test_api_key = $this->_request->get('api_key');
		//$this->_test_email = strtolower($this->_request->get('email'));
		//$this->_test_token = $this->_request->get('token');
		//$this->_test_imei = $this->_request->get('imei');
		
		//to check api-key with config
		$config = new \Phalcon\Config\Adapter\Ini("../apps/config/config.ini");
		$this->_apikey = $config->api->apikey;
	}
	
	public function createAction() {
		
		//need to somehow find serial number andv uses its did to create its guestbook
		//sample code
		$serial_number = "BD1B46XFKMX";
		
		$device = Device::findFirst("serial_number = '{$serial_number}'");
		
		$this->view->setVar("device", $device);
	}
	
	public function listAction() {
		
		$serial_number = strtoupper($this->_request->getPost('serial_number'));
		
		$guestbook_list = array();
		
		$response_data = array(
				'status' => 'fail',
				'guestbook_list' => $guestbook_list
		);
		
		//sample data
		//$serial_number = 'RF1C61XFKMX';
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {
			
			//(!!may change later on how to list guestbook)
			//if serial number exists, then continue to create device...; otherwise, return fail
			if(Device::count("serial_number = '{$serial_number}'") > 0) {
				
				$device = Device::findFirst("serial_number = '{$serial_number}'");
				
				$guestbook_list = Guestbook::findFirst(array("gid = '{$device->gid}'", "columns" => "name, message, email, phone, datetime, location"));
				
				$response_data = array(
						'status' => 'success',
						'guestbook_list' => $guestbook_list
				);
			}
				
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
}