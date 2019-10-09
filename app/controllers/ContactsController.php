<?php
namespace App\controllers;
use Core\Controller;
use Core\Session;
use Core\Router;
use Core\FH;
use Core\H;
use App\models\Contacts;
use App\models\Users;

class ContactsController extends Controller
{

  public function __construct($controller, $action)
  {
    parent::__construct($controller, $action);
    $this->view->setLayout('default');
    $this->load_model('Contacts');
  }

  public function indexAction()
  {
    $contacts = $this->ContactsModel->findAllByUserId(Users::currentUser()->id, ['order'=>'`lname`, `fname`']);
    $this->view->contacts = $contacts;
    $this->view->render('contacts/index');
  }


  public function addAction()
  {
    $contact = new Contacts();

    if($this->request->isPost()){
      $this->request->csrfCheck();
      $contact->assign($_POST);
      $contact->user_id = Users::currentUser()->id;
      if($contact->save()){
        Session::set('swalMsgParams', ['type'=>'success', 'title'=>'Done', 'html'=>'Contact <strong><me>'.$contact->displayFullName().'</strong></me> added', 'showConfirmButton'=>true]);
        Router::redirect('contacts');
      }
    }

    $this->view->contact = $contact;
    $this->view->displayErrors = $contact->getErrorMessages();
    $this->view->postAction = PROOT . 'contacts' . DS . 'add';
    $this->view->render('contacts/add');
  }


  public function editAction($id)
  {
    $contact = $this->ContactsModel->findByIdAndUserId((int)$id, Users::currentUser()->id);
    if(!$contact){
      Router::redirect('contacts');
    }
    if($this->request->isPost()){
      $this->request->csrfCheck();
      $contact->assign($this->request->get());
      if($contact->save()){
        Session::set('swalMsgParams',
        ['type'=>'success',
        'title'=>'Done',
        'html'=>'Contact <strong><me>'.$contact->displayFullName().'</strong></me> updated.',
        'timer'=>1700,
        'position'=>'top-end',
        'showConfirmButton'=>true]);
        Router::redirect('contacts');
      }
    }

    $this->view->displayErrors = $contact->getErrorMessages();
    $this->view->contact = $contact;
    $this->view->postAction = PROOT . 'contacts' . DS . 'edit' . DS . $contact->id;
    $this->view->render('contacts/edit');
  }


  public function detailsAction($id)
  {
    $contact = $this->ContactsModel->findByIdAndUserId((int)$id, Users::currentUser()->id);

    if(!$contact){
      Router::redirect('contacts');
    }
    $this->view->contact = $contact;
    $this->view->render('contacts/details');
  }


  public function updateContactAction()
  {
    $response['success'] = false;
    if($this->request->isPost()){
      $response = [];
      $id = $this->request->get('contact_id');
      $field = $this->request->get('field');
      $oldValue = $this->request->get('value');
      $newValue = $this->request->get('newValue');
      $contact = $this->ContactsModel->findById($id);

      if($contact){
        if(property_exists($contact, $field)){
          $contact->$field = $newValue;
          $contact->save();
        }
        else if($field == 'fullname'){
          $fullname = explode(" ", trim(FH::sanitize($newValue)));
          if(count($fullname) < 2){
            $contact->addErrorMessage('fullname', 'You have to provide your full name.');
          }
          else{
            $contact->fname = $fullname[0];
            $contact->lname = $fullname[1];
            $contact->save();
          }
        }
        else{
          $response['errors']['wrong_field'] = 'There is no such data. Try again';
        }
        $response['validationErrors'] = $contact->getErrorMessages();
      }
      else{
        $response['errors']['no_data'] = 'Contact could not be found. Try again';
      }
    }

    if(empty($response['errors']) && empty($response['validationErrors'])){
      $response['success'] = true;
      $response['contact'] = $contact->displayFullName();
      $response['successMsg'] = 'Contact updated.';
    }
    $this->jsonResponse($response);
  }


  public function deleteAction($id)
  {
    $contact = $this->ContactsModel->findByIdAndUserId((int)$id, Users::currentUser()->id);
    if($contact){
      $contact->delete();
      Session::addMsg('success', 'Contact has been deleted.');
      Session::set('swalMsgParams', ['type'=>'success', 'title'=>'Deleted', 'html'=>'Contact <strong><em>'.$contact->displayFullName().'</em></strong> has been deleted.', 'showConfirmButton'=>true]);
    }
    Router::redirect('contacts');
  }




}
