<?php
namespace Login\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class LoginTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function loginSearch(Login $login)
    {
      $rowset = $this->tableGateway->select(function(Select $select) use ($login) {
        $select->where(array('username' => $login->username, 'password' => $login->password));
      });

      if (!$rowset) {
          throw new \Exception("Could not find row $login->username");
      }

      return $rowset->current();
    }
}
