<?php

namespace App\Model;

use App\Model\Model;
use App\Core\Template;

/**
 * Model para tabela de Categorias
 *
 * @author - Marcelo Camargo
 */
class Categoria extends Model {

    private $table = 'categorias';

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
}
