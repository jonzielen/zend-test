<?php
namespace Blog\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class BlogTable
{
    protected $tableGateway;
    protected $bpf;

    public function __construct(TableGateway $tableGateway, BlogPostFormat $bpf)
    {
        $this->tableGateway = $tableGateway;
        $this->bpf = $bpf;
    }

    public function fetchAll($paginated=false)
    {
        if($paginated) {
            // create a new Select object for the table blog_1
            $select = new Select('zend_blog_1');
            // create a new result set based on the Blog entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Blog());
            // create a new pagination adapter object
            $paginatorAdapter = new DbSelect(
                // our configured select object
                $select->order(array('id DESC')),
                // the adapter to run it against
                $this->tableGateway->getAdapter(),
                // the result set to hydrate
                $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        $resultSet = $this->tableGateway->select(function(Select $select) {
          $select->order(array('id DESC'));
        });
        return $resultSet;
    }

    public function homepagesFetch()
    {
        $resultSet = $this->tableGateway->select(function(Select $select) {
          $select->order(array('id DESC'));
          $select->limit(4);
        });
        return $resultSet;
    }

    public function tagSearch($url_param_tag)
    {
      $rowset = $this->tableGateway->select(function(Select $select) use ($url_param_tag) {
           $select->where->like('tags', "%{$url_param_tag}%");
      });

      if (!$rowset) {
          throw new \Exception("Could not find row $url_param_tag");
      }
      return $rowset;
    }

    public function getBlog($page_url)
    {
      $rowset = $this->tableGateway->select(array('page_url' => $page_url));
      $row = $rowset->current();

      if (!$row) {
          //throw new \Exception("Could not find row $page_url");
          $row = new \Blog\Model\Blog;
          $rowVars = get_object_vars($row);

          foreach($rowVars as $rowKey => $rowVals) {
            $row->$rowKey = '';
          }

          $row->post_title = 'A 404 error occurred';
          $row->post_body = '<h2>Page not found.</h2>';

          return $row;
      } else {
        // meta description
        if ($row->post_body) {
          $row->post_metaDescription = $this->bpf->metaDescriptionFromBody($row->post_body);
        }

        // format blog date
        if ($row->unix_time) {
          $row->date = gmdate('n/j/Y - g:ia', $row->unix_time);
        }

        // keyword tags
        if ($row->tags) {
          $row->keywords = $row->tags;
          $row->tagsLinks = $this->bpf->keyWordTags($row->tags);
        }

        return $row;
      }
    }

    public function saveBlog(Blog $blog)
    {
        $data = array(
            'post_title'    => $blog->post_title,
            'post_body'     => $blog->post_body,
            'page_url'      => $blog->page_url,
            'tags'          => $blog->tags,
            'active'        => $blog->active,
            'unix_time'     => time()-14400, // subtract 4 hours, fix timestamp
        );

        $id = (int)$blog->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getBlog($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteBlog($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
