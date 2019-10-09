<?php
namespace App\controllers;
use Core\Controller;
use Core\Input;
use Core\H;
use App\Models\Users;

class HomeController extends Controller
{

	public function __construct($controller, $action)
	{
		parent::__construct($controller, $action);
	}


	public function indexAction()
	{
		$this->view->render('home/index');
	}



}
