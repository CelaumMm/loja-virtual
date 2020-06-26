<?php

require_once './app-ajax.php';

use App\Model\Pedido;
use App\Model\Produto;
use App\Service\Carrinho;

$produto = new Produto();
$pedido = new Pedido();
$carrinho = new Carrinho();

$action = $_REQUEST['action'] ?? NULL;
switch ($action) {
    
    case 'find':
        $consulta = $produto->find($_REQUEST['usuarios_id']);

        if ($consulta['sucesso']) {
            header("Content-type:application/json;encoding=UTF-8'");
            echo json_encode($consulta['dados']);
        }

        break;

    case 'filter':
        $produto->filterJson($_REQUEST);

        break;
    case 'add-carrinho':
        $carrinho->cadastrarJson($_REQUEST);

        break;

    case 'alerar-quantidade-carrinho':
        $carrinho->alterarQtdJson($_REQUEST);

        break;

    case 'remover-carrinho':
        $carrinho->removerJson($_REQUEST);

        break;

    case 'cancelar-carrinho':
        $carrinho->removerAllJson();
        
        break;
    case 'salvar-pedido':
        $pedido->salvarPedidoJson();
        
        break;
   
    default:
        $lista = $produto->findAll();
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($lista);

        return;
}
?>
