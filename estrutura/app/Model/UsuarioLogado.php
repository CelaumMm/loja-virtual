<?php

namespace App\Model;

use App\Model\Model;
use App\Model\UsuarioBanco;

class UsuarioLogado extends Model {
    
    private $table = 'sessions';

    public function getAll() {
        $this->setQuery("SELECT * FROM $this->table");

        if ($this->execute()) {
            $resultSet = $this->resultSet();

            if (isset($resultSet))
                return $resultSet;
            else
                return "SESSION ERROR!";
        }

        return false;
    }

    public function getAllUser() {
        $sql = "SELECT * FROM $this->table WHERE usuarios_id IS NOT NULL ORDER BY nome ASC";
        
        $this->setQuery($sql);

        if ($this->execute()) {
            $resultSet = $this->resultSet();

            if (isset($resultSet)){
                return $resultSet;
            }else{
                return "SESSION ERROR!";
            }
        }

        return false;
    }
    
    public function getAllVisitante() {
        $sql = " SELECT * FROM $this->table WHERE usuarios_id IS NULL";
        
        $this->setQuery($sql);

        if ($this->execute()) {
            $resultSet = $this->resultSet();

            if (isset($resultSet)){                
                return count($resultSet);
            }
        }

        return false;
    }
    
    public function deslogarAllUsersMenosUser($usuarios_id) {
        try {
            $this->setQuery("DELETE FROM $this->table WHERE usuarios_id IS NOT NULL AND usuarios_id <> :usuarios_id");

            $this->bind(':usuarios_id', $usuarios_id);

            if ($this->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function deslogarUser($usuarios_id) {
        try {
            $this->setQuery("DELETE FROM $this->table WHERE usuarios_id = :usuarios_id");

            $this->bind(':usuarios_id', $usuarios_id);

            if ($this->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function bloquearUser($usuarios_id) {        
        
        // Deslogando o usuario
        $this->deslogarUser($usuarios_id);
        
        // Desativando o usuario
        $usuarioBanco = new UsuarioBanco();
        $usuarioBanco->ativarDesativarUsuarioById(['ativo' => 0, 'id' => $usuarios_id]);
        
    }
    
    public function deslogarAllVisitantes() {
        try {
            $this->setQuery("DELETE FROM $this->table WHERE usuarios_id IS NULL");

            if ($this->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function quantosUsuarios() {
        $sessions = $this->getAllUser();
        
        // Criando uma array de usuarios com o array de sessions
        $usuarios = []; 
        foreach ($sessions as $k => $v) {
            $usuarioBanco = new UsuarioBanco();
            $localizacao = $usuarioBanco->getEndereco($v['usuarios_id']);
            $localizacao = getValue($localizacao);
                                    
            $usuarios[$k] = [
                'usuarios_id' => $v['usuarios_id'],
                'nome' => $v['nome'],
                'localizacao' => $localizacao['dados'],
            ];
        }

        // Limpando os usuarios duplicados
        $usuarios = array_unique_multidimensional($usuarios, 'nome');
            
        return ['total' => sizeof($usuarios), 'usuarios' => $usuarios];
    }
}
?>
