<?php
namespace Core;
use Core\Session;
use App\models\Users;

class Router
{


	public static function route($url)
	{
		// controller
		$controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]).'Controller': DEFAULT_CONTROLLER.'Controller';
		$controller_name = str_replace('Contoller', '', $controller);
		array_shift($url);

		// action
		$action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action': 'indexAction';
		$action_name = (isset($url[0]) && $url[0] != '') ? $url[0] : 'index';
		array_shift($url);

		// acl check
		$grantAccess = self::hasAccess($controller_name, $action_name);
		if(!$grantAccess){
			$controller = ACCESS_RESTRICTED.'Controller';
			$controller_name = ACCESS_RESTRICTED;
			$action = 'indexAction';
		}

		// params
		$queryParams = $url;
		$controller = 'App\Controllers\\'.$controller;
		if(class_exists($controller)){

			$dispatch = new $controller($controller_name, $action);

			if(method_exists($controller, $action)){
				call_user_func_array([$dispatch, $action], $queryParams);
			}
			else{
				die('Method "'.$action.'" does not exist in controller: '.$controller_name);
			}
		}
		else{
			die('Controller '.$controller_name.' does not exist');
		}
	}


	public static function redirect($location)
	{
		if(!headers_sent()){
			header('Location: '.PROOT.$location);
			exit();
		}
		else{
			echo '<script>window.location.href="'.PROOT.$location.'";</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url="'.$location.'">';
			echo '</noscript>';
			exit();
		}
	}


	public static function hasAccess($controller_name, $action_name = 'index')
	{
		$acl_file = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
		$acl = json_decode($acl_file, true);

		$current_user_acls = ["Guest"];
		$grantAccess = false;

		if(Session::exists(CURRENT_USER_SESSION_NAME)){

			$current_user_acls[] = "LoggedIn";
			foreach(Users::currentUser()->acls() as $a){
				$current_user_acls[] = $a;
			}
		}


		foreach($current_user_acls as $level){
			if(array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])){
				if(in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])){
					$grantAccess = true;
					break;
				}
			}
		}

		// check for denied
		foreach($current_user_acls as $level){
			$denied = $acl[$level]['denied'];

			if(!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])){
				$grantAccess = false;
				break;
			}
		}

		return $grantAccess;

	}



	public static function getMenu($menu)
	{
		$menuArr = [];
		$menuFile = file_get_contents(ROOT . DS . 'app' . DS . $menu . '.json');
		$acl = json_decode($menuFile, true);


		foreach($acl as $key => $value){
			if(is_array($value)){
				$sub = [];
				foreach($value as $k => $v){
					if($k == 'separator' && !empty($sub)){
						$sub[$k] = '';
						continue;
					}
					else if($finalVal = self::get_link($v)){
						$sub[$k] = $finalVal;
					}
				}
				if(!empty($sub)){
					$menuArr[$key] = $sub;
				}
			}
			else{
				if($finalVal = self::get_link($value)){
					$menuArr[$key] = $finalVal;
				}
			}
		}
		return $menuArr;
	}


	private static function get_link($val)
	{
		if(preg_match('/https?:\/\//', $val) == 1){
			return $val;
		}
		else{
			$uArr = explode('/', $val);
			$controller_name = ucwords($uArr[0].'Controller');
			$action_name = (isset($uArr[1])) ? $uArr[1] : '';
			if(self::hasAccess($controller_name, $action_name)){
				return PROOT . $val;
			}
			return false;
		}
		return PROOT . $val;
	}


}
