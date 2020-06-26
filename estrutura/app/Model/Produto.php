<?php

namespace App\Model;

use App\Model\Model;
use App\Core\Template;

/**
 * Model para taberla de Produtos
 *
 * @author - Marcelo Camargo
 */
class Produto extends Model {

    private $table = 'produtos';

    public function responseJson($dados) {
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($dados);
    }


    public function find($id) {
        try {
            $this->setQuery("SELECT * FROM $this->table WHERE id=:id");

            $this->bind(':id', $id);

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->single()
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o produto no banco de dados.'];
            }
        }
    }

    public function marcas() {
        try {
            $this->setQuery("SELECT DISTINCT(marca) FROM $this->table WHERE status = '1' ORDER BY marca ASC");

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->resultSet()
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o produto no banco de dados.'];
            }
        }
    }

    public function rams() {
        try {
            $this->setQuery("SELECT DISTINCT(ram) FROM $this->table WHERE status = '1' ORDER BY ram ASC");

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->resultSet()
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o produto no banco de dados.'];
            }
        }
    }

    public function armazenamentos() {
        try {
            $this->setQuery("SELECT DISTINCT(armazenamento) FROM $this->table WHERE status = '1' ORDER BY armazenamento DESC");

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->resultSet()
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o produto no banco de dados.'];
            }
        }
    }

    public function findAll() {
        try {
            $this->setQuery("SELECT * FROM $this->table");

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->resultSet()
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o produto no banco de dados.'];
            }
        }
    }

    public function filterJson($dados) {
        $response = $this->filter($dados);
        $this->responseJson($response);
    }

    public function filter($dados) {
        try {
            $query = "SELECT * FROM $this->table WHERE status = '1'";
    
            if(
                isset($dados["minimum_price"], $dados["maximum_price"]) && 
                !empty($dados["minimum_price"]) && !empty($dados["maximum_price"])
            ){
                $query .= " AND preco BETWEEN '".$dados["minimum_price"]."' AND '".$dados["maximum_price"]."'";
            }
        
            if(isset($dados["brand"])){
                $brand_filter = implode("','", $dados["brand"]);
                $query .= " AND marca IN('".$brand_filter."')";
            }
        
            if(isset($dados["ram"])){
                $ram_filter = implode("','", $dados["ram"]);
                $query .= " AND ram IN('".$ram_filter."')";
            }
         
            if(isset($dados["storage"])){
                $storage_filter = implode("','", $dados["storage"]);
                $query .= " AND armazenamento IN('".$storage_filter."')";
            }

            $this->setQuery($query);

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->resultSet()
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o produto no banco de dados.'];
            }
        }
    }
}
