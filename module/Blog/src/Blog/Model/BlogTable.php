<?php
namespace Blog\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class BlogTable
{
    protected $tableGateway;
    protected $bpf;

    public function __construct(TableGateway $tableGateway, BlogPostFormat $bpf)
    {
        $this->tableGateway = $tableGateway;
        $this->bpf = $bpf;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(function(Select $select) {
          $select->order(array('id DESC'))->limit(5);
        });
        return $resultSet;
    }

    public function tagSearch($url_param_tag)
    {
      $rowset = $this->tableGateway->select(function (Select $select) use ($url_param_tag) {
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
        $row->tags = $this->bpf->keyWordTags($row->tags);
      }

      if (!$row) {
          throw new \Exception("Could not find row $page_url");
      }
      return $row;
    }

    public function saveBlog(Blog $blog)
    {
        $data = array(
            'post_title'    => $blog->post_title,
            'post_body'     => $blog->post_body,
            'page_url'      => $blog->page_url,
            'tags'          => $blog->tags,
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
