<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('titulo') ?>
    <title>Listado de Peliculas <?= view('partial/username') ?></title>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <h1>Listado de Peliculas</h1>

    <a href="<?= base_url('peliculas/new'); ?>">Crear</a>
    <table>
        <tr>
            <th>Id</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Opciones</th>
        </tr>
        <?php foreach($peliculas as $key => $value) :?>
            <tr>
                <td><?= $value['id'] ?></td>
                <td><?= $value['titulo'] ?></td>
                <td><?= $value['descripcion'] ?></td>
                <td>
                    <a href="<?= base_url('peliculas/show/'.$value['id']); ?>">Show </a>
                    <a href="<?= base_url('peliculas/edit/'.$value['id']); ?>">Editar </a>
                    <a href="<?= base_url('peliculas/remove/'.$value['id']); ?>">Borrar </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?= $this->endSection() ?>

