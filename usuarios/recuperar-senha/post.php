<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $erro = '';

    $senha = getPost('senha');
    $csenha = getPost('csenha');

    if (empty($senha)) {
        $erro .= "<li>Senha é obrigatório</li>";
    }

    if (empty($csenha)) {
        $erro .= "<li>confirmar senha é obrigatório</li>";
    }

    if ($senha != $csenha) {
        $erro .= "<li>As senhas informadas estão diferentes</li>";
    }

    if (empty($token)) {
        $erro .= "<li>Token é obrigatório</li>";
    }

    // Exibindo alerta se algum campo obrigatorio nao foi preenchido
    if (!empty($erro)) {
        echo "<script>alert_atencao('$erro', 4000);</script>";
        return;
    } else {
        $consulta = $usuarioBanco->getRecuperarSenhaByToken($token);

        if (!empty($consulta['dados'])) {
            $usuarioBanco->updateRecuperarSenhaByToken($token, 0);

            $_POST['usuarios_id'] = $consulta['dados']->usuarios_id;
            $update = $usuarioBanco->updateSenha($_POST);

            if ($update['sucesso']) {
                $redirect = App\Core\Template::url() . PROJETO . '/login';
                echo '<script>alert_sucesso_redirecionar("' . $update['msg'] . '", 10000, "' . $redirect . '");</script>';
                exit;
            }
        }
    }

//    $usuarioBanco->beginTransaction();
//    $usuarioBanco->endTransaction();
}