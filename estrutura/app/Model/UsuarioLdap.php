<?php

namespace App\Model;

use App\Core\Ldap;
use App\Config\Config;
use App\Model\UsuarioBanco;
use App\Core\Template;

/**
 * Classe DAO para usuarios ldap
 *
 * @author - Marcelo Camargo
 */
class UsuarioLdap {

    public function login($dados) {

        $login = $dados['login'];
        $senha = $dados['senha'];

        if (isset($login) AND ! empty($login) AND isset($senha) AND ! empty($senha)) {
            if (!strpos($login, '@') === false) {
                $login = explode('@', $login);
                $login = $login[0];
            }

            $config = new Config();

            $dados_ldap = $config->ldap;
            $dados_ldap['usuario'] = $login;
            $dados_ldap['senha'] = $senha;

            $ldap = new Ldap($dados_ldap);

            if ($ldap->idConexao) {
                $atributos = ['pager', 'displayname', 'samaccountname', 'mail', 'dn', 'memberof'];

                $pesquisa = $ldap->consultarCustom('person', 'sAMAccountName', $login, $atributos);
                $ldap->desconectar();

                if ($pesquisa['count']) {

                    $pesquisa['senha'] = $senha;

                    return $this->setSession($pesquisa);
                }
            } else {
                // Verificando se o usuario está desativado                
                $ldap = new Ldap($config->ldap);

                if ($ldap->idConexao) {
                    $atributos = ['pager', 'displayname', 'samaccountname', 'mail', 'dn', 'memberof', 'useraccountcontrol'];

                    $desativado = $ldap->consultarCustom('person', 'sAMAccountName', $login, $atributos);
                    $ldap->desconectar();

                    if ($desativado[0]['useraccountcontrol'][0] == 66082) {

                        $usuarioBanco = new UsuarioBanco();

                        $desativar['email'] = $login . '@fm.usp.br';
                        $desativar['ativo'] = 0;

                        $usuarioBanco->ativarDesativarUsuario($desativar);
                        return ["sucesso" => FALSE, "msg" => '<li>Usuário desativado, entre em contato com o NTI.</li>'];
                    }
                }
            }
        }

        return ["sucesso" => FALSE, "msg" => '<li>E-mail e/ou Senha inválido(s)!</li>'];
    }

    public function setSession($dados) {
        if ($dados) {

            $usuario['senha'] = $dados['senha'];
            $usuario['ativo'] = 1;
            $usuario['data_cadastro'] = getDateTime();

            $usuario['cpf'] = $dados[0]['pager'][0];
            $usuario['nome'] = $dados[0]['displayname'][0];
            $usuario['login'] = $dados[0]['samaccountname'][0];
            $usuario['email'] = $dados[0]['mail'][0];
            $usuario['dn'] = $dados[0]['dn'];

            for ($i = 0; $i < $dados[0]['memberof']['count']; $i++) {
                $usuario['grupos'][] = $dados[0]['memberof'][$i];
            }

            $usuarioBanco = new UsuarioBanco();
            $consulta = $usuarioBanco->getByEmail($usuario['email']);

            if ($consulta) {

                $ativar['senha'] = $dados['senha'];
                $ativar['email'] = $consulta->email;
                $ativar['ativo'] = 1;

                $usuarioBanco->updateSenhaAtivo($ativar);
            } else {
                return $usuarioBanco->cadastrar($usuario);
            }

            //ADICIONAR USUARIO NA SESSAO            
            unset($usuario['senha']);
            unset($usuario['ativo']);
            unset($usuario['data_cadastro']);

            $_SESSION['usuario'] = (object) $usuario;

            return ["sucesso" => TRUE, "msg" => '<li>Usuário autenticado com sucesso!</li>'];
        }

        return ["sucesso" => FALSE, "msg" => '<li>E-mail e/ou Senha inválido(s)!</li>'];
    }

    public function logoff($redirect = TRUE) {
        session_unset();
        session_destroy();

        if ($redirect) {
            header("Location: " . Template::url());
        }
    }
}
