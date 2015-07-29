<?php
@session_start();

date_default_timezone_set('Asia/Taipei');
/**
 * Very simple MVC structure
 */
$loader = new \Phalcon\Loader();

$loader->registerDirs(array('../apps/controllers/', '../apps/models/', '../apps/library/'));

$loader->register();

$di = new \Phalcon\DI();
//Registering a dispatcher

$di->set('dispatcher', function () use ($di) {
	//Attach a event listener to the dispatcher
	$eventManager = new \Phalcon\Events\Manager();
	$eventManager->attach('dispatch', new \Acl());

	$dispatcher = new \Phalcon\Mvc\Dispatcher();
	//Bind the EventsManager to the Dispatcher
	$dispatcher->setEventsManager($eventManager);

	return $dispatcher;
});

// set session
$di->setShared('session', function() {
	$session = new Phalcon\Session\Adapter\Files();
	$session->start();
	return $session;
});
	
//Registering a router
$di->set('router', 'Phalcon\Mvc\Router');

//Registering a Http\Response
$di->set('response', 'Phalcon\Http\Response');

//Registering a Http\Request
$di->set('request', 'Phalcon\Http\Request');

//Registering the view component
$di->set('view', function(){
	$view = new \Phalcon\Mvc\View();
	$view->setViewsDir('../apps/views/');
	return $view;
});

	$config = new \Phalcon\Config\Adapter\Ini("../apps/config/config.ini");
	
	$di->set('config',$config);

//Registering the Models-Metadata
$di->set('modelsMetadata', 'Phalcon\Mvc\Model\Metadata\Memory');

//Registering the Models Manager
$di->set('modelsManager', 'Phalcon\Mvc\Model\Manager');

//Registering the Assets Manager
$di->set('assets', 'Phalcon\Assets\Manager');

//Registering the URL Service
$di->set('url', '\Phalcon\Mvc\Url');

//Registering the Escaper Service
$di->set('escaper', '\Phalcon\Escaper');

$config = $di->get('config');
$db_config = $config->dev_database ;

$db = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
		"host" => $db_config->host,
		"username" => $db_config->username,
		"password" => $db_config->password,
		"dbname" => $db_config->dbname,
		'charset' => 'latin1'
));

$di->set('db',$db);

$router =  new \Phalcon\Mvc\Router();
$di->set('router', $router);

// default
$router->add("/", array(
		'controller' => 'user',
		'action' => 'login'
));

//Registering a Http\Response
$di->set('response', 'Phalcon\Http\Response');

//Registering a Http\Request
$di->set('request', 'Phalcon\Http\Request');

//to check api-key with config
$config = new \Phalcon\Config\Adapter\Ini("../apps/config/config.ini");

if($config->site->env == 'development') {
	$user_info = array(
			'email' => 'franky@ink.net.tw',
			'sso_id' => '3e8a54fd43234d0ba1304aaf499c4c95',
			'nickname' => 'Franky',
			'access_token' => '',
			'app' => ''
	);
		
	$_SESSION['USER']['INFO'] = $user_info;
}

//check token from user
if(isset($_GET["token"])) {
	
	$_sso_id = $_GET["sso_id"];
	$_token = $_GET["token"];
	
	//if user and token pair exists, then continue...
	if(User::count("sso_id = '{$_sso_id}' AND token = '{$_token}'") > 0) {
	
		$user = User::findFirst("sso_id = '{$_sso_id}' AND token = '{$_token}'");
	
		$time_passed = (strtotime("now") - strtotime($user->token_created));
		
		//if time passed > 10 min, then do nothing
		if($time_passed <= 600) {
			
			$user_info = array(
					'email' => $user->email,
					'sso_id' => $user->sso_id,
					'nickname' => $user->nickname,
					'access_token' => $user->token,
					'app' => ''
			);
			
			$_SESSION['USER']['INFO'] = $user_info;

		}
	}
}

$db = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
		"host" => $db_config->host,
		"username" => $db_config->username,
		"password" => $db_config->password,
		"dbname" => $db_config->dbname,
		'charset' => 'latin1'
));

try {
	$application = new \Phalcon\Mvc\Application();
	$application->setDI($di);
	echo $application->handle()->getContent();
}
catch(Phalcon\Exception $e){
	echo $e->getMessage();
}
