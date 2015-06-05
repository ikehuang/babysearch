<?php

class BulletinController extends \Phalcon\Mvc\Controller {

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
	
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');
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
	
	public function listAction() {
		
		$message = null;
		
		//sample data
		$this->_api_key = 'qwe123';
		$this->_apikey = 'qwe123';
		
		$response_data = array(
				'status' => 'fail',
				'message' => $message
		);
		
		//if api_key match, continue...; otherwise, return fail
		if($this->_api_key == $this->_apikey) {

			$bulletin = Bulletin::findFirst();
			
			$message = $bulletin->message;
			
			$response_data = array(
					'status' => 'success',
					'message' => $message
			);
				
		}
		
		$this->response->setContent(json_encode($response_data));
		$this->response->send();
	}
}