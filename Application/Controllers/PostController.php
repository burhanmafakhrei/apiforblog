<?php


namespace Application\Controllers;


use Application\Models\Post;
use Application\Repositories\PostRepository;
use Application\Services\jsondata\jsondata;
use Application\Services\logging\logging;
use Carbon\Carbon;

class PostController
{
    private $PostRepository;
    public $data;

    public function __construct()
    {
        $this->PostRepository = new PostRepository();
        $this->data = json_decode(file_get_contents("php://input"));

    }

    public function add()
    {
        $jwt = isset($this->data->jwt) ? $this->data->jwt : "";
        $decoded = JWT::decode($jwt, UserController::key, array('HS256'));
        if ($jwt) {


            $newPostData = [
                'post_user_id' => $this->$decoded->id,
                'post_title' => $this->data->post_title,
                'post_body' => $this->data->post_body,
                'post_created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
            $result = $this->PostRepository->create($newPostData);

            if ($result && $result instanceof Post) {
                $data = ['action' => 'success add post', 'massage' => $result->post_id];

            } else {
                $data = ['action' => 'failed add', 'massage' => ''];
            }
            logging::logging($data);
            jsondata::ReturnJson($data);


        }
    }
}