<?php
namespace Blog\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Blog implements InputFilterAwareInterface
{
    public $id;
    public $unix_time;
    public $post_title;
    public $post_body;
    public $page_url;
    public $tags;
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id         = (isset($data['id'])) ? $data['id'] : null;
        $this->unix_time  = (isset($data['unix_time'])) ? $data['unix_time'] : null;
        $this->post_title = (isset($data['post_title'])) ? $data['post_title'] : null;
        $this->post_body  = (isset($data['post_body'])) ? $data['post_body'] : null;
        $this->page_url   = (isset($data['page_url'])) ? $data['page_url'] : null;
        $this->tags       = (isset($data['tags'])) ? $data['tags'] : null;
        $this->active     = (isset($data['active'])) ? $data['active'] : null;
    }

    public function getArrayCopy()
    {
      return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
       throw new \Exception("Not used");
    }

    public function getInputFilter()
     {
       if (!$this->inputFilter) {
           $inputFilter = new InputFilter();

           $inputFilter->add(array(
               'name'     => 'id',
               'required' => false,
               'filters'  => array(
                   array('name' => 'Int'),
               ),
           ));

           $inputFilter->add(array(
               'name'     => 'post_title',
               'required' => true,
               'filters'  => array(
                   array('name' => 'StripTags'),
                   array('name' => 'StringTrim'),
               ),
               'validators' => array(
                   array(
                       'name'    => 'StringLength',
                       'options' => array(
                           'encoding' => 'UTF-8',
                           'min'      => 1,
                           'max'      => 255,
                       ),
                   ),
               ),
           ));

           $inputFilter->add(array(
               'name'     => 'post_body',
               'required' => true,
               'filters'  => array(
                   array('name' => 'StripTags'),
                   array('name' => 'StringTrim'),
               ),
               'validators' => array(
                   array(
                       'name'    => 'StringLength',
                       'options' => array(
                           'encoding' => 'UTF-8',
                       ),
                   ),
               ),
           ));

           $inputFilter->add(array(
               'name'     => 'page_url',
               'required' => true,
               'filters'  => array(
                   array('name' => 'StripTags'),
                   array('name' => 'StringTrim'),
               ),
               'validators' => array(
                   array(
                       'name'    => 'StringLength',
                       'options' => array(
                           'encoding' => 'UTF-8',
                           'min'      => 1,
                           'max'      => 255,
                       ),
                   ),
               ),
           ));

           $inputFilter->add(array(
               'name'     => 'tags',
               'required' => true,
               'filters'  => array(
                   array('name' => 'StripTags'),
                   array('name' => 'StringTrim'),
               ),
               'validators' => array(
                   array(
                       'name'    => 'StringLength',
                       'options' => array(
                           'encoding' => 'UTF-8',
                           'min'      => 1,
                           'max'      => 255,
                       ),
                   ),
               ),
           ));

           $inputFilter->add(array(
               'name'     => 'active',
               'required' => false,
               'filters'  => array(
                   array('name' => 'StripTags'),
                   array('name' => 'StringTrim'),
               ),
               'validators' => array(
                   array(
                       'name'    => 'StringLength',
                       'options' => array(
                           'encoding' => 'UTF-8',
                           'min'      => 1,
                           'max'      => 255,
                       ),
                   ),
               ),
           ));

           $this->inputFilter = $inputFilter;
       }

       return $this->inputFilter;
   }
}
