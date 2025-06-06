<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Contratos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../resources/header.php'; ?>
    <?php include '../resources/sidebar.php'; ?>
    
    <main class="container">
        <?php include '../resources/messages.php'; ?>
        <?php echo $content; ?>
    </main>
    
    <?php include '../resources/footer.php'; ?>
    <script src="../js/scripts.js"></script>
    <script src="../js/validate-forms.js"></script>
</body>
</html>