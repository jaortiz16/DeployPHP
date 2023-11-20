<?php
include './navbar.php';
include_once("class/class.paciente.php");
include_once("DB/coneccion.php");

$paciente = new Paciente($cn);

// Verificar si se ha enviado un formulario para realizar alguna acción CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        // Actualizar paciente existente
        $id = $_POST['pacienteID'];
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $genero = $_POST['genero'];

        $paciente->updatePaciente($id, $nombre, $edad, $genero);

        // Redirigir a la página de Pacientes después de actualizar
        header("Location: Pacientes.php");
        exit();
    }
}

// Obtener el ID del paciente de la URL
if (isset($_GET['id'])) {
    $pacienteID = $_GET['id'];

    // Obtener los datos del paciente por su ID
    $paciente->getPacienteById($pacienteID);
} else {
    // Si no se proporciona un ID válido, redirigir a la página principal
    header("Location: Pacientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Paciente</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Editar Paciente</h2>

    <!-- Formulario para Editar Paciente -->
    <form action="" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $paciente->getNombre(); ?>" required>
        </div>

        <div class="mb-3">
            <label for="edad" class="form-label">Edad:</label>
            <input type="number" class="form-control" name="edad" value="<?php echo $paciente->getEdad(); ?>" required>
        </div>

        <div class="mb-3">
            <label for="genero" class="form-label">Género:</label>
            <select class="form-select" name="genero" required>
                <option value="Masculino" <?php echo ($paciente->getGenero() == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="Femenino" <?php echo ($paciente->getGenero() == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
            </select>
        </div>

        <input type="hidden" name="pacienteID" value="<?php echo $paciente->getId(); ?>">
        <button type="submit" name="update" class="btn btn-success">Actualizar Paciente</button>
    </form>
</div>

<!-- Agregar enlaces a los archivos JavaScript de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
