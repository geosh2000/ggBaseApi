<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->renderSection('titulo') ?>
</head>
    <body>
        <?= view('partial/sessions'); ?>

        <?= $this->renderSection('contenido') ?>
    </body>
</html>