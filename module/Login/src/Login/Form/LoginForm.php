<?php
namespace Login\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
   public function __construct($name = null)
   {
     // we want to ignore the name passed
     parent::__construct('login');

     $this->add(array(
         'name' => 'username',
         'type' => 'Text',
         'options' => array(
             'label' => 'Username:',
         ),
     ));
     $this->add(array(
         'name' => 'password',
         'type' => 'Password',
         'options' => array(
             'label' => 'Password:',
         ),
     ));
     $this->add(array(
       'name' => 'submit',
       'type' => 'Submit',
       'attributes' => array(
           'value' => 'Go',
           'id' => 'submitButton',
       ),
     ));
   }
}
