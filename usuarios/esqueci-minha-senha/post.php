<?php

require_once '../app.php';

use App\Model\UsuarioBanco;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $erro = '';

    $email = getPost('email');

    if (empty($email)) {
        $erro .= "<li>E-mail é obrigatório</li>";
    }

    if (!validarEmail($email)) {
        $erro .= "<li>E-mail inválido</li>";
    }

    // Exibindo alerta se algum campo obrigatorio nao foi preenchido
    if (!empty($erro)) {
        echo "<script>alert_atencao('$erro', 4000);</script>";
        return;
    }

    $usuarioBanco = new UsuarioBanco();

    $cadastrar = $usuarioBanco->recuperarSenha($email);

    if ($cadastrar['sucesso']) {
        $dados = $usuarioBanco->getRecuperarSenha($cadastrar['recuperar_senha_id']);
        if ($dados['sucesso']) {
            $de = 'email@exemplo.com.br';
            $assunto = 'Loja virtual - Recuperar senha';
            $token = $dados['dados']->token;

            $msn = "Recebemos um pedido de recuperação de senha!<br/>
                Para continuar com sua recuperação de senha, por favor clique no link abaixo.<br/><br/>";

            $msn .= "<a href=" . App\Core\Template::url() . PROJETO . "/recuperar-senha?token=$token>Recuperar senha</a>";

            $msn .= "
                <br/><br/>
                Se você não solicitou este pedido em nosso site, por favor ignore este email!<br/>
                Atenciosamente <strong>Loja Virtual</strong><br/>
                <br/>    
                Atenção: Este token tem validade de 48 horas.<br/>
                <br/>
                Enviado em: " . date('d/m/Y H:i');

            $headers = "From: $de\n";
            $headers .= "Content-Type: text/html; charset=\"utf-8\"\n\n";

            mail($email, $assunto, $msn, $headers);
        }
    }

    $redirect = App\Core\Template::url() . PROJETO . '/login';
    echo '<script>alert_sucesso_redirecionar("Enviaremos um link para recuperação de senha<br> caso o e-mail informado esteja cadastrado.", 5000, "' . $redirect . '");</script>';
    return;
}