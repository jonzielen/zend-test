<?php
namespace Blog\Form;

use Zend\Form\Form;

class BlogForm extends Form
{
   public function __construct($name = null)
   {
       // we want to ignore the name passed
       parent::__construct('blog');

       $this->add(array(
           'name' => 'id',
           'type' => 'Hidden',
       ));
       $this->add(array(
           'name' => 'post_title',
           'type' => 'Text',
           'options' => array(
               'label' => 'Title:',
           ),
       ));
       $this->add(array(
           'name' => 'page_url',
           'type' => 'Text',
           'options' => array(
               'label' => 'URL:',
           ),
       ));
       $this->add(array(
           'name' => 'tags',
           'type' => 'Text',
           'options' => array(
               'label' => 'Tags:',
           ),
       ));
       $this->add(array(
           'name' => 'post_body',
           'type' => 'Textarea',
           'options' => array(
               'label' => 'Body:',
           ),
       ));

       $this->add(array(
           'name' => 'active',
           'type' => 'Checkbox',
           'options' => array(
               'label' => 'Active:',
               'checked_value' => 1,
               'unchecked_value' => 0
           ),
           'attributes' => array(
               'value' => 1,
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
