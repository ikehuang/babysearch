<?php

use \Phalcon\Events\Event,
		\Phalcon\Mvc\Dispatcher,
		\Phalcon\Acl as PhalconACL;

class Acl extends \Phalcon\Mvc\User\Component
{

	protected $_module;
	protected $_acl;

	protected $roles;
	protected $privateResources = array(
		'index' => array('dashboard'),
		'factory' => array('qcConfirm', 'cuttingConfirm', 'orderCheckConfirm', 'packageConfirm', 'deliveryConfirm', 'searchOrder','printConfirm','imagePreviewConfirm','orderImages'),
		'users' => array('addUser', 'getUser', 'editUser')
	);
	protected $publicResources = array(
		'index' => array('index', 'login', 'logout'),
		'tools' => array('importDHLZone','freeOrder','createOrder', 'getOrderInfo', 'createTestOrder','updateOrder','deleteOrder','generateOrder','launchAloneEC2','ipn'),
		'orders' => array('list','csvexport','updateTrackingNumberNote')
	);

	public function __construct()
	{

		//$this->_generateACL();
	}
	
	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
	{
		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();
		if( $controller == 'user' && $action == 'bulletin')
			return;
		
		if( $controller == 'device' && $action == 'create')
			return;
		
		if( $controller == 'device' && $action == 'index')
			return;
		
		if( $controller == 'guestbook' && $action == 'create')
			return;
		
		if( $controller == 'guestbook' && $action == 'list')
			return;

		if (isset($_SESSION['USER']['INFO']) && !empty($_SESSION['USER']['INFO']) &&  $controller == 'user' && $action == 'login') {
			$dispatcher->forward(
				array(
					'controller' => 'user',
				  	'action' => 'index'
				)
	        );
		}
		
		if (!isset($_SESSION['USER']['INFO']) && $action != 'login' && $action != 'facebook' && $action != 'google') {
			$dispatcher->forward(
					array(
							'controller' => 'user',
							'action' => 'login'
					)
			);
		}
	}

	private function _generateACL() {
		foreach ($this->roles as $role) {
	    	$this->_acl->addRole($role);
		}

		foreach ($this->privateResources as $resource => $actions) {
	    	$this->_acl->addResource(new PhalconACL\Resource($resource), $actions);
			foreach($actions as $action) {
				$this->_acl->allow('Admins', $resource, $action);
			}
		}

		foreach ($this->publicResources as $resource => $actions) {
		    $this->_acl->addResource(new PhalconACL\Resource($resource), $actions);
			foreach ($this->roles as $role) {
				foreach($actions as $action) {
					$this->_acl->allow($role->getName(), $resource, $action);
				}
			}
		}
	}
	
	
}
