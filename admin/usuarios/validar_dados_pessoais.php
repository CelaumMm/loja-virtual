<?php

$erro = '';

// validação dos campos obrigatórios
if (empty($_POST['nome'])) {
    $erro .= "<li>Nome é obrigatório</li>";
}

if (empty($_POST['email'])) {
    $erro .= "<li>E-mail é obrigatório</li>";
}


if (empty($_POST['cpf'])) {
    $erro .= "<li>CPF é obrigatório</li>";
} else {
    if (!validarCpf($_POST['cpf'])) {
        $erro .= "<li>CPF inválido!</li>";
    }
}


if (!empty($_POST['senha'])) {
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