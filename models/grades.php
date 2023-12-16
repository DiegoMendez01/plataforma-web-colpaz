<?php

class Grades extends Connect
{
    public function agregarGrado($nombre, $descripcion)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "INSERT INTO grados (nombre, descripcion) VALUES (?, ?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $descripcion);
        $stmt->execute();
    }

    public function obtenerGrados()
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "SELECT * FROM grados";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerGradoPorId($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "SELECT * FROM grados WHERE id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarGrado($id, $nombre, $descripcion)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "UPDATE grados SET nombre = ?, descripcion = ? WHERE id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $descripcion);
        $stmt->bindValue(3, $id);
        $stmt->execute();
    }

    public function eliminarGrado($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "DELETE FROM grados WHERE id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}