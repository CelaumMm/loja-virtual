<?php

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'estrutura' . DIRECTORY_SEPARATOR . 'estrutura.php';

$config = new App\Config\Config();

$dados = '';
if (env('APP_ENV') == 'producao' || env('APP_ENV') == 'production') {
    $dados = $config->mysql;
} else {
    $dados = $config->mysql_local;
}

//dd($dados);

$mysqli = new mysqli($dados['host'], $dados['user'], $dados['pass'], '');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

echo '<p>Connection OK ' . $mysqli->host_info . '</p>';
echo '<p>Server ' . $mysqli->server_info . '</p>';

$mysqli->close();
