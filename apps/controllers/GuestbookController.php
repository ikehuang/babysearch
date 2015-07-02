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
							"msg" => "We can't create guestbook right now"
					);
				}
			}
			else {
				$response_data = array(
						"status" => 'success',
						"msg" => "A new guestbook was created successfully!",
						"id" => $guestbook->gid
				);
				
				$this->_send_android_notification($guestbook->message, $_SESSION['USER']['INFO']['access_token']);
				$this->_send_apple_notification($guestbook->message, $_SESSION['USER']['INFO']['access_token']);
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
	private function _send_android_notification($msg,$token) {
		// API access key from Google API's Console
		define( 'API_ACCESS_KEY', 'AIzaSyDfmE5CeBGdP9eCVMbhykDkZ0jBaMS9mBM' );
		
		
		$registrationIds = array( $token );
		
		// prep the bundle
		$msg = array
		(
				'message' 	=> $msg
		);
		
		$fields = array
		(
				'registration_ids' 	=> $registrationIds,
				'data'			=> $msg
		);
		
		$headers = array
		(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
		);
		
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
	}
	
	private function _send_apple_notification($msg, $token) {
		$ctx = stream_context_create();
		
		stream_context_set_option($ctx, 'ssl', 'local_cert', getcwd().'/data/ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', '1234');
		
		// Open a connection to the APNS server
		$fp = stream_socket_client(
				'ssl://gateway.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		
		if ($fp) {
			// Create the payload body
			$body['aps'] = array(
					'alert' => $msg
			);
			
			// Encode the payload as JSON
			$payload = json_encode($body);
			
			// Build the binary notification
			$msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
			
			// Send it to the server
			$push_result = fwrite($fp, $msg);		
		}
	}
}