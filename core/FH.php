<?php
namespace Core;
use Core\Session;

class FH
{


  public static function inputBlock($type, $label, $name, $value = '', $inputAttrs = [], $divAtrrs = []){
    $divString = self::stringifyAttrs($divAtrrs);
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div '.$divString.'>';
    $html .= '<label for="'.$name.'">'.$label.'</label>';
    $html .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$inputString.'>';
    $html .= '</div>';

    return $html;
  }


  public static function sanitize($dirty){
  	return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
  }


  public static function posted_values($post){
  	$clean_arr = [];
  	foreach($post as $key => $value){
  		$clean_arr[$key] = self::sanitize($value);
  	}
  	return $clean_arr;
  }


  public static function submitTag($btnText, $inputAttrs = []){
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<input type="submit" value="'.$btnText.'" '.$inputString.'>';
    return $html;
  }


  public static function submitBlock($btnText, $inputAttrs = [], $divAtrrs = []){
    $divString = self::stringifyAttrs($divAtrrs);
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div '.$divString.'>';
    $html .= '<input type="submit" value="'.$btnText.'" '.$inputString.'>';
    $html .= '</div>';
    return $html;
  }


  public static function checkboxBlock($label, $name, $check=false, $inputAttrs = [], $divAtrrs = [])
  {
    $divString = self::stringifyAttrs($divAtrrs);
    $inputString = self::stringifyAttrs($inputAttrs);
    $checkedString = ($check) ? ' checked="checked"' : '';
    $html = '<div '.$divString.'>';
    $html .= '<label for="'.$name.'">'.$label.' <input type="checkbox" id="'.$name.'" name="'.$name.'" value="on" '.$checkedString.$inputString.'></label>';
    $html .= '</div>';
    return $html;

  }


  public static function stringifyAttrs($attrs){
    $string = '';
    foreach($attrs as $key => $value){
      $string .= ' ' .$key .' = "' . $value . '"';
    }
    return $string;
  }


  public static function generateToken()
  {
    $token = base64_encode(openssl_random_pseudo_bytes(32));
    Session::set('csrf_token', $token);

    return $token;
  }


  public static function checkToken($token)
  {
    return (Session::exists('csrf_token') && Session::get('csrf_token') == $token);
  }


  public static function csrfInput()
  {
    return '<input type="hidden" name="csrf_token" id="csrf_token" value="'.self::generateToken().'">';
  }

  public static function displayErrors($errors)
  {
    $html = '<div class="form-errors"><ul class="list-group">';
    foreach($errors as $field => $error)
    {

      $html .= '<li class="list-group-item list-group-item-danger">'.$error.'</li>';
      //$html .= '<script>jQuery("document").ready(function(){jQuery("#'.$field.'").parent().closest("div").addClass("is-invalid")})</script>'; // for bootstrap old versions
      $html .= '<script>jQuery("document").ready(function(){jQuery("#'.$field.'").addClass("is-invalid")})</script>'; // for bootstrap 4 version


    }
    $html .= '</ul></div>';
    return $html;
  }


}
