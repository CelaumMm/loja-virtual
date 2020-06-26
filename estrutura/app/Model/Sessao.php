<?php

namespace App\Model;

class Sessao extends Model implements \SessionHandlerInterface {

    private $table = 'sessions';

    public function maxLifeTime() {
        // '+1 year +1 month +1 day +1 hour +1 minute +1 second';
        return env('APP_SESSION', "+15 minute");
    }

    public function open($savePath, $sessionName) {
        if ($this->conn) {
            return true;
        }

        return false;
    }

    public function close() {
        if ($this->closeConnection()) {
            return true;
        }

        return false;
    }

    public function read($id) {
        try {
            $this->gc();

            $this->setQuery("SELECT * FROM $this->table WHERE id = :id");

            $this->bind(':id', $id);

            if ($this->execute()) {
                $row = $this->single();

                return $row['datas'] ?? '';
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function write($id, $data) {
        try {
            $nome = $_SESSION['usuario']->nome ?? NULL;
            $usuarios_id = $_SESSION['usuario']->id ?? NULL;

            // Data e hora para expirar a sessao
            $date = new \DateTime();
            $date->modify($this->maxLifeTime());
            $expires = $date->format('Y-m-d H:i:s');

            $this->setQuery("REPLACE INTO $this->table VALUES (:id, :expires, :datas, :usuarios_id, :nome, :ip)");

            $this->bind(':id', $id);
            $this->bind(':expires', $expires);
            $this->bind(':datas', $data);
            $this->bind(':usuarios_id', $usuarios_id);
            $this->bind(':nome', $nome);
            $this->bind(':ip', getIp());

            if ($this->execute()) {
                if(env('APP_SESSION_UNIQUE', false)){
                    if($usuarios_id){                 
                        $this->deleteDuplaSessao($id, $usuarios_id);
                    }
                }
                
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteDuplaSessao($id, $usuarios_id) {
        try {
            $this->setQuery("DELETE FROM $this->table WHERE id <> :id AND usuarios_id = :usuarios_id");

            $this->bind(':id', $id);
            $this->bind(':usuarios_id', $usuarios_id);

            if ($this->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function destroy($id) {
        try {
            $this->setQuery("DELETE FROM $this->table WHERE id = :id");

            $this->bind(':id', $id);

            if ($this->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Garbage Collection
     */
    public function gc($maxlifetime = null) {
        try {
            $date = new \DateTime();
            $old = $date->format('Y-m-d H:i:s');

            $this->setQuery("DELETE FROM $this->table WHERE expires < :old");

            $this->bind(':old', $old);

            if ($this->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

}

?>