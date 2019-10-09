<?php
namespace Core;

class H
{


  public static function dnd($data, $die = false){
  	if(is_array($data) || is_object($data)){
  		echo '<pre>';
  		print_r($data);
  		echo '</pre>';
  	}
  	else{
  		echo '<pre>';
  		var_dump($data);
  		echo '</pre>';
  	}
  	if($die){die();}
  }


  public static function currentPage()
  {
  	$currentPage = $_SERVER['REQUEST_URI'];
  	if($currentPage == PROOT || $currentPage == PROOT.'/home/index'){
  		$currentPage = PROOT . 'home';
  	}

  	return $currentPage;
  }


  public static function getObjectProperties($obj){
  	return get_object_vars($obj);
  }


}
