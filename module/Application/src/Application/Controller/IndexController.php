<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $blogTable;

    public function indexAction()
    {

      $paginator = $this->getBlogTable()->homepagesFetch();

      return new ViewModel(array(
          'paginator' => $paginator
      ));
    }

    public function testAction() {

      return new ViewModel(array(
          'hello' => 'hello'
      ));
    }

    public function loginAction() {

      return new ViewModel(array(
          'hello' => 'hello'
      ));
    }

    public function adminAction() {

      return new ViewModel(array(
          'hello' => 'hello'
      ));
    }

    public function getBlogTable()
    {
        if (!$this->blogTable) {
            $sm = $this->getServiceLocator();
            $this->blogTable = $sm->get('Blog\Model\BlogTable');
        }
        return $this->blogTable;
    }
}
