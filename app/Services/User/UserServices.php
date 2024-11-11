<?php
namespace App\Services\User;

use App\Models\User;

class UserServices{

    public function create(array $data){
        return User::create($data);
    }
    public function findByColumnName(string $column,string $value):User|null{
        return User::where($column,$value)->first();
    }
}