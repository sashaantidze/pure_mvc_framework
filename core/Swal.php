<?php
namespace Core;

class Swal
{


  public static function swalMessage($params, $redirectParams = []){
    $swalParams = self::stringifySwalParams($params);
    $redirect = '';
    if($redirectParams){
      $redirect = 'setTimeout(function() {
                    window.location.href = "'.$redirectParams['path'].'";
                  }, '.$redirectParams['delay'].');';
    }

    $swal = '<script type="text/javascript">';
    $swal .= 'Swal.fire({'.$swalParams.'});';
    $swal .= $redirect;
    $swal .= '</script>';

    return $swal;
  }


  private static function stringifySwalParams($params){
    $string = '';
    foreach($params as $key => $value){
      $string .= $key.': "'.$value.'",';
    }
    return $string;
  }


}
