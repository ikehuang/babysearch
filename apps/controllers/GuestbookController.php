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
		
		if ($this->_request->isPost() == true) {
			$this->view->disable();
			$this->response->setContentType('application/json', 'UTF-8');
				
			$guestbook = new Guestbook();

			$guestbook->did = $this->_request->getPost("did");
			$guestbook->name = $this->_request->getPost("name");
			$guestbook->location = $this->_request->getPost("location");
			$guestbook->phone = $this->_request->getPost("phone");
			$guestbook->message = $this->_request->getPost("message");
			if(!empty($this->_request->getPost("date"))) {
				$guestbook->datetime = $this->_request->getPost("date")." ".$this->_request->getPost("time");
			}
			
			else {
				$guestbook->datetime = date('Y-m-d H:i:s');
			}
			
			if ($guestbook->create() == false) {
				foreach ($guestbook->getMessages() as $message) {
					$response_data = array(
							"status" => 'fail',
							"msg" => "We can't category category right now"
					);
				}
			}
			else {
				$response_data = array(
						"status" => 'success',
						"msg" => "A new category was created successfully!",
						"id" => $guestbook->gid
				);
			}
				
			$this->response->setContent(json_encode($response_data));
			$this->response->send();
		}
		else {
			$serial_number = $this->_request->get('serial_number');
			
			$device = Device::findFirst("serial_number = '{$serial_number}'");
			
			$this->view->setVar("device", $device);
		}
	}
	
	public function listAction() {
		$serial_number = $this->_request->get('serial_number');
		$device = Device::findFirst("serial_number = '{$serial_number}'");
		$this->view->device = $device;
		$guestbook_list = Guestbook::find("did = '{$device->did}' and checked is null ");
		$this->view->guestbook_list = $guestbook_list;
		
		if(isset($_SESSION['USER']['INFO'])) {
			$device = Device::findFirst("serial_number = '{$serial_number}' and sso_id='{$_SESSION['USER']['INFO']['sso_id']}'");
			
			if(!empty($device)) {
				// update all guestbook to checked
				
				if(!empty($guestbook_list)) {
					foreach($guestbook_list as $r) {
						$r->checked = 'Y';
						$r->update();
					}
				}
			}
		}
	}
}