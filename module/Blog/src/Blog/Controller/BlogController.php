<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{
    protected $blogTable;

    public function indexAction()
    {
      return new ViewModel(array(
          'blogposts' => $this->getBlogTable()->fetchAll(),
      ));
    }

    public function postAction()
    {
      $url_param = $this->params('slug');

      return new ViewModel(array(
          'post' => $this->getBlogTable()->getBlog($url_param),
      ));
    }

    public function tagsAction()
    {

      $url_param_tag = $this->params('slug');

      return new ViewModel(array(
          'url_param_tag' => $url_param_tag,
          'tag_list' => $this->getBlogTable()->tagSearch($url_param_tag),
      ));
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
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
