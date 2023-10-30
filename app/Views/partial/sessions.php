<?php if(session('mensaje')): ?>
    <div class="alert alert-success">
        <?= session('mensaje') ?>
    </div>

<?php endif ?>