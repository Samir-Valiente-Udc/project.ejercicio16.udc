<?php
// Asegúrate de incluir el autoloader o la clase Session directamente
require_once __DIR__ . '/../../Utils/Session.php';
use Utils\Session;

if (Session::hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Session::getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Session::hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Session::getFlash('error') ?>
    </div>
<?php endif; ?>

<?php if (Session::hasFlash('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (Session::getFlash('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>