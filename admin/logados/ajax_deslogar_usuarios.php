<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'estrutura' . DIRECTORY_SEPARATOR . 'estrutura.php';

    session_set_save_handler(new App\Model\Sessao(), true);
    session_start();

    header("Content-type:application/json;encoding=UTF-8'");
    if (isset($_SESSION['usuario'])) {
        $usuarios_id = $_POST['usuarios_id'];

        $obj = new App\Model\UsuarioLogado();
        $usuarios = $obj->deslogarAllUsersMenosUser($usuarios_id);

        print( json_encode($usuarios));
    }
}