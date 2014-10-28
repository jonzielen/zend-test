<?php
namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Login\Model\Login;
use Login\Form\LoginForm;
use Zend\Authentication\Result;
use Zend\Session\Container;

class LoginController extends AbstractActionController
{
    protected $loginTable;
    protected $loginCred;

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
          $this->testCredential($login);
        }
      }

      return new ViewModel(array(
        'form' => $form,
      ));
    }

    public function logoutAction()
    {
      unset($_SESSION['user']);
    }

    public function testCredential($login)
    {
        if (!$this->loginCred) {
            $sm = $this->getServiceLocator();
            $this->loginCred = $sm->get('CredentialsGateway');
            $this->loginCred->setTableName('zend_login')->setIdentityColumn('username')->setCredentialColumn('password');
            $this->loginCred->setIdentity($login->username)->setCredential($login->password);
            $result = $this->loginCred->authenticate();

            $columnsToReturn = array('id', 'username', 'role');

            $userInfo = $this->loginCred->getResultRowObject($columnsToReturn);

            switch ($result->getCode()) {
              case Result::FAILURE_IDENTITY_NOT_FOUND:
              echo "FAILURE_IDENTITY_NOT_FOUND";
              break;

              case Result::FAILURE_CREDENTIAL_INVALID:
              /** do stuff for invalid credential **/
              echo "FAILURE_CREDENTIAL_INVALID";
              break;

              case Result::SUCCESS:
              /** do stuff for successful authentication **/
              $this->userloginAction($userInfo);
              break;

              default:
              /** do stuff for other failure **/
              echo "Default";
              break;
            }
        }
    }

    private function userloginAction($userInfo)
    {
      $user_session = new Container('user');
      $user_session->username = $userInfo->username;
      $user_session->role = $userInfo->role;
      $user_session->loggedin = true;
    }
}
