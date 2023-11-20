<?php
class Medico
{
    private $id;
    private $nombre;
    private $especialidad;

    private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}
		

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    public function getAllMedicos()
    {
        $query = "SELECT * FROM Medicos";
        $result = $this->con->query($query);

        $medicos = [];
        while ($row = $result->fetch_assoc()) {
            $medicos[] = $row;
        }

        return $medicos;
    }

    public function insertMedico($nombre, $especialidad)
    {
        $query = "INSERT INTO Medicos (Nombre, Especialidad) VALUES ('$nombre', '$especialidad')";
        $this->con->query($query);
    }

    public function updateMedico($id, $nombre, $especialidad)
    {
        $query = "UPDATE Medicos SET Nombre='$nombre', Especialidad='$especialidad' WHERE MedicoID=$id";
        $this->con->query($query);
    }

    public function deleteMedico($id)
    {
        $query = "DELETE FROM Medicos WHERE MedicoID=$id";
        $this->con->query($query);
    }
    public function getMedicoById($medicoID)
    {
        $sql = "SELECT * FROM Medicos WHERE MedicoID = '$medicoID'";
        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->id = $row['MedicoID'];
            $this->nombre = $row['Nombre'];
            $this->especialidad = $row['Especialidad'];
            return true;
        } else {
            return false;
        }
    }


}
