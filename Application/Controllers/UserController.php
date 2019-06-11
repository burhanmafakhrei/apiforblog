<?php


namespace Application\Controllers;


use Application\Models\User;
use Application\Repositories\UserRepository;
use Application\Services\jsondata\jsondata;
use Application\Services\logging\logging;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class UserController
{
    const key = '64646400';
    private $usersRepository;
    public $data;

    public function __construct()
    {
       $this->usersRepository=new UserRepository();
        $this->data = json_decode(file_get_contents("php://input"));
    }

    public function add()
    {
        if (!$this->HasEmail($this->data->email)) {
            $newUserData = [
                'user_name' => $this->data->name,
                'user_email' => $this->data->email,
                'user_number' => $this->data->number,
                'user_password' => md5($this->data->password),
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'user_created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
            $result = $this->usersRepository->create($newUserData);

            if ($result) {
                $data = ['action' => 'success register', 'massage' => $result->user_email];

            } else {
                $data = ['action' => 'failed register', 'massage' => ''];
            }
            logging::logging($data);
            jsondata::ReturnJson($data);


        }
    }


    public function DuplicateEmail(string $email)
    {
        $criteria = [
            'user_email' => $email
        ];
        $result = $this->usersRepository->findBy($criteria);
        if ($result) {
            $data = ['action' => 'failed register', 'massage' => 'email is duplicate'];
            logging::logging($data);
            jsondata::ReturnJson($data);
            return true;
        }


    }

    public function HasEmail($email)
    {
        $result=$this->usersRepository->find('user_email',$email);
        if ($result) {
            $data = ['action' => 'failed register', 'massage' => 'email is duplicate'];
            logging::logging($data);
            jsondata::ReturnJson($data);
            return true;
        } else {
            return false;
        }

    }

    public function login()
    {
        $criteria = [
            'user_email' => $this->data->email,
            'user_password' => md5($this->data->password)
        ];
        $result = $this->usersRepository->findBy($criteria);
        if ($result){
            $row = $result->fetch_assoc();
            $token = $this->GetJwt($row);
            $data = ['action' => 'success login', 'massage' => $row["user_email"], 'jwt' => $token];
        }
        else{
            $data = ['action' => 'failed login', 'massage' => 'email or password mistake'];
        }
        logging::logging($data);
        jsondata::ReturnJson($data);
    }

    public function GetJwt($row)
    {

        $token = array(
            "id" => $row["user_id"],
            "email" => $row["user_email"],
            "password" =>$row["user_password"]
        );
        $jwt = JWT::encode($token, UserController::key);

        return $jwt;
    }

    public function logined()
    {
        // get jwt
        $jwt = isset($this->data->jwt) ? $this->data->jwt : "";
        if ($jwt) {
            $decoded = JWT::decode($jwt, UserController::key, array('HS256'));
            $criteria = [
                'user_email' => $this->$decoded->email,
                'user_password' => md5($decoded->password)
            ];
            $result = $this->usersRepository->findBy($criteria);
            if ($result){
                return true;
            }else{
                false;
            }
        }

    }
}