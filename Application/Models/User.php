<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/26/2017
 * Time: 6:11 PM
 */

namespace Application\Models;



class User extends BaseModel {
    public $PrimaryKey="user_id";
    public $TableName ="users";
    public $datamembers = array();
}