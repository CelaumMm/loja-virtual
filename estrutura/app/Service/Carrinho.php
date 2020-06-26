<?php

namespace App\Service;

/**
 * Serviço de Carrinho de Compras
 *
 * @author - Marcelo Camargo
 */
class Carrinho {

    public function responseJson($data) {
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($data);
    }

    public function findAll() {
        return $_SESSION["carrinho"] ?? [];
    }

    public function cadastrarJson($dados) {
        $this->cadastrar($dados);

        return $this->responseJson([
            "sucesso" => TRUE,
            "dados" => [
                "msg" => 'Produto adicionado ao carrinho',
                "quantidade" => count($_SESSION["carrinho"])
            ]
        ]);
    }

    public function cadastrar($dados) {
        if(isset($_SESSION["carrinho"])) {  
            $is_available = 0;  
            foreach($_SESSION["carrinho"] as $keys => $values) {  
                if($_SESSION["carrinho"][$keys]['produto_id'] == $dados["produto_id"]){  
                    $is_available++;  
                    $_SESSION["carrinho"][$keys]['quantidade'] = $_SESSION["carrinho"][$keys]['quantidade'] + $dados["quantidade"];  
                }  
            }

            if($is_available < 1){  
                $item_array = [
                    'produto_id'    => $dados["produto_id"],  
                    'nome'          => $dados["nome"],  
                    'preco'         => $dados["preco"],  
                    'imagem'        => $dados["imagem"],  
                    'quantidade'    => $dados["quantidade"]  
                ];  
                $_SESSION["carrinho"][] = $item_array;  
            }  
        } else {  
            $item_array = [
                'produto_id'    => $dados["produto_id"],  
                'nome'          => $dados["nome"],  
                'preco'         => $dados["preco"],  
                'imagem'        => $dados["imagem"],  
                'quantidade'    => $dados["quantidade"]  
            ];  
            $_SESSION["carrinho"][] = $item_array;  
        }
    }

    public function removerJson($dados) {
        $this->remover($dados);

        return $this->responseJson([
            "sucesso" => TRUE,
            "msg" => 'Produto removido do carrinho',
            "redirect" => (count($_SESSION["carrinho"])) ? false : true
        ]);
    }

    public function remover($dados) {
        foreach($_SESSION["carrinho"] as $keys => $values){  
            if($values["produto_id"] == $dados["produto_id"]){  
                unset($_SESSION["carrinho"][$keys]);
            }  
        }
    }

    public function removerAll() {
        unset($_SESSION["carrinho"]);
    }

    public function removerAllJson() {
        $this->removerAll();

        return $this->responseJson([
            "sucesso" => TRUE,
            "msg" => 'Produtos removido do carrinho'
        ]);
    }

    public function alterarQtdJson($dados) {
        $this->alterarQtd($dados);
        
        return $this->responseJson([
            "sucesso" => TRUE,
            "msg" => 'Quantiodade do produto alterado no carrinho'
        ]); 
    }

    public function alterarQtd($dados) {
        foreach($_SESSION["carrinho"] as $keys => $values){  
            if($_SESSION["carrinho"][$keys]['produto_id'] == $dados["produto_id"]){  
                $_SESSION["carrinho"][$keys]['quantidade'] = $dados["quantidade"];  
            }  
        } 
    }
}