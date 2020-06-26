<?php

require_once '../app.php';

use App\Core\Template;
use App\Model\UsuarioBanco;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $erro = '';
    // validação dos campos obrigatórios
    if (empty($_POST['nome'])) {
        $erro .= "<li>Nome é obrigatório</li>";
    }

    if (empty($_POST['cpf'])) {
        $erro .= "<li>CPF é obrigatório</li>";
    } else {
        if (!validarCpf($_POST['cpf'])) {
            $erro .= "<li>CPF inválido!</li>";
        }
    }

    if (empty($_POST['email'])) {
        $erro .= "<li>E-mail é obrigatório</li>";
    }

    if (!validarEmail($_POST['email'])) {
        $erro .= "<li>E-mail inválido</li>";
    }

    if (empty($_POST['senha'])) {
        $erro .= "<li>Senha é obrigatório</li>";
    }

    if (empty($_POST['csenha'])) {
        $erro .= "<li>confirmar senha é obrigatório</li>";
    }

    if ($_POST['senha'] != $_POST['csenha']) {
        $erro .= "<li>As senhas informadas estão diferentes</li>";
    }

    if (empty($erro)) {
        $tipo = env('APP_TIPO_AUTH');
        switch ($tipo) {
            case 1:
                $usuarioBanco = new UsuarioBanco();

                $usuarioBanco->beginTransaction();

                $cadastrar = $usuarioBanco->cadastrar($_POST);
                if ($cadastrar['sucesso']) {

                    $_POST['usuarios_id'] = $cadastrar['usuarios_id'];

                    $endereco = $usuarioBanco->endereco($_POST);
                    if (!$endereco['sucesso']) {
                        $usuarioBanco->cancelTransaction();
                        
                        $redirect = Template::url() . PROJETO . '/cadastrar';
                        echo '<script>alert_erro_redirecionar("' . $endereco['msg'] . '", 3000, "' . $redirect . '");</script>';
                        return;
                    }

                    // INICIO - Upload da foto do usuario
                    //-----------------------------------
                    if (isset($_FILES['foto']['name']) && !empty($_FILES['foto']['name'])) {
                        $nome = $_POST['usuarios_id'];
                        $upload = fotoUpload($nome, $pasta_upload);

                        if (!$upload['sucesso']) {
                            $usuarioBanco->cancelTransaction();
                            
                            $redirect = Template::url() . PROJETO . '/cadastrar';
                            echo '<script>alert_erro_redirecionar("' . $upload['msg'] . '", 3000, "' . $redirect . '");</script>';
                            return;
                        }

                        $_POST['foto'] = $pasta_foto . $nome . '.jpg';
                        $usuarioBanco->updateFoto($_POST);
                    }
                    // FIM - Upload da foto do usuario
                    //--------------------------------

                    $usuarioBanco->endTransaction();

                    $redirect = Template::url() . PROJETO . '/login';
                    echo '<script>alert_sucesso_redirecionar("' . $cadastrar['msg'] . '", 3000, "' . $redirect . '");</script>';
                    return;
                } else {
                    $usuarioBanco->cancelTransaction();
                    
                    $redirect = Template::url() . PROJETO . '/cadastrar';
                    echo '<script>alert_erro_redirecionar("' . $cadastrar['msg'] . '", 3000, "' . $redirect . '");</script>';
                    return;
                }

                break;
        }
    } else {
        $redirect = Template::url() . PROJETO . '/cadastrar';
        echo '<script>alert_erro_redirecionar("' . $erro . '", 4000,"' + $redirect + '");</script>';
    }
}
?>