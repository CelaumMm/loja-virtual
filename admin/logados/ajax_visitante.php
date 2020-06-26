<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'estrutura' . DIRECTORY_SEPARATOR . 'estrutura.php';

    header("Content-type:application/json;encoding=UTF-8'");

    $obj = new App\Model\UsuarioLogado();

    $count = 0;
    do {
        $usuarios = $obj->getAllVisitante();

        sleep(1);

        if (($count++) > 30){
            break;
        }
    } while (isset($_POST["usuarios"]) && $_POST["usuarios"] == $usuarios);

    print(json_encode(["usuarios" => $usuarios]));
}