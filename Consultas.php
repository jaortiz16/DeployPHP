<?php
include './navbar.php';
include_once("class/class.consulta.php");
include_once("class/class.medico.php");
include_once("class/class.paciente.php");
include_once("DB/coneccion.php");

// Inicializar objeto Consulta
$consulta = new Consulta($cn);

// Verificar si se ha enviado un formulario para realizar alguna acción CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        // Insertar nueva consulta
        $pacienteID = $_POST['pacienteID'];
        $medicoID = $_POST['medicoID'];
        $fechaConsulta = $_POST['fechaConsulta'];
        $diagnostico = $_POST['diagnostico'];

        // Verificar género del paciente
        $generoPaciente = $consulta->getGeneroPaciente($pacienteID);
        //ver la especialidad del medico
        $especialidadMedico = $consulta->getEspecialidadMedico($medicoID);
        // Aplicar reglas de negocio
        if ($generoPaciente == 'Femenino') {
            // Si es femenino, solo permitir médicos con especialidad 'Ginecología'
            if ($especialidadMedico != 'Ginecología') {
                // Mostrar un mensaje de error
                echo "<div style='color: red; text-align: center; font-size: 18px;'>Lo sentimos, solo se permite seleccionar médicos con especialidad 'Ginecología' para pacientes femeninos.</div>";
                // Redireccionar a Consultas.php después de 2 segundos
                echo "<script>setTimeout(function(){ window.location.href = 'Consultas.php'; }, 5000);</script>";
                exit();
            }
            // Además, solo atender los días lunes, miércoles y viernes
            $dayOfWeek = date('N', strtotime($fechaConsulta));
            if (!in_array($dayOfWeek, [1, 3, 5])) {
                // Mostrar un mensaje de error
                echo "<div style='color: red; text-align: center; font-size: 18px;'>Lo sentimos, solo se permiten citas los días lunes, miércoles y viernes para pacientes femeninos.</div>";
                // Redireccionar a Consultas.php después de 2 segundos
                echo "<script>setTimeout(function(){ window.location.href = 'Consultas.php'; }, 5000);</script>";
                exit();
            }
        } else {
            // Si es masculino, no permitir médicos con especialidad 'Ginecología'
            if ($especialidadMedico == 'Ginecología') {
                // Mostrar un mensaje de error
                echo "<div style='color: red; text-align: center; font-size: 18px;'>Lo sentimos, no se permite seleccionar médicos con especialidad 'Ginecología' para pacientes masculinos.</div>";
                // Redireccionar a Consultas.php después de 2 segundos
                echo "<script>setTimeout(function(){ window.location.href = 'Consultas.php'; }, 5000);</script>";
                exit();
            }
            // Además, no permitir citas los días sábado y domingo
            $dayOfWeek = date('N', strtotime($fechaConsulta));
            if (in_array($dayOfWeek, [6, 7])) {
                // Mostrar un mensaje de error
                echo "<div style='color: red; text-align: center; font-size: 18px;'>Lo sentimos, no se permiten citas los días sábado y domingo para pacientes masculinos.</div>";
                // Redireccionar a Consultas.php después de 2 segundos
                echo "<script>setTimeout(function(){ window.location.href = 'Consultas.php'; }, 5000);</script>";
                exit();
            }
        }

        

        // Verificar si se cargó un archivo de foto
        if ($_FILES['foto']['error'] == 0) {
            $foto = $_FILES['foto']['name'];
            $rutaFoto = 'imagenes/' . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFoto);
        } else {
            $foto = ''; // Si no se cargó una foto, dejarlo vacío o manejarlo según tus necesidades
        }

        $consulta->insertConsulta($pacienteID, $medicoID, $fechaConsulta, $diagnostico, $foto);
    } elseif (isset($_POST['update'])) {
        // Actualizar consulta existente
        $consultaID = $_POST['consultaID'];
        $pacienteID = $_POST['pacienteID'];
        $medicoID = $_POST['medicoID'];
        $fechaConsulta = $_POST['fechaConsulta'];
        $diagnostico = $_POST['diagnostico'];

        // Verificar género del paciente
        $generoPaciente = $consulta->getGeneroPaciente($pacienteID);

        // Aplicar reglas de negocio
        if ($generoPaciente == 'Femenino') {
            // Si es femenino, solo permitir médicos con especialidad 'Ginecología'
            if ($medicoID != 'Ginecologia') {
                // Mostrar un mensaje de error o manejar según tus necesidades
                echo "Solo se permite seleccionar médicos con especialidad 'Ginecología' para pacientes femeninos.";
                exit();
            }
            // Además, solo atender los días lunes, miércoles y viernes
            $dayOfWeek = date('N', strtotime($fechaConsulta));
            if (!in_array($dayOfWeek, [1, 3, 5])) {
                // Mostrar un mensaje de error o manejar según tus necesidades
                echo "Solo se permiten citas los días lunes, miércoles y viernes para pacientes femeninos.";
                exit();
            }
        } else {
            // Si es masculino, no permitir médicos con especialidad 'Ginecología'
            if ($medicoID == 'Ginecologia') {
                // Mostrar un mensaje de error o manejar según tus necesidades
                echo "No se permite seleccionar médicos con especialidad 'Ginecología' para pacientes masculinos.";
                exit();
            }
            // Además, no permitir citas los días sábado y domingo
            $dayOfWeek = date('N', strtotime($fechaConsulta));
            if (in_array($dayOfWeek, [6, 7])) {
                // Mostrar un mensaje de error o manejar según tus necesidades
                echo "No se permiten citas los días sábado y domingo para pacientes masculinos.";
                exit();
            }
        }

        if ($_FILES['foto']['error'] == 0) {
            $foto = $_FILES['foto']['name'];
            $rutaFoto = 'uploads/' . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFoto);
        } else {
            $foto = '';
        }

        $consulta->updateConsulta($consultaID, $pacienteID, $medicoID, $fechaConsulta, $diagnostico, $foto);
    } elseif (isset($_POST['delete'])) {
        // Eliminar consulta
        $consultaID = $_POST['consultaID'];

        $consulta->deleteConsulta($consultaID);
    }
}

// Obtener todas las consultas
$consultas = $consulta->getAllConsultas();

// Obtener nombres de pacientes para el select
$pacientes = $consulta->getNombresPacientes();

// Obtener nombres de médicos para el select
$medicos = $consulta->getNombresMedicos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Consultas</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-4">
        <h2>Consultas</h2>

        <!-- Formulario para Insertar y Actualizar Consultas -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="pacienteID" class="form-label">Paciente:</label>
                <!-- Mantenemos el select para los pacientes -->
                <select class="form-select" name="pacienteID" required>
                    <?php
                    foreach ($pacientes as $paciente) {
                        echo "<option value='{$paciente['PacienteID']}'>{$paciente['Nombre']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="medicoID" class="form-label">Médico:</label>
                <!-- Cambié el campo de texto por un select -->
                <select class="form-select" name="medicoID" required>
                    <?php
                    foreach ($medicos as $medico) {
                        // Mostrar el nombre y especialidad del médico
                        echo "<option value='{$medico['MedicoID']}'>{$medico['Nombre']} ({$medico['Especialidad']})</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechaConsulta" class="form-label">Fecha de Consulta:</label>
                <input type="date" class="form-control" name="fechaConsulta" required>
            </div>

            <div class="mb-3">
                <label for="diagnostico" class="form-label">Diagnóstico:</label>
                <input type="text" class="form-control" name="diagnostico" required>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" accept="image/*">
            </div>

            <button type="submit" name="insert" class="btn btn-primary">Insertar Consulta</button>
        </form>

        <!-- Tabla para Mostrar Consultas -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID Consulta</th>
                    <th>Nombre Paciente</th>
                    <th>Nombre Médico</th>
                    <th>Fecha Consulta</th>
                    <th>Diagnóstico</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultas as $row): ?>
                    <tr>
                        <td>
                            <?php echo $row['ConsultaID']; ?>
                        </td>
                        <td>
                            <?php echo $row['NombrePaciente']; ?>
                        </td>
                        <td>
                            <?php echo $row['NombreMedico']; ?>
                        </td>
                        <td>
                            <?php echo $row['FechaConsulta']; ?>
                        </td>
                        <td>
                            <?php echo $row['Diagnostico']; ?>
                        </td>
                        <td><img src="./imagenes/<?php echo $row['Foto']; ?>" alt="Foto" style="max-width: 100px;"></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="consultaID" value="<?php echo $row['ConsultaID']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
                                <a href="Edit_Consultas.php?id=<?php echo $row['ConsultaID'] ?>" class="btn btn-warning">
                                    Editar
                                </a>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Agregar enlaces a los archivos JavaScript de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
