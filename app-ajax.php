<?php

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'estrutura' . DIRECTORY_SEPARATOR . 'estrutura.php';

define("PROJETO", str_replace(DS, '', str_replace(ROOT_PATH, '', __DIR__)));

use App\Core\Template;

Template::setSession(FALSE);
Template::$idturma = [70];
Template::$nivel = 1;
//Template::$template = "loja";
Template::getHeader('ajax.php');

$pasta_foto = env('UPLOAD_FOTO');
$pasta_upload = ESTRUTURA_PATH . '..' . $pasta_foto;
