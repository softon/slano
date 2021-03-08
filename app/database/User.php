<?php

namespace App\Database;



class User extends Model {


    public function getName() {
        
        return $this->username;
    }
}