<?php

namespace App\Config;

class Config {
        
    public function __construct() {
        # mysql
        $this->mysql = $this->mysql();
        $this->mysql_local = $this->mysql_local();
                
        # mariadb
        $this->mariadb = $this->mariadb();
        $this->mariadb_local = $this->mariadb_local();
        
        # sqlserver
        $this->sqlserver = $this->sqlserver();
                
        # ldap
        $this->ldap = $this->ldap();
        
        # postgree
        $this->postgree = $this->postgree();
        
        #oracle
        $this->oracle = $this->oracle();
    }
    
    public function mariadb_local(){
        return [
            'driver' => env('MARIADB_LOCAL_DRIVE'),
            'host' => env('MARIADB_LOCAL_HOST'),
            'port' => env('MARIADB_LOCAL_PORT'),
            'dbname' => env('MARIADB_LOCAL_DATABASE'),
            'user' => env('MARIADB_LOCAL_USER'),
            'pass' => env('MARIADB_LOCAL_PASSWORD')
        ];
    }
    
    public function mariadb(){
        return [
            'driver' => env('MARIADB_DRIVE'),
            'host' => env('MARIADB_HOST'),
            'port' => env('MARIADB_PORT'),
            'dbname' => env('MARIADB_DATABASE'),
            'user' => env('MARIADB_USER'),
            'pass' => env('MARIADB_PASSWORD')
        ];
    }
    
    public function mysql_local(){
        return [
            'driver' => env('MYSQL_LOCAL_DRIVE'),
            'host' => env('MYSQL_LOCAL_HOST'),
            'port' => env('MYSQL_LOCAL_PORT'),
            'dbname' => env('MYSQL_LOCAL_DATABASE'),
            'user' => env('MYSQL_LOCAL_USER'),
            'pass' => env('MYSQL_LOCAL_PASSWORD')
        ];
    }
    
    public function mysql(){
        return [
            'driver' => env('MYSQL_DRIVE'),
            'host' => env('MYSQL_HOST'),
            'port' => env('MYSQL_PORT'),
            'dbname' => env('MYSQL_DATABASE'),
            'user' => env('MYSQL_USER'),
            'pass' => env('MYSQL_PASSWORD')
        ];
    }
    
    public function sqlserver(){
        return [
            'driver' => env('MSSQL_DRIVE'),
            'host' => env('MSSQL_HOST'),
            'port' => env('MSSQL_PORT'),
            'dbname' => env('MSSQL_DATABASE'),
            'user' => env('MSSQL_USER'),
            'pass' => env('MSSQL_PASSWORD')
        ];
    }
        
    public function ldap(){
        return [
            'host'      => env('LDAP_HOST'),
            'porta'     => env('LDAP_PORT'),
            'ssl'       => env('LDAP_SSL'),
            'basedn'    => env('LDAP_BASEDN'),
            'usuario'   => env('LDAP_USER'),
            'senha'     => env('LDAP_PASSWORD'),
            'dominio'   => env('LDAP_DOMAIN')
        ];
    }
    
    public function postgree(){
        return [
            'driver'    => env('POSTGREE_DRIVE'),
            'host'      => env('POSTGREE_HOST'),
            'port'      => env('POSTGREE_PORT'),
            'dbname'    => env('POSTGREE_DATABASE'),
            'user'      => env('POSTGREE_USER'),
            'pass'      => env('POSTGREE_PASSWORD')
        ];
    }    
    
    public function oracle(){
        return [
            'driver'    => env('ORACLE_DRIVE'),
            'host'      => env('ORACLE_HOST'),
            'port'      => env('ORACLE_PORT'),
            'dbname'    => env('ORACLE_DATABASE'),
            'user'      => env('ORACLE_USER'),
            'pass'      => env('ORACLE_PASSWORD'),
            'tns'       => env('ORACLE_TNS')
        ];
    }
}
