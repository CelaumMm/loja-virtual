<?php

namespace App\Core;

use App\Core\Template;
use App\Model\Grupo;

class Auth {

    private $grupos;

    function __construct() {
        // Verifica se a sessao contem o usuario
        if (!isset($_SESSION["usuario"]) || empty($_SESSION["usuario"])) {

            $url = getUrlAtual();
            $redirect = $url['url'] . ($url['get'] ? '?' . $url['get'] : '');

            header("Location: " . Template::url() . "../" . env('PROJETO_USUARIO'). "/login/?loc=$redirect");
            exit;
        }

        $this->grupos = new Grupo();
    }

    function verificar() {
        // Verifica se Template::$idturma não é um array e transforma em array
        if (!is_array(Template::$idturma)) {
            if(isset(Template::$idturma)){
                Template::$idturma = [Template::$idturma];
            }
        }
        
        if (!isset(Template::$idturma) || empty(Template::$idturma[0]) || Template::$idturma[0] == 70) {
            return; // Acesso autorizado
        } else {
            
            // Verifica se o usuario pertence ao grupo administradores master que tem acesso total
            if(isAdminMaster()){
                return; // Acesso autorizado
            }
            
            foreach (Template::$idturma as $grupos_id) {
                $consulta = $this->grupos->getUsuarioFromGrupo($_SESSION['usuario']->id, $grupos_id);

                if (isset($consulta->grupos_id) && $consulta->niveis_id >= Template::$nivel) {
                    return; // Acesso autorizado
                }
            }
        }

        header("Location: " . Template::url() . env('PROJETO_HOME') . '/erros/403');
    }

}

?>