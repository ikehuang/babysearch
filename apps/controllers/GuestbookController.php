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
		
		$serial_number = $this->_request->get('serial_number');
		
		if ($this->_request->isPost() == true) {
			$this->view->disable();
			$this->response->setContentType('application/json', 'UTF-8');
			
			$guestbook = new Guestbook();

			$guestbook->did = $this->_request->getPost("did");
			$guestbook->name = $this->_request->getPost("name");
			$guestbook->location = $this->_request->getPost("location");
			$guestbook->phone = $this->_request->getPost("phone");
			$guestbook->message = $this->_request->getPost("message");
			$guestbook->latitude = $this->_request->getPost("latitude");
			$guestbook->longitude = $this->_request->getPost("longitude");

			$device = Device::findFirst("did = '{$guestbook->did}'");
			//$mobiles = Mobile::find("sso_id = '{$device->sso_id}' and token is not null and token != ''");
			$mobiles = Mobile::find(array("conditions" => "sso_id = '{$device->sso_id}' and token is not null and token != ''", "order" => "mid desc"));
			$user = User::findFirst("sso_id = '{$device->sso_id}'");
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
				
				$name = $device->name;
				
				if(empty($device->name))  {
					$name = substr($device->serial_number,-12);
				}
					
				$msg = "找到{$name}的人有留言給你";
				
				if(!empty($mobiles)) {
					$android_send = "N";
					$apple_send = "N";
					
					foreach($mobiles as $mobile) {
						if($android_send == 'N') {
							$android_send  = $this->_send_android_notification($msg, $serial_number, $mobile->token);
						}
						
						if($apple_send == "N") {
							$apple_send = $this->_send_apple_notification($msg, $serial_number, $mobile->token);
						}
					}
				}

				// send email
				$subject = "By BabySearch";

				$this->_send_mail($user->email,$subject,$msg);
			}
			
			
			$this->response->setContent(json_encode($response_data));
			$this->response->send();
		}
		else {
			
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
		/*
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
		*/
	}
	private function _send_android_notification($msg, $sn, $token) {
		// API access key from Google API's Console
		define( 'API_ACCESS_KEY', 'AIzaSyDfmE5CeBGdP9eCVMbhykDkZ0jBaMS9mBM' );
		
		
		$registrationIds = array( $token );
		
		// prep the bundle
		$msg = array
		(
				'msg' 	=> $msg,
				'sn'	=> $sn
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
		
		$new_result = json_decode($result);
		return $new_result->success == 1 ? 'Y' : 'N';
		
	}
	
	private function _send_apple_notification($msg, $serial_number, $token) {
		
			exec("php ".getcwd()."/push.php {$token} {$serial_number} $msg");
			return  'N';
	}

	private function _send_mail($to,$subject,$msg) {
		require getcwd().'/PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = 'email-smtp.us-west-2.amazonaws.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'AKIAJLZBBPUF4NTIG6GQ';
		$mail->Password = 'ArVzhV6Pgm000i8dwHAlTzCKVPSrLIEiktIKS0gk2Ue9';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->CharSet = "UTF-8";


		$mail->From = 'no-reply@traceez.com';
		$mail->FromName = 'BabySearch';

		$mail->addAddress($to);

		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $msg;

		$mail->send();
		/**
		
		if(!$mail->send()) {
   			echo 'Message could not be sent.';
    			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
    			echo 'Message has been sent';
		}
		**/
		
	}
}
