<?php
namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Login\Model\Login;
use Login\Form\LoginForm;
use Zend\Authentication\Result;

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
    }

    public function testCredential($login)
    {
        if (!$this->loginCred) {
            $sm = $this->getServiceLocator();
            $this->loginCred = $sm->get('CredentialsGateway');
            $this->loginCred->setTableName('zend_login')->setIdentityColumn('username')->setCredentialColumn('password');
            $this->loginCred->setIdentity($login->username)->setCredential($login->password);
            $result = $this->loginCred->authenticate();

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
              echo "SUCCESS";
              break;

              default:
              /** do stuff for other failure **/
              echo "Default";
              break;
            }
        }
    }
}
