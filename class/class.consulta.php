<?php
class Consulta
{
    private $id;
    private $paciente;
    private $medico;
    private $fechaConsulta;
    private $diagnostico;
    private $foto;
    private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}
		

    public function getId()
    {
        return $this->id;
    }

    public function getPaciente()
    {
        return $this->paciente;
    }

    public function getMedico()
    {
        return $this->medico;
    }

    public function getFechaConsulta()
    {
        return $this->fechaConsulta;
    }

    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function insertConsulta($pacienteID, $medicoID, $fechaConsulta, $diagnostico, $foto)
    {
        $sql = "INSERT INTO Consultas (PacienteID, MedicoID, FechaConsulta, Diagnostico, Foto)
                VALUES ('$pacienteID', '$medicoID', '$fechaConsulta', '$diagnostico', '$foto')";

        $result = $this->con->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    
    public function getConsultaById($consultaID)
    {
        $sql = "SELECT * FROM Consultas WHERE ConsultaID = '$consultaID'";
        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->id = $row['ConsultaID'];
            $this->paciente = $row['PacienteID'];
            $this->medico = $row['MedicoID'];
            $this->fechaConsulta = $row['FechaConsulta'];
            $this->diagnostico = $row['Diagnostico'];
            $this->foto = $row['Foto'];
            return true;
        } else {
            return false;
        }
    }
    public function updateConsulta($consultaID, $pacienteID, $medicoID, $fechaConsulta, $diagnostico, $foto)
    {
        $sql = "UPDATE Consultas 
                SET PacienteID = '$pacienteID', MedicoID = '$medicoID', 
                    FechaConsulta = '$fechaConsulta', Diagnostico = '$diagnostico', Foto = '$foto'
                WHERE ConsultaID = '$consultaID'";

        $result = $this->con->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteConsulta($consultaID)
    {   
        // Eliminar recetas relacionadas

        $sql = "DELETE FROM Consultas WHERE ConsultaID = '$consultaID'";
        $result = $this->con->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function getAllConsultas()
    {
        $consultas = array();

        $sql = "SELECT c.ConsultaID, p.Nombre as NombrePaciente, m.Nombre as NombreMedico, c.FechaConsulta, c.Diagnostico, c.Foto
                FROM Consultas c
                JOIN Pacientes p ON c.PacienteID = p.PacienteID
                JOIN Medicos m ON c.MedicoID = m.MedicoID";

        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $consultas[] = $row;
            }
        }

        return $consultas;
    }
    public function getNombresPacientes()
    {
        $nombresPacientes = array();

        $sql = "SELECT PacienteID, Nombre FROM Pacientes";
        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombresPacientes[] = $row;
            }
        }

        return $nombresPacientes;
    }

    public function getNombresMedicos()
{
    $nombresMedicos = array();

    $sql = "SELECT MedicoID, Nombre, Especialidad FROM Medicos";
    $result = $this->con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombresMedicos[] = $row;
        }
    }

    return $nombresMedicos;
}

    
public function getGeneroPaciente($pacienteID)
{
    $sql = "SELECT Genero FROM Pacientes WHERE PacienteID = '$pacienteID'";
    $result = $this->con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        return $row['Genero'];
        
    } else {
        return null;
    }
}   
public function getEspecialidadMedico($medicoID)
{
    $sql = "SELECT Especialidad FROM Medicos WHERE MedicoID = '$medicoID'";
    $result = $this->con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        return $row['Especialidad'];
        
    } else {
        return null;
    } 
}
    


}



