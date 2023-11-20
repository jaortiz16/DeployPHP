<?php
include './navbar.php';
include_once("class/class.consulta.php");
include_once("class/class.medico.php");
include_once("class/class.paciente.php");
include_once("DB/coneccion.php");

// Inicializar objeto Consulta
$consulta = new Consulta($cn);

// Obtener el ID de la consulta de la URL
if (isset($_GET['id'])) {
    $consultaID = $_GET['id'];

    // Obtener los datos de la consulta por su ID
    $consulta->getConsultaById($consultaID);

    // Obtener nombres de pacientes para el select
    $pacientes = $consulta->getNombresPacientes();

    // Obtener nombres de médicos para el select
    $medicos = $consulta->getNombresMedicos();
} else {
    // Si no se proporciona un ID válido, redirigir a la página principal
    header("Location: Consultas.php");
    exit();
}

// Verificar si se ha enviado un formulario para realizar la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        // Obtener datos del formulario
        $pacienteID = $_POST['pacienteID'];
        $consultaID = $_POST['consultaID'];
        $medicoID = $_POST['medicoID'];
        $fechaConsulta = $_POST['fechaConsulta'];
        $diagnostico = $_POST['diagnostico'];

        // Verificar si se cargó un archivo de foto
        if ($_FILES['foto']['error'] == 0) {
            $foto = $_FILES['foto']['name'];
            $rutaFoto = 'uploads/' . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFoto);
        } else {
            $foto = ''; // Si no se cargó una foto, dejarlo vacío o manejarlo según tus necesidades
        }

        // Actualizar consulta
        $consulta->updateConsulta($consultaID, $pacienteID, $medicoID, $fechaConsulta, $diagnostico, $foto);

        // Redirigir a la página principal después de la actualización
        header("Location: Consultas.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consulta</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-4">
        <h2>Editar Consulta</h2>

        <!-- Formulario para Actualizar Consulta -->
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="consultaID" value="<?php echo $consulta->getId(); ?>">

            <div class="mb-3">
                <label for="pacienteID" class="form-label">Paciente:</label>
                <select class="form-select" name="pacienteID" required>
                    <?php
                    foreach ($pacientes as $paciente) {
                        $selected = ($paciente['PacienteID'] == $consulta->getPaciente()) ? 'selected' : '';
                        echo "<option value='{$paciente['PacienteID']}' $selected>{$paciente['Nombre']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="medicoID" class="form-label">Médico:</label>
                <select class="form-select" name="medicoID" required>
                    <?php
                    foreach ($medicos as $medico) {
                        $selected = ($medico['MedicoID'] == $consulta->getMedico()) ? 'selected' : '';
                        echo "<option value='{$medico['MedicoID']}' $selected>{$medico['Nombre']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechaConsulta" class="form-label">Fecha de Consulta:</label>
                <input type="date" class="form-control" name="fechaConsulta" value="<?php echo $consulta->getFechaConsulta(); ?>" required>
            </div>

            <div class="mb-3">
                <label for="diagnostico" class="form-label">Diagnóstico:</label>
                <input type="text" class="form-control" name="diagnostico" value="<?php echo $consulta->getDiagnostico(); ?>" required>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" accept="image/*">
            </div>

            <button type="submit" name="update" class="btn btn-success">Actualizar Consulta</button>
        </form>
    </div>

    <!-- Agregar enlaces a los archivos JavaScript de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
