<?php

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

if ($_POST['email'] != $_SESSION['usuario']->email) {
    if (empty($_POST['osenha'])) {
        $erro .= "<li>A senha atual é obrigatória para alterar o e-mail</li>";
    } else {
        $consulta = $usuarioBanco->getById($_SESSION['usuario']->id);

        if (!empty($consulta['dados'])) {
            if ($consulta['dados']['ativo'] == 0) {
                return ["sucesso" => FALSE, "msg" => '<li>Usuário desativado, entre em contato com os administradores.</li>'];
            }

            $old_senha_valida = $usuarioBanco->verificarHash($_POST['osenha'], $consulta['dados']['senha']);
            if (!$old_senha_valida) {
                $erro .= "<li>A senha atual está incorreta para alteração de e-mail.</li>";
            }
        } else {
            return ["sucesso" => FALSE, "msg" => '<li>Usuário não encontrado.</li>'];
        }
    }
}

if (!empty($_POST['senha'])) {
    if (empty($_POST['osenha'])) {
        $erro .= "<li>A senha atual é obrigatória</li>";
    } else {

        $consulta = $usuarioBanco->getById($_SESSION['usuario']->id);

        if (!empty($consulta['dados'])) {
            if ($consulta['dados']['ativo'] == 0) {
                return ["sucesso" => FALSE, "msg" => '<li>Usuário desativado, entre em contato com os administradores.</li>'];
            }

            $old_senha_valida = $usuarioBanco->verificarHash($_POST['osenha'], $consulta['dados']['senha']);
            if (!$old_senha_valida) {
                $erro .= "<li>A senha atual está incorreta para alterar a senha.</li>";
            }
        } else {
            return ["sucesso" => FALSE, "msg" => '<li>Usuário não encontrado.</li>'];
        }
    }

    if (empty($_POST['senha'])) {
        $erro .= "<li>Nova senha é obrigatória</li>";
    }

    if (empty($_POST['csenha'])) {
        $erro .= "<li>confirmar senha é obrigatório</li>";
    }

    if ($_POST['senha'] != $_POST['csenha']) {
        $erro .= "<li>As senhas informadas estão diferentes</li>";
    }
}

if (empty($erro)) {
    return ["sucesso" => TRUE];
} else {
    return ["sucesso" => FALSE, "msg" => $erro];
}