<?php

require_once '../app.php';

use App\Model\UsuarioBanco;

$usuariobanco = new UsuarioBanco();
$usuariobanco->logoff();
?>