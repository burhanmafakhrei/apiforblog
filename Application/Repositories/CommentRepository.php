<?php


namespace Application\Repositories;


use Application\Models\Post;
use Application\Repositories\Contract\BaseRepository;

class CommentRepository extends BaseRepository
{
    protected static $model = Post::class;
}