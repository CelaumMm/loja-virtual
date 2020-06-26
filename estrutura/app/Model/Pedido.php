<?php

namespace App\Model;

use App\Model\Model;
use App\Core\Template;
use App\Service\Carrinho;

/**
 * Model para tabela de Categorias
 *
 * @author - Marcelo Camargo
 */
class Pedido extends Model {

    private $table = 'pedidos';
    private $table_produtos = 'produtos';
    private $table_pedidos_produtos = 'pedidos_produtos';

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

    public function findAllUsuario($usuario_id) {
        try {
            
            $this->setQuery("
                select 
                    p.id as pedido_id,
                    pd.id as produto_id,
                    pd.nome,
                    pd.imagem,
                    pd.preco,
                    pd.quantidade,
                    p.status
                from $this->table p 
                    inner join $this->table_pedidos_produtos pp on p.id = pp.pedido_id
                    inner join $this->table_produtos pd on pd.id = pp.produto_id
                where usuario_id = :usuario_id
                order by p.id desc 
            ");

            $this->bind(':usuario_id', $usuario_id);

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
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar os pedidos do usuário no banco de dados.'];
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

    public function salvarPedidoJson(){
        $this->beginTransaction();

        $cadastrar = $this->cadastrar($_SESSION['usuario']->id);
        if ($cadastrar['sucesso']) {
            $carrinho = new Carrinho();

            $produtos = $carrinho->findAll();
            foreach ($produtos as $key => $produto) {
                $cadastrarPedidoProduto = $this->cadastrarPedidoProduto($cadastrar['pedido_id'], $produto['produto_id']);

                if (!$cadastrarPedidoProduto['sucesso']) {
                    $this->cancelTransaction();                    
                    return $this->responseJson($cadastrarPedidoProduto);
                }
            }

            $this->endTransaction();

            $carrinho->removerAll();
    
            return $this->responseJson([
                "sucesso" => TRUE, 
                "msg" => 'Pedido efetuado com sucesso.', "pedido_id" => $cadastrar['pedido_id']
            ]);
        } else {
            $this->cancelTransaction();
            return $this->responseJson($cadastrar);
        }
    }

    public function cadastrarPedidoProduto($pedido_id, $produto_id) {
        try {
            $this->setQuery("INSERT INTO $this->table_pedidos_produtos (
                produto_id,
                pedido_id
            ) VALUES (
                :produto_id,
                :pedido_id
            )");

            $this->bind(':produto_id', $produto_id);
            $this->bind(':pedido_id', $pedido_id);

            if ($this->execute()) {
                return ["sucesso" => TRUE, "msg" => 'Cadastro efetuado com sucesso.', "pedidos_produtos_id" => $this->lastInsertId()];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "<br><b>Nome do arquivo:</b> " . $e->getFile() . "<br><b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao cadastrar o pedido_produto no banco de dados.'];
            }
        }
    }

    public function cadastrar($usuario_id) {
        try {
            $query = "INSERT INTO $this->table (usuario_id, status) VALUES (:usuario_id, :status)";
            $this->setQuery($query);

            $this->bind(':usuario_id', $usuario_id, \PDO::PARAM_INT);
            $this->bind(':status', 1);

            if ($this->execute()) {
                return ["sucesso" => TRUE, "msg" => 'Cadastro efetuado com sucesso.', "pedido_id" => $this->lastInsertId()];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "<br><b>Nome do arquivo:</b> " . $e->getFile() . "<br><b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao cadastrar o pedido no banco de dados.'];
            }
        }
    }
}
