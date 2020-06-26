<?php

namespace App\Model;

use App\Model\Model;
use App\Core\Template;

/**
 * Classe DAO para a tabela de usuarios
 *
 * @author - Marcelo Camargo
 */
class UsuarioBanco extends Model {

    private $table = 'usuarios';
    private $table_endereco = 'endereco';
    private $table_recuperar_senha = 'recuperar_senha';

    public function getRecords($dados) {
        header("Content-type:application/json;encoding=UTF-8'");
        echo json_encode($this->getByFilter($dados));
    }

    public function getByFilter($dados) {
        $rp = isset($dados['rowCount']) ? $dados['rowCount'] : 10;

        if (isset($dados['current'])) {
            $page = $dados['current'];
        } else {
            $page = 1;
        }

        $start_from = ($page - 1) * $rp;

        // Inicializando as variaveis com vazio
        $sql = $sqlRecords = $sqlTotal = $where = '';


        // Filtrar pelo input busca
        if (!empty($dados['searchPhrase'])) {
            $where .= " WHERE ( ";
            $where .= " id='" . $dados['searchPhrase'] . "' ";
            $where .= " OR nome LIKE '%" . $dados['searchPhrase'] . "%' ";
            $where .= " OR email LIKE '%" . $dados['searchPhrase'] . "%' ";
            $where .= " OR data_cadastro LIKE '%" . dataHoraBanco($dados['searchPhrase']) . "%' ";

            $ativo = minuscula($dados['searchPhrase']);
            if ($ativo == "sim") {
                $where .= " OR ativo=1 ";
            }
            if ($ativo == "nao") {
                $where .= " OR ativo=0 ";
            }

            $where .= " )";
        }

        // Ordernar por
        if (!empty($dados['sort'])) {
            $where .= " ORDER By " . key($dados['sort']) . ' ' . current($dados['sort']) . " ";
        }

        // getting total number records without any search
        // Obtendo o numero total de registros sem nenhum filtro de busca
        $sql = "SELECT * FROM `$this->table` ";
        $sqlTotal .= $sql;
        $sqlRecords .= $sql;

        // Concatenar busca sql se existir valor
        if (isset($where) && $where != '') {
            $sqlTotal .= $where;
            $sqlRecords .= $where;
        }

        if ($rp != -1) {
            $sqlRecords .= " LIMIT " . $start_from . "," . $rp;
        }

        //$qtot = mysqli_query($this->conn, $sqlTotal) or die("Erro ao buscar dados do usuário");        
        $this->setQuery($sqlTotal);
        $qtot = $this->execute();

        $total = '';
        if ($qtot) {
            $total = count($this->resultSet());
        }

        /*
          $queryRecords = mysqli_query($this->conn, $sqlRecords) or die("Erro ao buscar dados do usuário");
          while ($row = mysqli_fetch_assoc($queryRecords)) {
          $data[] = $row;
          } */

        $this->setQuery($sqlRecords);
        $queryRecords = $this->execute();
        $data = '';
        if ($queryRecords) {
            $data = $this->resultSet();
        }


        $json_data = array(
            "current" => intval($dados['current']),
            "rowCount" => 10,
            "total" => intval($total),
            "rows" => $data, // total data array
        );

        return $json_data;
    }

    public function login($dados) {

        $login = $dados['login'];
        $senha = $dados['senha'];

        if (isset($login) AND ! empty($login) AND isset($senha) AND ! empty($senha)) {

            $consulta = $this->getByEmail($login);

            if (!empty($consulta['dados'])) {
                if ($consulta['dados']->ativo == 0) {
                    return ["sucesso" => FALSE, "msg" => 'Usuário desativado, entre em contato com os administradores.'];
                }
                /*
                  if ($consulta['obj']->ativo == -1) {
                  return ["sucesso" => FALSE, "msg" => 'Usuário bloqueado, entre em contato com os administradores.'];
                  }
                 */
                if ($this->verificarHash($dados['senha'], $consulta['dados']->senha)) {
                    return $this->setSession($consulta['dados']);
                }
            }
        }

        return ["sucesso" => FALSE, "msg" => 'E-mail e/ou Senha inválido(s)!'];
    }

    public function setSession($dados) {

        if ($dados) {
            $_SESSION['usuario'] = new \stdClass();

            $_SESSION['usuario']->id = $dados->id;
            $_SESSION['usuario']->cpf = $dados->cpf;
            $_SESSION['usuario']->nome = $dados->nome;
            $_SESSION['usuario']->email = $dados->email;

            return ["sucesso" => TRUE, "msg" => 'Usuário autenticado com sucesso!'];
        }

        return ["sucesso" => FALSE, "msg" => 'E-mail e/ou Senha inválido(s)!'];
    }

    public function logoff($redirect = TRUE) {
        session_unset();
        session_destroy();

        if ($redirect) {
            header("Location: " . Template::url());
        }
    }

    public function cadastrar($dados) {
        try {
            // verifica se já exite um e-mail cadastrado
            $consulta = $this->getByEmail($dados['email']);
            if (!empty($consulta['dados'])) {
                return ["sucesso" => FALSE, "msg" => 'E-mail já cadastrado.'];
            }

            $this->setQuery("INSERT INTO $this->table (
                nome,
                cpf,
                email,
                senha,
                telefone,
                celular,
                foto,
                data_cadastro,
                ativo
            ) VALUES (
                :nome, 
                :cpf,
                :email,
                :senha,
                :telefone,
                :celular,
                :foto,
                :data_cadastro,
                :ativo
            )");

            $this->bind(':nome', $dados['nome'] ?? '');
            $this->bind(':cpf', cpfSemMascara($dados['cpf']) ?? '');
            $this->bind(':email', $dados['email'] ?? '');
            $this->bind(':senha', $this->hash($dados['senha']) ?? '');
            $this->bind(':telefone', $dados['telefone'] ?? '');
            $this->bind(':celular', $dados['celular'] ?? '');
            $this->bind(':foto', $dados['foto'] ?? '');
            $this->bind(':data_cadastro', getDateTime());
            $this->bind(':ativo', 1);

            if ($this->execute()) {
                return ["sucesso" => TRUE, "msg" => 'Cadastro efetuado com sucesso.', "usuarios_id" => $this->lastInsertId()];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "<br><b>Nome do arquivo:</b> " . $e->getFile() . "<br><b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao cadastrar o usuário no banco de dados.'];
            }
        }
    }

    public function deleteUsuario($id) {
        try {
            if (isset($id) && !empty($id) && is_numeric($id)) {
                $this->setQuery("DELETE FROM $this->table WHERE id = :id");
                $this->bind(':id', $id);

                if ($this->execute()) {
                    return ["sucesso" => TRUE, "msg" => 'Usuário deletado com sucesso.'];
                }
            }

            return ["sucesso" => FALSE, "msg" => 'ID inválido do usuário.'];
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "<b>Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao tentar deletar o usuário.'];
            }
        }
    }

    public function updateUsuario(Array $dados) {
        try {
            // verifica se já exite um e-mail cadastrado
            $consulta = $this->getByEmail($dados['email']);
            if (!empty($consulta['dados'])) {
                
                if($dados['usuarios_id'] != $consulta['dados']->id){
                    return ["sucesso" => FALSE, "msg" => 'E-mail já está sendo utilizado.'];
                }
            }

            $this->setQuery("UPDATE $this->table SET 
                nome            = :nome,
                cpf             = :cpf,
                telefone        = :telefone,
                celular         = :celular,
                email           = :email,
                data_alteracao  = :data_alteracao
            WHERE id=:id");

            $this->bind(':nome', $dados['nome']);
            $this->bind(':cpf', cpfSemMascara($dados['cpf']));
            $this->bind(':telefone', $dados['telefone']);
            $this->bind(':celular', $dados['celular']);
            $this->bind(':email', $dados['email']);
            $this->bind(':data_alteracao', getDateTime());
            $this->bind(':id', $dados['usuarios_id']);

            if ($this->execute()) {
                return ["sucesso" => TRUE, "msg" => 'Usuário atualizado com sucesso.'];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "<b>Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao atualizar o usuário no banco de dados.'];
            }
        }
    }

    public function endereco($dados) {
        try {
            $this->setQuery("INSERT INTO $this->table_endereco (
                usuarios_id,
                cep, 
                lagradouro,
                numero,
                complemento,
                bairro,
                cidade,
                estado,
                pais,
                data_cadastro
            ) VALUES (
                :usuarios_id,
                :cep, 
                :lagradouro,
                :numero,
                :complemento,
                :bairro,
                :cidade,
                :estado,
                :pais,
                :data_cadastro
            )");

            $this->bind(':usuarios_id', $dados['usuarios_id']);
            $this->bind(':cep', $dados['cep'] ?? '');
            $this->bind(':lagradouro', $dados['lagradouro'] ?? '');
            $this->bind(':numero', $dados['numero'] ?? 0, \PDO::PARAM_INT);
            $this->bind(':complemento', $dados['complemento'] ?? '');
            $this->bind(':bairro', $dados['bairro'] ?? '');
            $this->bind(':cidade', $dados['cidade'] ?? '');
            $this->bind(':estado', $dados['estado'] ?? '');
            $this->bind(':pais', $dados['pais'] ?? '');
            $this->bind(':data_cadastro', getDateTime());

            if ($this->execute()) {
                return ["sucesso" => TRUE, "msg" => 'Endereço cadastro com sucesso.', "endereco_id" => $this->lastInsertId()];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "<b>Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao cadastrar o endereço no banco de dados.'];
            }
        }
    }

    public function updateEndereco(Array $dados) {

        try {
            // verifica se o usuario nao tem registro na tabela            
            $consulta = $this->getEndereco($dados['usuarios_id']);
            if (empty($consulta['dados'])) {
                $retorno = $this->endereco($dados);
                if ($retorno['sucesso']) {
                    return ["sucesso" => TRUE, "msg" => 'Endereço atualizado com sucesso.'];
                }
            }

            $this->setQuery("UPDATE $this->table_endereco SET 
                cep             = :cep,
                lagradouro      = :lagradouro,
                numero          = :numero,
                complemento     = :complemento,
                bairro          = :bairro,
                cidade          = :cidade,
                estado          = :estado,
                pais            = :pais,
                data_alteracao  = :data_alteracao
            WHERE usuarios_id   = :usuarios_id");

            $this->bind(':cep', $dados['cep'] ?? '');
            $this->bind(':lagradouro', $dados['lagradouro'] ?? '');
            $this->bind(':numero', $dados['numero'] ?? '', \PDO::PARAM_INT);
            $this->bind(':complemento', $dados['complemento'] ?? '');
            $this->bind(':bairro', $dados['bairro'] ?? '');
            $this->bind(':cidade', $dados['cidade'] ?? '');
            $this->bind(':estado', $dados['estado'] ?? '');
            $this->bind(':pais', $dados['pais'] ?? '');
            $this->bind(':data_alteracao', getDateTime());
            $this->bind(':usuarios_id', $dados['usuarios_id']);

            if ($this->execute()) {
                return ["sucesso" => TRUE, "msg" => 'Endereço atualizado com sucesso.'];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "<b>Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao atualizar o endereço no banco de dados.'];
            }
        }
    }

    public function recuperarSenha($email) {
        try {
            $consulta = $this->getByEmail($email);
            if (!empty($consulta['dados'])) {

                $this->desativarAllRecuperarSenha($consulta['dados']->id);

                $this->setQuery("INSERT INTO $this->table_recuperar_senha (
                    usuarios_id,
                    token,
                    data_cadastro,
                    ativo
                ) VALUES (
                    :usuarios_id,
                    :token,
                    :data_cadastro,
                    :ativo
                )");

                $this->bind(':usuarios_id', $consulta['dados']->id);
                $this->bind(':token', gerarToken());
                $this->bind(':data_cadastro', getDateTime());
                $this->bind(':ativo', 1);

                if ($this->execute()) {
                    return ["sucesso" => TRUE, "msg" => 'Adicionado recuperar senha com sucesso.', "recuperar_senha_id" => $this->lastInsertId()];
                }
            } else {
                return ["sucesso" => FALSE, "msg" => 'Nenhum resultado para a pesquisa.'];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "<b>Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao cadastrar recuperar senha no banco de dados.'];
            }
        }
    }

    public function getRecuperarSenha($id) {
        try {
            $this->setQuery("SELECT * FROM $this->table_recuperar_senha WHERE id = :id");

            $this->bind(':id', $id);

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "msg" => 'Foi enviado um link para recuperação de senha<br> no seu e-mail',
                    "dados" => $this->single(\PDO::FETCH_OBJ)
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</br> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar recuperar senha no banco de dados.'];
            }
        }
    }

    public function getRecuperarSenhaByToken($token) {
        try {
            $this->setQuery("SELECT * FROM $this->table_recuperar_senha WHERE token=:token AND ativo=1");

            $this->bind(':token', $token);

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "msg" => 'Consulta realizado com sucesso.',
                    "dados" => $this->single(\PDO::FETCH_OBJ)
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar recuperar senha no banco de dados.'];
            }
        }
    }

    public function desativarAllRecuperarSenha($usuarios_id) {
        $this->setQuery("UPDATE $this->table_recuperar_senha SET 
            data_alteracao=:data_alteracao,
            ativo=:ativo 
        WHERE usuarios_id=:usuarios_id");

        $this->bind(':data_alteracao', getDateTime());
        $this->bind(':ativo', 0);
        $this->bind(':usuarios_id', $usuarios_id);

        if ($this->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateRecuperarSenhaByToken($token, $ativo) {
        $this->setQuery("UPDATE $this->table_recuperar_senha SET 
            data_alteracao=:data_alteracao,
            ativo=:ativo
        WHERE token=:token");

        $this->bind(':data_alteracao', getDateTime());
        $this->bind(':ativo', $ativo);
        $this->bind(':token', $token);

        if ($this->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * Retorna a senha criptografada com 60 caracteres.
     * 
     * @param String $senha
     * 
     * @return String de 60 caracteres
     */
    public function hash($senha) {
        $senha = trim($senha);

        if (isset($senha) || !empty($senha)) {
            return password_hash($senha, PASSWORD_BCRYPT, ['cost' => 12]);
        }

        return FALSE;
    }

    /**
     * 
     * Valida a senha com o hash
     * 
     * @param type $senha
     * @return Boolean
     */
    public function verificarHash($senha, $hash) {
        $senha = trim($senha);
        $hash = trim($hash);

        if (isset($senha) AND ! empty($senha) AND isset($hash) AND ! empty($hash)) {
            if (password_verify($senha, $hash)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function getById($usuarios_id) {
        try {
            $this->setQuery("SELECT * FROM $this->table WHERE id=:id");

            $this->bind(':id', $usuarios_id);

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->single()
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o usuário no banco de dados.'];
            }
        }
    }

    public function getByEmail($email) {
        try {
            $this->setQuery("SELECT * FROM $this->table WHERE email = :email");

            $this->bind(':email', $email);

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->single(\PDO::FETCH_OBJ)
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o usuário no banco de dados.'];
            }
        }
    }

    public function getEndereco($usuarios_id) {
        try {
            $this->setQuery("SELECT * FROM $this->table_endereco WHERE usuarios_id = :usuarios_id");

            $this->bind(':usuarios_id', $usuarios_id);

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->single(\PDO::FETCH_OBJ)
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o endereço no banco de dados.'];
            }
        }
    }

    public function getByLogin($login) {
        try {
            $this->setQuery("SELECT * FROM $this->table WHERE login = :login");

            $this->bind(':login', $login);

            if ($this->execute()) {
                return [
                    "sucesso" => TRUE,
                    "dados" => $this->single(\PDO::FETCH_OBJ)
                ];
            }
        } catch (\PDOException $e) {
            if (env('APP_DEBUG')) {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<b>Mensagem de erro:</b> " . $e->getMessage() .
                    "Nome do arquivo:</b> " . $e->getFile() . " <b>Linha:</b> " . $e->getLine()
                ];
            } else {
                return ["sucesso" => FALSE, "msg" => 'Erro ao consultar o usuário no banco de dados.'];
            }
        }
    }

    public function updateSenhaAtivo($dados) {
        $this->setQuery("UPDATE $this->table SET 
            senha=:senha,
            ativo=:ativo 
        WHERE email=:email");

        $this->bind(':senha', $this->hash($dados['senha']));
        $this->bind(':ativo', $dados['ativo']);
        $this->bind(':email', $dados['email']);

        if ($this->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateSenha(Array $dados) {
        $this->setQuery("UPDATE $this->table SET 
            senha=:senha,           
            data_alteracao=:data_alteracao
        WHERE id=:id");

        $this->bind(':data_alteracao', getDateTime());
        $this->bind(':senha', $this->hash($dados['senha']));
        $this->bind(':id', $dados['usuarios_id']);

        if ($this->execute()) {
            $this->desativarAllRecuperarSenha($dados['usuarios_id']);

            return ["sucesso" => TRUE, "msg" => 'Senha alterada com sucesso.'];
        } else {
            return ["sucesso" => FALSE, "msg" => 'Erro ao tentar alterar a senha.'];
        }
    }

    public function updateFoto($dados) {
        $this->setQuery("UPDATE $this->table SET 
            foto=:foto
        WHERE id=:id");

        $this->bind(':foto', $dados['foto']);
        $this->bind(':id', $dados['usuarios_id']);

        if ($this->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function ativarDesativarUsuario($dados) {
        $this->setQuery("UPDATE $this->table SET ativo=:ativo WHERE email=:email");

        $this->bind(':ativo', $dados['ativo']);
        $this->bind(':email', $dados['email']);

        if ($this->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function ativarDesativarUsuarioById($dados) {
        $this->setQuery("UPDATE $this->table SET ativo=:ativo WHERE id=:id");

        $this->bind(':ativo', $dados['ativo']);
        $this->bind(':id', $dados['id']);

        if ($this->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
