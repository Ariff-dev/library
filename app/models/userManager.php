<?php
class UsuarioManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUserForId($id_usr)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_usr = :id");
        $stmt->bindParam(":id", $id_usr, PDO::PARAM_STR);  // Bind the parameter as a string
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            return new Usuario($data['id_usr'], $data['nombreusr'], $data['email']);
        }

        return null;
    }

    public function createUser($nombreusr, $email)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO usuarios (nombreusr, email) VALUES (:nombreusr, :email)");
            $stmt->bindParam(':nombreusr', $nombreusr);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al crear usuario: " . $e->getMessage();
            return false;
        }
    }

    public function updateUser($id_usr, $nombreusr, $email)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombreusr = :nombreusr, email = :email WHERE id_usr = :id");
            $stmt->bindParam(':nombreusr', $nombreusr);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id_usr, PDO::PARAM_STR);  // Bind the parameter as a string
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar usuario: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUser($id_usr)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id_usr = :id");
            $stmt->bindParam(':id', $id_usr, PDO::PARAM_STR);  // Bind the parameter as a string
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar usuario: " . $e->getMessage();
            return false;
        }
    }

    public function isEmailExist($email)
    {
        $stmt = $this->conn->prepare("SELECT id_usr FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();

        return $data ? true : false;
    }
}
