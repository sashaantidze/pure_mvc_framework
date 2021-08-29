<?php
namespace App\controllers;
use Core\Controller;
use Core\Session;
use Core\Router;
use Core\H;
use App\models\Users;
use App\models\Login;

class RegisterController extends Controller
{

  public function __construct($controller, $action)
  {
    parent::__construct($controller, $action);
    $this->load_model('Users');
    $this->view->setLayout('default');
  }

  public function indexAction()
  {
    $this->view->render('register/index');

  }

  public function loginAction()
  {
    $loginModel = new Login();

    if($this->request->isPost()){
      $this->request->csrfCheck();
      $loginModel->assign($this->request->get());

      $loginModel->validator();
      if($loginModel->validationPassed()){

        $user = $this->UsersModel->findByUsername($this->request->get('username'));
        if($user && password_verify($this->request->get('password'), $user->password)){
          $remember = $loginModel->getRememberMeChecked();
          $user->login($remember);
          Session::set('swalMsgParams', ['type'=>'success', 'title'=>'Welcome', 'html'=>'You have logged in successfully', 'showConfirmButton'=>true]);
          Router::redirect('home');
        }
        else{
          $loginModel->addErrorMessage('username','Error with your username or password');
        }

      }

    }
    $this->view->login = $loginModel;
    $this->view->displayErrors = $loginModel->getErrorMessages();
    $this->view->render('register/login');
  }


  public function logoutAction()
  {
    if(Users::currentUser()){
      Users::currentUser()->logout();
    }
    Router::redirect('register');
  }


  public function registerAction()
  {
    $newUser = new Users();
    if($this->request->isPost()){
      $this->request->csrfCheck();
      //H::dnd($this->request->get(), true);
      $newUser->assign($this->request->get());
      $newUser->setConfirm($this->request->get('confirm'));
      if($newUser->save()){
        Router::redirect('register/login');
      }

    }
    $this->view->newUser = $newUser;
    $this->view->displayErrors = $newUser->getErrorMessages();
    $this->view->render('register/register');
  }


  public function profileAction()
  {
    $user = Users::currentUser();

    if($this->request->isPost()){
      $this->request->csrfCheck();
      $user->assign($this->request->get());
      if($user->save()){
        Router::redirect('home');
      }
    }

    $this->view->user = $user;
    $this->view->displayErrors = $user->getErrorMessages();
    $this->view->render('register/profile');
  }



}
