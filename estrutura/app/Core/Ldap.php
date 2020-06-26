<?php

namespace App\Core;

use \Exception as Exception;

class Ldap {

    protected $host;
    protected $porta;
    protected $dominio;
    protected $usuario;
    protected $senha;
    protected $ssl;
    protected $basedn;
    protected $filtro;
    protected $atributo;
    // atributos público
    public $idConexao;

    function __construct(Array $dados) {
        if (isset($dados) && !empty($dados)) {
            $this->conectar($dados);
        } else {
            throw new Exception('Informe os parametros necessários!');
        }
    }

    /**
     * Abre uma conexão com o servidor LDAP
     *
     * @return Object .
     */
    public function conectar($dados) {
        ldap_set_option($this->idConexao, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($this->idConexao, LDAP_OPT_PROTOCOL_VERSION, 3);

        $this->host = $dados['host'];
        $this->porta = $dados['porta'];
        $this->ssl = $dados['ssl'];
        $this->basedn = $dados['basedn'];
        $this->usuario = $dados['usuario'];
        $this->senha = $dados['senha'];
        $this->dominio = $dados['dominio'];

        if ($this->ssl) {
            $this->host = 'ldaps://' . $this->host;
        }

        $this->idConexao = @ldap_connect($this->host, $this->porta);

        $usuario_dominio = $this->usuario . '@' . $this->dominio;

        $login = @ldap_bind($this->idConexao, $usuario_dominio, $this->senha);

        if (!$login) {
            $this->idConexao = false;
        }

        return $this->retorno = $this->idConexao;
    }

    /**
     * Fecha a conexão com o servidor LDAP
     *
     * @return boolean
     */
    public function desconectar() {
        $closeCon = @ldap_close($this->idConexao);

        if ($closeCon) {
            return $this->retorno = true;
        } else {
            return $this->retorno = false;
        }
    }

    public function getResult($pesquisa) {
        return $this->retorno = @ldap_get_entries($this->idConexao, $pesquisa);
    }

    /**
     * Pesquisa no LDAP
     *
     * @param string $filtro É o filtro de pesquisa pode ser simples ou avançada
     * @param array $atributo É atributos de retorno da pesquisa, esta variável pode ser uma String ou um array;
     *
     * @return boolean Retorna o resultado da pesquisa ou FALSE em caso de erro.
     */
    public function consultar($filtro, $atributo = null) {
        if ($this->idConexao) {
            if (!isset($filtro) OR empty($filtro)) {
                return FALSE;
            }

            $this->filtro = $filtro;

            if (empty($atributo)) {
                $pesquisa = @ldap_search($this->idConexao, $this->basedn, $this->filtro) or die(false);
            } else {
                $this->atributo = $atributo;
                $pesquisa = @ldap_search($this->idConexao, $this->basedn, $this->filtro, $this->atributo) or die(false);
            }

            if ($pesquisa) {
                $result = $this->getResult($pesquisa);

                if ($result) {
                    $this->retorno = $result;
                } else {
                    $this->retorno = false;
                }
            } else {
                $this->retorno = false;
            }
        } else {
            $this->retorno = false;
        }

        return $this->retorno;
    }

    /**
     * Pesquisa customizada no LDAP
     *
     * @param string $categoria É a categoria de busca do objeto dentro do AD ex: groups(buscar por grupos), person(Pessoas), ou(Ou´s)
     * @param string $propriedade É a propriedade da categoria a ser pesquisada ex: para grupos pode ser name, para usuarios samAccountName e etc.
     * @param string $propriedadeValor É o valor a ser pesquisado (*) pesquisa tudo, ou podemos especificar o valor referente ao $propriedade como name a ser pesquisado ou o samAccountName.
     * @param array $atributos É atributos de retorno da pesquisa, esta variável pode ser uma String ou um array;
     *
     * @return boolean Retorna o resultado da pesquisa ou FALSE em caso de erro.
     */
    public function consultarCustom($categoria, $propriedade, $propriedadeValor, $atributos = null) {
        if (!empty($categoria) && !empty($propriedade) && !empty($propriedadeValor)) {
            $filtro = "(&(objectCategory=" . $categoria . ")(" . $propriedade . "=" . $propriedadeValor . "))";

            if (empty($atributos)) {
                $this->retorno = $this->consultar($filtro);
            } else {
                $this->retorno = $this->consultar($filtro, $atributos);
            }
        } else {
            $this->retorno = false;
        }

        return $this->retorno;
    }

    public function incluir($dn, $ldapRecord) {
        //ldap_set_option($this->idConexao, LDAP_OPT_REFERRALS, 0);

        if (isset($dn) && !empty($dn) && isset($ldapRecord) && !empty($ldapRecord)) {
            $result = ldap_add($this->idConexao, $dn, $ldapRecord);

            if ($result) {
                $this->retorno = true;
            } else {
                $this->retorno = false;
            }
        } else {
            $this->retorno = false;
        }

        return $this->retorno;
    }

    public function alterar($dn, $ldapRecord) {
        //ldap_set_option($this->idConexao, LDAP_OPT_PROTOCOL_VERSION, 3);
        //ldap_set_option($this->idConexao, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($this->idConexao, LDAP_OPT_SIZELIMIT, -1);

        if (isset($dn) && !empty($dn) && isset($ldapRecord) && !empty($ldapRecord)) {
            $result = ldap_modify($this->idConexao, $dn, $ldapRecord);
            if ($result) {
                $this->retorno = $result;
            } else {
                $this->retorno = false;
            }
        } else {
            $this->retorno = false;
        }

        return $this->retorno;
    }

    public function renomear($oldDn, $cn, $newParent, $delDn) {

        $executa = ldap_rename($this->idConexao, $oldDn, $cn, $newParent, $delDn);

        if ($executa) {
            $this->retorno = true;
        } else {
            $this->retorno = false;
        }

        return $this->retorno;
    }

    public function deletar($dn) {
        if (isset($dn) && !empty($dn)) {
            $executa = ldap_delete($this->idConexao, $dn);

            if ($executa) {
                $this->retorno = true;
            } else {
                $this->retorno = false;
            }
        } else {
            $this->retorno = false;
        }

        return $this->retorno;
    }

    public function mover() {
        if (func_num_args() == 5) {
            $oldDn = func_get_arg(0);
            $newDn = func_get_arg(1);
            $ldaprecord = func_get_arg(4);

            if (!empty($oldDn) && !empty($newDn)) {
                $deletaAntigo = $this->deletar($oldDn);

                if ($deletaAntigo) {
                    $insereNovo = $this->incluir($newDn, $ldaprecord);
                    if ($insereNovo) {
                        $this->retorno = true;
                    } else {
                        echo 'Nao inserido1';
                        $this->retorno = false;
                    }
                } else {
                    echo 'Nao inserido2';
                    $this->retorno = false;
                }
            } else {
                echo 'Nao inserido3';
                $this->retorno = false;
            }
        } else {
            echo 'Nao inserido4';
            $this->retorno = false;
        }

        return $this->retorno;
    }

}

?>