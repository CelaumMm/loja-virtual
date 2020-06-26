<?php

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'estrutura' . DIRECTORY_SEPARATOR . 'estrutura.php';

define("PROJETO", str_replace(DS, '', str_replace(ROOT_PATH, '', __DIR__)));

use App\Core\Template;

/*
  Template::$assets = [
  'jquery' => TRUE,
  'bootstrap' => TRUE,
  'font-awesome' => TRUE,
  'jquery-ui' => TRUE,
  'jquery-maskedinput' => FALSE,
  'jquery-maskmoney' => FALSE,
  'bootstrap-dialog' => TRUE,
  'toastr' => FALSE,
  'owl-carousel' => FALSE,
  'bootstrap-select' => TRUE,
  'highcharts' => FALSE,
  ];
 */

Template::loadAssets();

Template::setSession(true);
Template::$sistema = "Área restrita - GETH";
Template::$idturma = [1];
Template::$nivel = 1;

Template::setMenu(TRUE);
Template::setBanner(FALSE);

//Template::$template = "geth";
Template::getHeader();
