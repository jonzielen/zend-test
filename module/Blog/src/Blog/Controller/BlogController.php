<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Model\Blog;
use Blog\Form\BlogForm;
use Zend\Http\Response;

class BlogController extends AbstractActionController
{
    protected $blogTable;

    public function indexAction()
    {
      // grab the paginator from the BlogTable
      $paginator = $this->getBlogTable()->fetchAll(true);
      // set the current page to what has been passed in query string, or to 1 if none set
      $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
      // set the number of items per page to 5
      $paginator->setItemCountPerPage(5);

      return new ViewModel(array(
          'paginator' => $paginator
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
      $form = new BlogForm();
      $form->get('submit')->setValue('Go');

      $request = $this->getRequest();
      if ($request->isPost()) {
        $blog = new Blog();
        $form->setInputFilter($blog->getInputFilter());
        $form->setData($request->getPost());

        if ($form->isValid()) {
          $blog->exchangeArray($form->getData());
          $this->getBlogTable()->saveBlog($blog);

          // Redirect to list of blog posts
          return $this->redirect()->toRoute('blog');
        }
      }

      return new ViewModel(array(
        'form' => $form,
      ));
    }

    public function editAction()
    {
      $slug = $this->params()->fromRoute('slug');
      $blog = $this->getBlogTable()->getBlog($slug);

      // send to 404 error
      if ($blog->page_url == '' || $blog->page_url == '') {
        $this->getResponse()->setStatusCode(404);
        return;
      }

      $form  = new BlogForm();
      $form->bind($blog);
      $form->get('submit')->setAttribute('value', 'Save');

      $request = $this->getRequest();
      if ($request->isPost()) {
          $form->setInputFilter($blog->getInputFilter());
          $form->setData($request->getPost());

          if ($form->isValid()) {
              $this->getBlogTable()->saveBlog($form->getData());

              // Redirect to blog
              return $this->redirect()->toRoute('blog');
          }
      }

      return array(
          'slug' => $slug,
          'form' => $form,
      );
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
