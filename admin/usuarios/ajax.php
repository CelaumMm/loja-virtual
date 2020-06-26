<?php

require_once '../topo-ajax.php';

use App\Model\UsuarioBanco;

$usuarioBanco = new UsuarioBanco();

$action = $_REQUEST['action'] ?? NULL;
switch ($action) {

    case 'get':
        $consulta = $usuarioBanco->getById($_REQUEST['usuarios_id']);

        if ($consulta['sucesso']) {
            header("Content-type:application/json;encoding=UTF-8'");
            echo json_encode($consulta['dados']);
        }

        break;
    case 'add':
        //$usuarioBanco->insert($_REQUEST);
        break;

    case 'edit':
        // Validação dos campos obrigatorios
        $validar_campos = require_once './validar_dados_pessoais.php';
        if (!$validar_campos['sucesso']) {
            header("Content-type:application/json;encoding=UTF-8'");
            echo json_encode($validar_campos);

            break;
        }

        $edit = $usuarioBanco->updateUsuario($_REQUEST);

        if ($edit['sucesso']) {

            // Se for o mesmo usuario da sessao atualiza a sessao
            if ($_SESSION['usuario']->id == $_REQUEST['usuarios_id']) {
                
                $_SESSION['usuario']->cpf = cpfSemMascara($_REQUEST['cpf']);
                $_SESSION['usuario']->nome = $_REQUEST['nome'];
                $_SESSION['usuario']->email = $_REQUEST['email'];
            }

            if (!empty($_REQUEST['senha'])) {
                $senha = $usuarioBanco->updateSenha($_REQUEST);

                if (!$senha['sucesso']) {
                    header("Content-type:application/json;encoding=UTF-8'");
                    echo json_encode($senha);
                }
            }
        }

        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($edit);

        break;
    case 'delete':

        $delete = $usuarioBanco->deleteUsuario($_REQUEST['usuarios_id']);
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($delete);

        break;
    case 'active':
        
        $_REQUEST['id'] = $_REQUEST['usuarios_id'];
        $_REQUEST['ativo'] = 1;

        $block = $usuarioBanco->ativarDesativarUsuarioById($_REQUEST);
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($block);

        break;
    case 'block':
        
        $_REQUEST['id'] = $_REQUEST['usuarios_id'];
        $_REQUEST['ativo'] = 0;

        $block = $usuarioBanco->ativarDesativarUsuarioById($_REQUEST);
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($block);

        break;
    default:

        $lista = $usuarioBanco->getByFilter($_REQUEST);
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($lista);

        return;
}
?>
