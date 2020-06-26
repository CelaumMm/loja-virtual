<?php

use App\Core\Template;
use App\Model\UsuarioBanco;
use App\Model\UsuarioLdap;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuarioBanco = new UsuarioBanco();
    $ldap = new UsuarioLdap();

    switch ($_POST['acao']) {
        case 'Conectar':
                        
            $tipo = env('APP_TIPO_AUTH');

            switch ($tipo) {
                case 1:
                    $autenticacao = $usuarioBanco->login($_POST);                    
                    if ($autenticacao['sucesso']) {
                        header("Location: $location");
                        exit();
                    }

                    break;
                case 2:
                    $autenticacao = $ldap->login($_POST);                                        
                    if ($autenticacao['sucesso']) {
                        header("Location: $location");
                        exit();
                    }

                    break;
                case 3:                    
                    $autenticacao = $ldap->login($_POST);                                        
                    if ($autenticacao['sucesso']) {
                        header("Location: $location");
                        exit();
                    }

                    $autenticacao = $usuarioBanco->login($_POST);                    
                    if ($autenticacao['sucesso']) {
                        header("Location: $location");
                        exit();
                    }

                    break;
            }
            
            $redirect = Template::url() . PROJETO . '/login?loc=' . $location;
            echo "<script>alert_atencao_redirecionar('" . $autenticacao['msg'] . "', 4000, '" . $redirect . "');</script>";
            
            break;
        case 'Recuperar':

            break;
        default:
            exit();
    }
}
?>