<?php

require_once 'user.php';


class UsuarioManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUserForId($id_usuario)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
        $stmt->bindParam(":id", $id_usuario, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            return new Usuario($data['id_usuario'], $data['nombreusr'], $data['email']);
        }

        return null;
    }

    public function createUser($id_usuario, $nombreusr, $password_hash, $email)
    {
        try {
            // Generar un ID único basado en el timestamp actual

            $stmt = $this->conn->prepare(
                "INSERT INTO usuarios (id_usuario, nombreusr, password ,email) VALUES (:id_usuario, :nombreusr, :password , :email)"
            );
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':nombreusr', $nombreusr);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error al crear usuario: " . $e->getMessage();
            return false;
        }
    }


    public function updateUser($id_usuario, $nombreusr, $email)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombreusr = :nombreusr, email = :email WHERE id_usuario = :id");
            $stmt->bindParam(':nombreusr', $nombreusr);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id_usuario, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar usuario: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUser($id_usuario)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id_usuario = :id");
            $stmt->bindParam(':id', $id_usuario, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar usuario: " . $e->getMessage();
            return false;
        }
    }

    public function isEmailExist($email)
    {
        $stmt = $this->conn->prepare("SELECT id_usuario FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();

        return $data ? true : false;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            return new Usuario($data['id_usr'], $data['nombreusr'], $data['email']);
        }

        return null;
    }

    public function getPassword($email)
    {
        $stmt = $this->conn->prepare("SELECT password FROM usuarios WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();

        return $data ? $data['password'] : null;
    }
}
