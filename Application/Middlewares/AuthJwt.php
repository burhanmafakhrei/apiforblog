<?php


namespace Application\Middlewares;


use Application\Models\User;
use Application\Repositories\UserRepository;
use Application\Services\jsondata\jsondata;
use Firebase\JWT\JWT;

class AuthJwt
{
    private $usersRepository;
    public $data;
    const key = '64646400';

    public function __construct()
    {
        $this->usersRepository = new UserRepository();
        $this->data = json_decode(file_get_contents("php://input"));

    }

    public function handle()
    {


        $jwt = isset($this->data->jwt) ? $this->data->jwt : "";
        if ($jwt) {
            $decoded = JWT::decode($jwt, AuthJwt::key, array('HS256'));
            $criteria = [
                'user_email' => $decoded->email,
                'user_password' => ($decoded->password)
            ];
            $result = $this->usersRepository->findBy($criteria, 1);
            if ($result && $result instanceof User) {
                return true;
            } else {
                return false;
            }

        }
    }
}