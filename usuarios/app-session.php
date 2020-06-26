<?php

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'estrutura' . DIRECTORY_SEPARATOR . 'estrutura.php';

define("PROJETO", str_replace(DS, '', str_replace(ROOT_PATH, '', __DIR__)));

use App\Core\Template;

/*Template::$assets = [
    'jquery' => FALSE,
    'bootstrap' => FALSE,
    'font-awesome' => FALSE,
    'jquery-ui' => FALSE,
    'jquery-maskedinput' => FALSE,
    'jquery-maskmoney' => FALSE,
    'bootstrap-dialog' => FALSE,
    'toastr' => FALSE,
    'owl-carousel' => FALSE,
    'bootstrap-select' => FALSE,
    'highcharts' => FALSE,
];*/

Template::loadAssets();

Template::setSession(TRUE);
Template::$sistema = "GETH - Usuários";
Template::$idturma = [70];
Template::$nivel = 1;

//Template::$template = "geth";
Template::getHeader();

$pasta_foto = env('UPLOAD_FOTO');
$pasta_upload = ESTRUTURA_PATH . '..' . $pasta_foto;