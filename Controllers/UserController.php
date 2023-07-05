<?php

namespace Controllers;
use CustomExceptions\BadRequestException;
use CustomExceptions\ResourceNotFound;
use Helpers\RequestHelper;
use Models\User;
use Constants\Rules;

class UserController extends BaseController
{
    protected $validationSchema = [
        "create"=>[
            "payload"=>[
                "name"=>[Rules::REQUIRED,Rules::STRING],
                "username"=>[Rules::REQUIRED,Rules::STRING],
                "password"=>[Rules::REQUIRED,Rules::STRING],
                "email"=>[Rules::REQUIRED,Rules::STRING],
                "profile_img"=>[Rules::STRING]
            ]
        ],
        "update"=>[
            "payload"=>[
                "name"=>[Rules::STRING],
                "username"=>[Rules::STRING],
                "email"=>[Rules::STRING],
                "profile_img"=>[Rules::STRING]
            ]
        ]

    ];
    protected function index(){

        return User::all("id","username","profile_img");

    }
    protected function show($id){

       $user= User::query()->find($id);
       if(!$user){
           throw new ResourceNotFound();
       }
       return $user;
    }
    protected function create(){
        $payload =RequestHelper::getRequestPayload();
        $payload["password"]=md5($payload["password"]);

        $user = User::create($payload);
        return [
            "id" => $user->id
        ];
    }
    protected function update($id){
        $payload=RequestHelper::getRequestPayload();

        if(key_exists("password",$payload)){
            throw new BadRequestException("Unable to Update the password");
        }
        $user = $this->show($id);
        $user->update($payload);
        return [
            "message" => "updated"
        ];
    }

    protected function delete($id){
        $user = $this->show($id);
        $user->delete();
        return [
            "message"=>"deleted"
        ];
    }


   }