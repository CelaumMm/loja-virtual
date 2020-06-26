<?php

ob_start();

header('Content-Type: text/html; charset=utf-8');

set_time_limit(0);

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

// Verifica se o autoload do Composer está configurado
$composer = __DIR__ . '/vendor/autoload.php';
if (!file_exists($composer)) {
    die('<b>Execute o comando:</b> composer install<br>');
}
require $composer;

// Verifica se o node está instalado
$node = __DIR__ . '/node_modules';
if (!is_dir($node)) {
    die('<b>Execute o comando:</b> npm install<br>');
}

// Verifica se o arquivo .env existe
$env = __DIR__ . '/.env';
if (!file_exists($env)) {
    die('<b>Arquivo .env não encontrado:</b> execute: cp .env-example .env');
}

// Verificar a versão do PHP
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    die('Sua versão do PHP: ' . PHP_VERSION . ' atualize para a versão: 5.4.0 ou superior.<br>');
}

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

ini_set('display_errors', env('APP_DEBUG', 1));

// Removendo o WWW. da URL
$url = getUrlAtual();
if (!empty($url['get'])) {
    $url = $url['url'] . '?' . $url['get'];
} else {
    $url = $url['url'];
}

$encontrar = '/' . 'www.' . '/';
if (preg_match($encontrar, $url)) {
    $url = str_replace('www.', '', $url);
    header("Location: $url");
    exit;
}

// Se no .env estiver true, coloca https na url
if (env('APP_HTTPS')) {    
    $url = str_replace('http://', '', $url);
    $url = str_replace('https://', '', $url);    
    
    if (!$_SERVER['HTTPS']) {
        $url = 'https://' . $url;
    }
}

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
define("ESTRUTURA", 'estrutura');
define("ESTRUTURA_PATH", __DIR__);
define('URI', $_SERVER['REQUEST_URI']);
