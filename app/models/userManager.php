<?php
class UsuarioManager
{
    private  $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUserForId($id_usr)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_usr= :id");
        $stmt->bindParam(":id", $id_usr);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            return new Usuario($data['id_usuario'], $data['nombreusr'], $data['email']);
        }

        return null;
    }
}
