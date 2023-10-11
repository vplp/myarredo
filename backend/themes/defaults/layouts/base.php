<?php $this->beginContent('@app/layouts/main.php'); ?>

<div class="row border-bottom white-bg page-heading">
    <div class="col-md-10">
        <h2><?= $this->context->getTitle() ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
