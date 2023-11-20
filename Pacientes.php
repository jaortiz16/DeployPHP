<?php
// ... (Conexión a la base de datos y otras configuraciones)
include './navbar.php';
include_once("class/class.paciente.php");
include_once("DB/coneccion.php");
$paciente = new Paciente($cn);

// Verificar si se ha enviado un formulario para realizar alguna acción CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        // Insertar nuevo paciente
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $genero = $_POST['genero'];

        $paciente->insertPaciente($nombre, $edad, $genero);
    } elseif (isset($_POST['update'])) {
        // Actualizar paciente existente
        $id = $_POST['pacienteID'];
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $genero = $_POST['genero'];

        $paciente->updatePaciente($id, $nombre, $edad, $genero);
    } elseif (isset($_POST['delete'])) {
        // Eliminar paciente
        $id = $_POST['pacienteID'];

        $paciente->deletePaciente($id);
    }
}

// Obtener todos los pacientes
$pacientes = $paciente->getAllPacientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Pacientes</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Pacientes</h2>

    <!-- Formulario para Insertar y Actualizar Pacientes -->
    <form action="" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="edad" class="form-label">Edad:</label>
            <input type="number" class="form-control" name="edad" required>
        </div>

        <div class="mb-3">
            <label for="genero" class="form-label">Género:</label>
            <select class="form-select" name="genero" required>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
        </div>

        <button type="submit" name="insert" class="btn btn-primary">Insertar Paciente</button>
        <button type="submit" name="update" class="btn btn-success">Actualizar Paciente</button>
    </form>

    <!-- Tabla para Mostrar Pacientes -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID Paciente</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Género</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pacientes as $row): ?>
            <tr>
                <td><?php echo $row['PacienteID']; ?></td>
                <td><?php echo $row['Nombre']; ?></td>
                <td><?php echo $row['Edad']; ?></td>
                <td><?php echo $row['Genero']; ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="pacienteID" value="<?php echo $row['PacienteID']; ?>">
                        <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
                        <a href="Edit_Pacientes.php?id=<?php echo $row['PacienteID'] ?>" class="btn btn-warning">
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