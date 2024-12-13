<?php
class Usuario
{
    private $id_usr;
    private $nombreusr;
    private $email;

    public function __construct($id_usr, $nombreusr, $email)
    {
        $this->id_usr = $id_usr;
        $this->nombreusr = $nombreusr;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id_usr;
    }

    public function getNombre()
    {
        return $this->nombreusr;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
