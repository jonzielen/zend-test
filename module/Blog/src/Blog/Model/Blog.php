<?php
namespace Blog\Model;

class Blog
{
    public $id;
    public $unix_time;
    public $post_title;
    public $post_body;
    public $page_url;
    public $tags;

    public function exchangeArray($data)
    {
        $this->id         = (isset($data['id'])) ? $data['id'] : null;
        $this->unix_time  = (isset($data['unix_time'])) ? $data['unix_time'] : null;
        $this->post_title = (isset($data['post_title'])) ? $data['post_title'] : null;
        $this->post_body  = (isset($data['post_body'])) ? $data['post_body'] : null;
        $this->page_url   = (isset($data['page_url'])) ? $data['page_url'] : null;
        $this->tags       = (isset($data['tags'])) ? $data['tags'] : null;
    }
}
