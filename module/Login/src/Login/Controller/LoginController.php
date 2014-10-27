<?php
namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Login\Model\Login;
use Login\Form\LoginForm;

class LoginController extends AbstractActionController
{
    protected $loginTable;

    public function loginAction()
    {
      $form = new LoginForm();
      $form->get('submit')->setValue('Go');

      $request = $this->getRequest();
      if ($request->isPost()) {
        $login = new Login();
        $form->setInputFilter($login->getInputFilter());
        $form->setData($request->getPost());

        if ($form->isValid()) {
          $login->exchangeArray($form->getData());
          $LoggedIn = $this->getLoginTable()->loginSearch($login);

          if ($LoggedIn) {
            echo 'login';
            //return $this->redirect()->toRoute('home');
          } else {
            echo 'nope';
          }
        }
      }

      return new ViewModel(array(
        'form' => $form,
      ));
    }

    public function logoutAction()
    {
    }

    public function getLoginTable()
    {
        if (!$this->loginTable) {
            $sm = $this->getServiceLocator();
            $this->loginTable = $sm->get('Login\Model\LoginTable');
        }
        return $this->loginTable;
    }
}
