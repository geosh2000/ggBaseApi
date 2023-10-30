<?php if(session('error')): ?>
    <div class="alert alert-success">
        <?= session('error') ?>
    </div>

<?php endif ?>