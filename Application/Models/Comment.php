<?php


namespace Application\Models;


class Comment extends BaseModel
{
    public $PrimaryKey="comment_id";
    public $TableName ="comments";
    public $datamembers = array();
}