<?php

use App\Core\Template;
use App\Core\Tools;
use App\Model\Sessao;
use App\Core\Auth;

// Iniciando a sessao
session_set_save_handler(new Sessao(), true);
session_start();

global $session;
$session = Tools::associateToObject($_SESSION);

global $post;
$post = Tools::associateToObject($_POST);

global $get;
$get = Tools::associateToObject($_GET);

// Verificando o acesso se a sessao for verdadeiro
if (Template::getSession()) {
    $auth = new Auth();
    $auth->verificar();
}