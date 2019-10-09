<?php
namespace Core;
use Core\Swal;

class Session
{

  public static function exists($name)
  {
    return (isset($_SESSION[$name])) ? true : false;
  }


  public static function get($name)
  {
    return $_SESSION[$name];
  }


  public static function set($name, $value)
  {
    return $_SESSION[$name] = $value;
  }


  public static function delete($name)
  {
    if(self::exists($name)){
      unset($_SESSION[$name]);
    }
  }


  public static function uagent_no_version()
  {
    $uagent = $_SERVER['HTTP_USER_AGENT'];
    $regex = '/\/[a-zA-Z0-9.]+/';
    $newString = preg_replace($regex, '', $uagent);
    return $newString;
  }


  public static function createSwalMsg($sessName)
  {
    if(self::exists($sessName)){
      echo Swal::swalMessage(Session::get($sessName));
      self::delete($sessName);
    }
  }


  public static function displayMsg()
  {
    $alerts = ['alert-info', 'alert-success', 'alert-warning', 'alert-danger'];
    $html = '';
    foreach($alerts as $alert){
      if(self::exists($alert)){
        $html .= '<div class="alert '.$alert.' alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    '.self::get($alert).'
                  </div>';
        self::delete($alert);
      }
    }
    return $html;
  }


  public static function addMsg($type, $msg)
  {
    $sessionName = 'alert-'.$type;
    self::set($sessionName,$msg);
  }

}
