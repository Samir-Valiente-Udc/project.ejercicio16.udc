<?php $title = "Gestión de Contratos"; ob_start(); ?>

<h1>Contratos</h1>
<a href="create.php" class="btn btn-success">Nuevo Contrato</a>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>Empleado</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contratos as $contrato): ?>
            <tr>
                <td><?= $contrato->getId() ?></td>
                <td><?= htmlspecialchars($contrato->getEmpresa()) ?></td>
                <td><?= htmlspecialchars($contrato->getEmpleado()) ?></td>
                <td><?= $contrato->getFechaInicio() ?></td>
                <td><?= $contrato->getFechaFin() ?></td>
                <td><?= number_format($contrato->getMonto(), 2) ?></td>
                <td><?= $contrato->getEstado() ?></td>
                <td>
                    <a href="edit.php?id=<?= $contrato->getId() ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="delete.php?id=<?= $contrato->getId() ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este contrato?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
$content = ob_get_clean(); 
include '../layouts/default.php';
?>