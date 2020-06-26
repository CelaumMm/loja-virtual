<?php

namespace App\Model;

use \PDO as PDO;
use \PDOException as PDOException;

class Grupo extends Model {

    private $table_grupos = "grupos";
    private $table_grupos_usuarios_niveis = "grupos_usuarios_niveis";
    private $table_usuarios = "usuarios";
    private $table_niveis = "niveis";

    /**
     * metodo utilizado para evitar sql injection
     * @param string $str
     * @return string
     */
    private static function scape_string(&$str) {
        $str = htmlspecialchars($str, ENT_QUOTES);
        return stripslashes($str);
    }

    /**
     * Retorna Grupo a partir do ID
     * 
     * @param int $id
     * @return array
     */
    public function getById($id) {
        try {
            if (!empty($id) && is_numeric($id)) {
                self::scape_string($id);
                $this->setQuery("SELECT * FROM $this->table_grupos WHERE id = :id");

                $this->bind(':id', $id);

                if ($this->execute()) {
                    return $this->single(PDO::FETCH_OBJ);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Retorna todos os grupos
     * 
     * @return array
     */
    public function getAll() {
        try {
            $this->setQuery("SELECT * FROM $this->table_grupos ORDER BY nome");

            if ($this->execute()) {
                return $this->resultSet(PDO::FETCH_OBJ);
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Retorna todos os grupos sem o email informado for administrador
     * 
     * @return array
     */
    public function getAllAdm($email) {
        try {
            if ($this->isAdm($email)) {

                $this->setQuery("SELECT 
                        $this->table_grupos.id, 
                        $this->table_grupos.nome,
                            
                        $this->table_niveis.id AS niveis_id,
                        $this->table_niveis.nivel 
                    FROM $this->table_grupos, $this->table_niveis
                    WHERE $this->table_niveis.id = 2 
                    ORDER BY $this->table_grupos.nome");

                if ($this->execute()) {
                    $lista = $this->resultSet(PDO::FETCH_OBJ);
                    if (count($lista)) {
                        return $lista;
                    }
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Pega todos os grupos em que o usuario pertence
     * 
     * @param string $email
     * 
     * @return array de grupos
     */
    public function getMyGrupos($email) {
        try {

            $usuario = $this->getInfo($email);
            if ($usuario) {
                $this->setQuery("SELECT 
                    $this->table_grupos.id,
                    $this->table_grupos.nome,

                    $this->table_grupos_usuarios_niveis.niveis_id,

                    $this->table_niveis.nivel

                FROM $this->table_grupos_usuarios_niveis JOIN $this->table_usuarios ON $this->table_grupos_usuarios_niveis.usuarios_id = $this->table_usuarios.id
                    JOIN $this->table_grupos ON $this->table_grupos_usuarios_niveis.grupos_id = $this->table_grupos.id 
                    JOIN $this->table_niveis ON $this->table_grupos_usuarios_niveis.niveis_id = $this->table_niveis.id
                WHERE $this->table_grupos_usuarios_niveis.usuarios_id = :usuarios_id
                ORDER BY $this->table_grupos.nome");

                $this->bind(':usuarios_id', $usuario->id);

                if ($this->execute()) {
                    return $this->resultSet(PDO::FETCH_OBJ);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Pega todos os grupos em que o usuario é administrador
     * 
     * @param string $email
     * 
     * @return array de grupos
     */
    public function getMyGruposAdm($email) {
        try {
            $usuario = $this->getInfo($email);
            if ($usuario) {
                $this->setQuery("SELECT 
                    $this->table_grupos.id,
                    $this->table_grupos.nome,

                    $this->table_grupos_usuarios_niveis.niveis_id,

                    $this->table_niveis.nivel
                FROM $this->table_grupos_usuarios_niveis JOIN $this->table_usuarios ON $this->table_grupos_usuarios_niveis.usuarios_id = $this->table_usuarios.id 
                    JOIN $this->table_grupos ON $this->table_grupos_usuarios_niveis.grupos_id = $this->table_grupos.id
                    JOIN $this->table_niveis ON $this->table_grupos_usuarios_niveis.niveis_id = $this->table_niveis.id
                WHERE $this->table_grupos_usuarios_niveis.usuarios_id = :usuarios_id AND $this->table_grupos_usuarios_niveis.niveis_id = 2
                ORDER BY $this->table_grupos.nome");

                $this->bind(':usuarios_id', $usuario->id);

                if ($this->execute()) {
                    return $this->resultSet(PDO::FETCH_OBJ);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Obtem usuarios do grupo
     *
     * @param int $grupos_id
     * 
     * @return array
     */
    public function getUsuariosFromGrupo($grupos_id) {
        try {
            if (!empty($grupos_id) && is_numeric($grupos_id)) {
                $this->setQuery("SELECT 
                    $this->table_usuarios.nome,

                    $this->table_grupos_usuarios_niveis.usuarios_id,
                    $this->table_grupos_usuarios_niveis.grupos_id,
                    $this->table_grupos_usuarios_niveis.niveis_id

                FROM $this->table_grupos_usuarios_niveis JOIN $this->table_usuarios ON $this->table_grupos_usuarios_niveis.usuarios_id = $this->table_usuarios.id
                WHERE $this->table_grupos_usuarios_niveis.grupos_id = :grupos_id
                ORDER BY $this->table_usuarios.nome");

                $this->bind(':grupos_id', $grupos_id);

                if ($this->execute()) {
                    return $this->resultSet(PDO::FETCH_OBJ);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Obtem somente os administradores do grupo
     *
     * @param int $grupos_id
     * 
     * @return array Com os usuarios administradores do grupo
     */
    public function getUsuariosAdmFromGrupo($grupos_id) {
        try {
            if (!empty($grupos_id) && is_numeric($grupos_id)) {
                $this->setQuery("SELECT 
                    $this->table_usuarios.nome,

                    $this->table_grupos_usuarios_niveis.usuarios_id,
                    $this->table_grupos_usuarios_niveis.grupos_id,
                    $this->table_grupos_usuarios_niveis.niveis_id

                FROM $this->table_grupos_usuarios_niveis JOIN $this->table_usuarios ON $this->table_grupos_usuarios_niveis.usuarios_id = $this->table_usuarios.id
                WHERE $this->table_grupos_usuarios_niveis.grupos_id = :grupos_id AND $this->table_grupos_usuarios_niveis.niveis_id = 2
                ORDER BY $this->table_usuarios.nome");

                $this->bind(':grupos_id', $grupos_id);

                if ($this->execute()) {
                    return $this->resultSet(PDO::FETCH_OBJ);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Obtem usuario do Grupo
     * 
     * @param string $email
     * @param int $grupos_id
     * 
     * @return Array
     */
    public function getUsuarioFromGrupo($usuarios_id, $grupos_id) {
        try {
            if (!empty($usuarios_id) && !empty($grupos_id)) {
                $this->setQuery("SELECT 
                        $this->table_grupos_usuarios_niveis.*,

                        $this->table_usuarios.nome,

                        $this->table_grupos.nome AS grupo
                    FROM $this->table_grupos_usuarios_niveis LEFT JOIN $this->table_grupos ON $this->table_grupos_usuarios_niveis.grupos_id = $this->table_grupos.id
                        LEFT JOIN $this->table_usuarios ON $this->table_grupos_usuarios_niveis.usuarios_id = $this->table_usuarios.id
                    WHERE $this->table_grupos_usuarios_niveis.usuarios_id = :usuarios_id AND $this->table_grupos.id = :grupos_id");

                $this->bind(':usuarios_id', $usuarios_id);
                $this->bind(':grupos_id', $grupos_id);

                if ($this->execute()) {
                    return $this->single(PDO::FETCH_OBJ);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Obtem usuario do Grupo
     * 
     * @param string $email
     * @param int $grupos_id
     * 
     * @return Array
     */
    public function getUsuarioFromGrupoByEmail($email, $grupos_id) {
        try {
            if (!empty($email)) {
                $usuario = $this->getInfo($email);
                if ($usuario) {
                    return $this->getUsuarioFromGrupo($usuario->id, $grupos_id);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Pega as informações do usuario com base no email
     * 
     * @param string $email
     * 
     * @return Object
     */
    public function getInfo($email) {
        try {
            if (!empty($email)) {
                self::scape_string($email);

                $this->setQuery("SELECT * FROM $this->table_usuarios 
                    WHERE email = :email");

                $this->bind(':email', $email);

                if ($this->execute()) {
                    return $this->single(PDO::FETCH_OBJ);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Obtem informações do usuario com base no cpf
     *
     * @param string $cpf
     *
     * @return Object.
     */
    public function getInfoByCpf($cpf) {
        try {
            if (!empty($cpf)) {
                $this->setQuery("SELECT * FROM $this->table_usuarios WHERE cpf = :cpf");

                $this->bind(':cpf', $cpf);

                if ($this->execute()) {
                    return $this->single(PDO::FETCH_OBJ);
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Insere um Novo Grupo
     *
     * @param Array $dados
     * 
     * @return int
     */
    public function insertGrupo($dados) {
        try {
            if (!empty($dados) && is_array($dados)) {
                $usuario = $this->getInfo($dados['email']);
                if ($usuario) {
                    self::scape_string($dados['nome']);

                    $data = getDateTime();

                    $this->setQuery("INSERT INTO $this->table_grupos
                        (nome, gdc, data_cadastro, usuarios_id)
                    VALUES (:nome, :gdc, :data_cadastro, :usuarios_id)");

                    $this->bind(':nome', $dados['nome']);
                    $this->bind(':gdc', 0);
                    $this->bind(':data_cadastro', $data);
                    $this->bind(':usuarios_id', $usuario->id);

                    if ($this->execute()) {
                        return $this->lastInsertId();
                    }
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Altera o grupo
     * 
     * @param Array $dados
     * 
     * @return Boolean
     */
    public function alterarGrupo($dados) {
        if (!empty($dados) && is_array($dados)) {
            self::scape_string($dados['nome']);

            $this->setQuery("UPDATE $this->table_grupos SET
                nome = :nome,
                gdc = :gdc
            WHERE id = :id");

            $this->bind(':nome', $dados['nome']);
            $this->bind(':gdc', $dados['gdc']);
            $this->bind(':id', $dados['id']);

            if ($this->execute()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Deleta o Grupo
     *
     * @param int $id
     * 
     * @return Boolean
     */
    public function deleteGrupo($id) {
        try {
            if (!empty($id) && is_numeric($id)) {
                $this->setQuery("DELETE FROM $this->table_grupos_usuarios_niveis WHERE grupos_id = :id");
                $this->bind(':id', $id);

                if ($this->execute()) {
                    $this->setQuery("DELETE FROM $this->table_grupos WHERE id = :id");
                    $this->bind(':id', $id);

                    return $this->execute();
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Altera o nivel do usuario no grupo
     * 
     * @param Array $dados
     * 
     * @return Boolean
     */
    public function alteraAtuacao($dados) {
        try {
            if (!empty($dados) && is_array($dados)) {
                $this->setQuery("UPDATE $this->table_grupos_usuarios_niveis
                SET niveis_id = :niveis_id
                WHERE usuarios_id = :usuarios_id AND grupos_id = :grupos_id");

                $this->bind(':niveis_id', $dados['niveis_id']);
                $this->bind(':usuarios_id', $dados['usuarios_id']);
                $this->bind(':grupos_id', $dados['grupos_id']);

                if ($this->execute()) {
                    return TRUE;
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Inserir usuario no grupo
     * 
     * @param Array dados
     * 
     * @return Boolean
     */
    public function insertOnGrupo($dados) {
        try {
            if (!empty($dados) && is_array($dados)) {
                if (!isset($dados['usuarios_id']) || empty($dados['usuarios_id'])) {
                    $usuario = $this->getInfo($dados['email']);
                    if (!$usuario) {
                        return FALSE;
                    }

                    $dados['usuarios_id'] = $usuario->id;
                }

                if ($this->pertence($dados['usuarios_id'], $dados['grupos_id'])) {
                    return -2;
                }

                $this->setQuery("INSERT INTO $this->table_grupos_usuarios_niveis (
                    usuarios_id, 
                    grupos_id, 
                    niveis_id
                )VALUES (
                    :usuarios_id, 
                    :grupos_id, 
                    :niveis_id
                )");

                $this->bind(':usuarios_id', $dados['usuarios_id']);
                $this->bind(':grupos_id', $dados['grupos_id']);
                $this->bind(':niveis_id', $dados['niveis_id']);

                if ($this->execute()) {
                    return TRUE;
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Exclui usuario do grupo
     * 
     * @param Array $dados
     * 
     * @return Boolean
     */
    public function deleteFromGrupo($dados) {
        try {
            if (!empty($dados) && is_array($dados)) {
                $this->setQuery("DELETE FROM $this->table_grupos_usuarios_niveis
                WHERE usuarios_id = :usuarios_id AND grupos_id = :grupos_id");

                $this->bind(':usuarios_id', $dados['usuarios_id']);
                $this->bind(':grupos_id', $dados['grupos_id']);

                if ($this->execute()) {
                    return TRUE;
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Procura o usuario pelo nome na tabela de usuarios
     * 
     * @param String $nome
     * 
     * @return array
     */
    public function procuraUsuarios($nome) {
        try {
            if (is_array($nome)) {
                return $this->procuraUsuarios2($nome);
            }

            self::scape_string($nome);

            $nome = str_replace(' ', '%', $nome);
            $nome = "%" . $nome . "%";

            $this->setQuery("SELECT * FROM $this->table_usuarios WHERE nome like :nome ORDER BY nome");

            $this->bind(':nome', $nome);

            if ($this->execute()) {
                return $this->resultSet(PDO::FETCH_OBJ);
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Procura o usuario pelo nome na tabela de usuarios
     * 
     * @param String $nomes
     * 
     * @return array
     */
    public function procuraUsuarios2($nomes) {
        try {
            if (!is_array($nomes)) {
                return $this->procuraUsuarios($nomes);
            }

            $like = "";
            foreach ($nomes as $v) {
                if (strlen($v) < 2) {
                    continue;
                }

                self::scape_string($v);
                if ($v != "") {
                    $v = str_replace(' ', '%', $v);
                    $like .= "nome like '%{$v}%' OR ";
                }
            }

            $like = substr($like, 0, strlen($like) - 4);

            $this->setQuery("SELECT * FROM $this->table_usuarios WHERE {$like} ORDER BY nome");

            if ($this->execute()) {
                return $this->resultSet(PDO::FETCH_OBJ);
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Verifica se o usuario pertence ao grupo administradores master
     *
     * @param string $email
     * 
     * @return boolean
     */
    public function isAdm($email) {
        try {
            if (!empty($email)) {
                $usuario = $this->getInfo($email);
                if ($usuario) {
                    $this->setQuery("SELECT *
                    FROM $this->table_grupos_usuarios_niveis
                    WHERE $this->table_grupos_usuarios_niveis.usuarios_id = :usuarios_id AND $this->table_grupos_usuarios_niveis.grupos_id = 1");

                    $this->bind(':usuarios_id', $usuario->id);

                    if ($this->execute()) {
                        if (count($this->resultSet(PDO::FETCH_OBJ))) {
                            return TRUE;
                        }
                    }
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Verifica se o usuario é administrador do grupo 
     * 
     * @param string $email
     * @param int $grupos_id
     * 
     * @return boolean
     */
    public function isAdmOfGroup($email, $grupos_id) {
        try {
            if ($this->isAdm($email)) {
                return TRUE;
            }

            $usuario = $this->getInfo($email);
            if ($usuario) {
                $this->setQuery("SELECT * FROM $this->table_grupos_usuarios_niveis 
                    WHERE usuarios_id = :usuarios_id AND grupos_id = :grupos_id AND niveis_id = 2");

                $this->bind(':usuarios_id', $usuario->id);
                $this->bind(':grupos_id', $grupos_id);

                if ($this->execute()) {
                    if (count($this->resultSet(PDO::FETCH_OBJ))) {
                        return TRUE;
                    }
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Verifica se o Usuario pertence ao Grupo
     *
     * @param int $usuarios_id
     * @param int $grupos_id
     * 
     * @return Boolean
     */
    public function pertence($email, $grupos_id) {
        try {
            if ($this->isAdm($email)) {
                return TRUE;
            }

            $usuario = $this->getInfo($email);
            if ($usuario) {
                $this->setQuery("SELECT * FROM $this->table_grupos_usuarios_niveis
                WHERE
                    $this->table_grupos_usuarios_niveis.usuarios_id = :usuarios_id
                        AND $this->table_grupos_usuarios_niveis.grupos_id = :grupos_id");

                $this->bind(':usuarios_id', $usuario->id);
                $this->bind(':grupos_id', $grupos_id);

                if ($this->execute()) {
                    if (count($this->resultSet(PDO::FETCH_OBJ))) {
                        return TRUE;
                    }
                }
            }

            return FALSE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     *
     * @param object $result
     * @return object
     */
    protected function stdToEntity($result) {
        return $result;
    }

}

?>