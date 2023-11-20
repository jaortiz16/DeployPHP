<?php
include './navbar.php';
include_once("class/class.medico.php");
include_once("DB/coneccion.php");
$medico = new Medico($cn);

// Verificar si se ha enviado un formulario para realizar alguna acción CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        // Insertar nuevo médico
        $nombre = $_POST['nombre'];
        $especialidad = $_POST['especialidad'];

        $medico->insertMedico($nombre, $especialidad);
    } elseif (isset($_POST['update'])) {
        // Actualizar médico existente
        $id = $_POST['medicoID'];
        $nombre = $_POST['nombre'];
        $especialidad = $_POST['especialidad'];

        $medico->updateMedico($id, $nombre, $especialidad);
    } elseif (isset($_POST['delete'])) {
        // Eliminar médico
        $id = $_POST['medicoID'];

        $medico->deleteMedico($id);
    }
}

// Obtener todos los médicos
$medicos = $medico->getAllMedicos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Médicos</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Médicos</h2>

    <!-- Formulario para Insertar y Actualizar Médicos -->
    <form action="" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="especialidad" class="form-label">Especialidad:</label>
            <input type="text" class="form-control" name="especialidad" required>
        </div>

        <button type="submit" name="insert" class="btn btn-primary">Insertar Médico</button>

    </form>

    <!-- Tabla para Mostrar Médicos -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID Médico</th>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicos as $row): ?>
            <tr>
                <td><?php echo $row['MedicoID']; ?></td>
                <td><?php echo $row['Nombre']; ?></td>
                <td><?php echo $row['Especialidad']; ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="medicoID" value="<?php echo $row['MedicoID']; ?>">
                        <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
                        <a href="Edit_Medicos.php?id=<?php echo $row['MedicoID'] ?>" class="btn btn-warning">
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
