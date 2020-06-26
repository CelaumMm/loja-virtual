<?php

require_once '../app-session.php';

use App\Core\Template;
use App\Model\UsuarioBanco;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuarioBanco = new UsuarioBanco();

    $_POST['usuarios_id'] = $_SESSION['usuario']->id;

    switch ($_POST['submit']) {
        case 'form-dados-pessoais':

            // validação dos campos obrigatórios
            $erro = '';
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
                            $erro .= '<li>Usuário desativado, entre em contato com os administradores.</li>';
                        }

                        $old_senha_valida = $usuarioBanco->verificarHash($_POST['osenha'], $consulta['dados']['senha']);
                        if (!$old_senha_valida) {
                            $erro .= "<li>A senha atual está incorreta para alteração de e-mail.</li>";
                        }
                    } else {
                        $erro .= '<li>Usuário não encontrado.</li>';
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
                            $erro .= '<li>Usuário desativado, entre em contato com os administradores.</li>';
                        }

                        $old_senha_valida = $usuarioBanco->verificarHash($_POST['osenha'], $consulta['dados']['senha']);
                        if (!$old_senha_valida) {
                            $erro .= "<li>A senha atual está incorreta para alterar a senha.</li>";
                        }
                    } else {
                        $erro .= '<li>Usuário não encontrado.</li>';
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
                $atualizar = $usuarioBanco->updateUsuario($_POST);
                if ($atualizar['sucesso']) {

                    // Se for o mesmo usuario da sessao atualiza a sessao
                    //-----------------------------------
                    $_SESSION['usuario']->cpf = cpfSemMascara($_POST['cpf']);
                    $_SESSION['usuario']->nome = $_POST['nome'];
                    $_SESSION['usuario']->email = $_POST['email'];

                    // Upload da foto do usuario
                    //-----------------------------------
                    if (!empty($_FILES['foto']['name'])) {
                        $nome = $_POST['usuarios_id'];
                        $upload = fotoUpload($nome, $pasta_upload);

                        if (!$upload['sucesso']) {
                            $redirect = Template::url() . PROJETO . '/meu-perfil';
                            echo '<script>alert_erro_redirecionar("' . $upload['msg'] . '", 3000, "' . $redirect . '");</script>';
                            return;
                        }

                        $_POST['foto'] = $pasta_foto . $nome . '.jpg';
                        $usuarioBanco->updateFoto($_POST);
                    }

                    // Atualizar senha do usuario
                    //--------------------------------
                    if (!empty($_POST['senha'])) {
                        $usuarioBanco->updateSenha($_POST);
                    }

                    $redirect = Template::url() . PROJETO . '/meu-perfil';
                    echo '<script>alert_sucesso_redirecionar("' . $atualizar['msg'] . '", 3000, "' . $redirect . '");</script>';
                    return;
                } else {
                    $redirect = Template::url() . PROJETO . '/meu-perfil';
                    echo '<script>alert_erro_redirecionar("' . $atualizar['msg'] . '", 3000, "' . $redirect . '");</script>';
                    return;
                }
            } else {
                $redirect = Template::url() . PROJETO . '/meu-perfil';
                echo '<script>alert_atencao_redirecionar("' . $erro . '", 3000, "' . $redirect . '");</script>';
                return;
            }

            break;
        case 'form-endereco':

            $endereco = $usuarioBanco->updateEndereco($_POST);
            if ($endereco['sucesso']) {

                $redirect = Template::url() . PROJETO . '/meu-perfil';
                echo '<script>alert_sucesso_redirecionar("' . $endereco['msg'] . '", 4000, "' . $redirect . '");</script>';
                return;
            } else {
                echo '<script>alert_erro("' . $endereco['msg'] . '");</script>';
                return;
            }

            break;
    }
}
?>