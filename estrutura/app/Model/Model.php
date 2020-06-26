<?php

namespace App\Model;

use App\Core\DB;
use App\Config\Config;

class Model extends DB {

    public function __construct() {
        $config = new Config();
        
        if(env('APP_ENV') == 'producao' || env('APP_ENV') == 'production'){
            parent::__construct($config->mysql);
        }else{
            parent::__construct($config->mysql_local);
        }
    }

    public function responseJson($data) {
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($data);
    }
}