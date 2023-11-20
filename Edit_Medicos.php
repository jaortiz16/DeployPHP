<?php
include './navbar.php';
include_once("class/class.medico.php");
include_once("DB/coneccion.php");

$medico = new Medico($cn);

// Verificar si se ha enviado un formulario para realizar alguna acción CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        // Actualizar médico existente
        $id = $_POST['medicoID'];
        $nombre = $_POST['nombre'];
        $especialidad = $_POST['especialidad'];

        $medico->updateMedico($id, $nombre, $especialidad);

        // Redirigir a la página de Médicos después de actualizar
        header("Location: Medicos.php");
        exit();
    }
}

// Obtener el ID del médico de la URL
if (isset($_GET['id'])) {
    $medicoID = $_GET['id'];

    // Obtener los datos del médico por su ID
    $medico->getMedicoById($medicoID);
} else {
    // Si no se proporciona un ID válido, redirigir a la página principal
    header("Location: Medicos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Médico</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Editar Médico</h2>

    <!-- Formulario para Editar Médico -->
    <form action="" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $medico->getNombre(); ?>" required>
        </div>

        <div class="mb-3">
            <label for="especialidad" class="form-label">Especialidad:</label>
            <input type="text" class="form-control" name="especialidad" value="<?php echo $medico->getEspecialidad(); ?>" required>
        </div>

        <input type="hidden" name="medicoID" value="<?php echo $medico->getId(); ?>">
        <button type="submit" name="update" class="btn btn-success">Actualizar Médico</button>
    </form>
</div>

<!-- Agregar enlaces a los archivos JavaScript de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
