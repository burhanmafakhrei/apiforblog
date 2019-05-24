<?php


namespace Application\Repositories;


use Application\Models\Post;
use Application\Repositories\Contract\BaseRepository;

class PostRepository extends BaseRepository {

    protected static $model = Post::class;


}