<?php


namespace Application\Controllers;


use Application\Repositories\CommentRepository;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class CommentController
{
    const key = '64646400';
    private $commentRepository;
    public $data;
    public function __construct()
    {
        $this->commentRepository=new CommentRepository();
        $this->data = json_decode(file_get_contents("php://input"));
    }
    public function add()
    {
        $jwt = isset($this->data->jwt) ? $this->data->jwt : "";
        $decoded = JWT::decode($jwt, UserController::key, array('HS256'));
        if ($jwt) {


            $newPostData = [
                'comment_user_id' => $decoded->id,
                'comment_title' => $this->data->comment_title,
                'comment_body' => $this->data->comment_body,
                'comment_created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
            $result = $this->commentRepository->create($newPostData);

            if ($result ) {
                $data = ['action' => 'success add comment', 'massage' => ''];

            } else {
                $data = ['action' => 'failed add', 'massage' => ''];
            }
            logging::logging($data);
            jsondata::ReturnJson($data);


        }
    }

    public function edit()
    {

    }

    public function del()
    {

    }
}