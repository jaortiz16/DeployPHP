<?php
class Paciente
{
    private $id;
    private $nombre;
    private $edad;
    private $genero;

    private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}
		

    public function getId()
    {
        return $this->id;
    }

    public function getGenero()
    {
        return $this->genero;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getEdad()
    {
        return $this->edad;
    }
    public function getPacienteById($pacienteID)
    {
        $query = "SELECT * FROM Pacientes WHERE PacienteID=$pacienteID";
        $result = $this->con->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $this->id = $row['PacienteID'];
            $this->nombre = $row['Nombre'];
            $this->edad = $row['Edad'];
            $this->genero = $row['Genero'];
        }
    }

    public function getAllPacientes()
    {
        $query = "SELECT * FROM Pacientes";
        $result = $this->con->query($query);

        $pacientes = [];
        while ($row = $result->fetch_assoc()) {
            $pacientes[] = $row;
        }

        return $pacientes;
    }

    public function insertPaciente($nombre, $edad, $genero)
    {
        $query = "INSERT INTO Pacientes (Nombre, Edad, Genero) VALUES ('$nombre', $edad, '$genero')";
        $this->con->query($query);
    }

    public function updatePaciente($id, $nombre, $edad, $genero)
    {
        $query = "UPDATE Pacientes SET Nombre='$nombre', Edad=$edad, Genero='$genero' WHERE PacienteID=$id";
        $this->con->query($query);
    }

    public function deletePaciente($id)
    {
        $query = "DELETE FROM Pacientes WHERE PacienteID=$id";
        $this->con->query($query);
    }
}