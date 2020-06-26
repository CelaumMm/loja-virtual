<?php

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'estrutura' . DIRECTORY_SEPARATOR . 'estrutura.php';

define("PROJETO", str_replace(DS, '', str_replace(ROOT_PATH, '', __DIR__)));

use App\Core\Template;

Template::loadAssets();

Template::setSession(FALSE);
Template::$sistema = "Loja Virtual";
Template::$idturma = [70];
Template::$nivel = 1;

Template::setMenu(TRUE);
Template::setBanner(FALSE);

//Template::$template = "loja";
Template::getHeader();
