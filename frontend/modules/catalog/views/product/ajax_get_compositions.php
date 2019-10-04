<div class="col-md-12">
    <ul class="nav nav-tabs">
        <?php if (!empty($samples)) { ?>
            <li>
                <a data-toggle="tab" href="#panel2"><?= Yii::t('app', 'Варианты отделки') ?></a>
            </li>
        <?php } ?>
        <?php if (!empty($elementsComposition)) { ?>
            <li>
                <a data-toggle="tab" href="#panel1"><?= Yii::t('app', 'Предметы композиции') ?></a>
            </li>
        <?php } ?>
    </ul>

    <div class="tab-content">

        <?php if (!empty($samples)) { ?>
            <div id="panel2" class="tab-pane fade">
                <?= $this->render('parts/_samples', [
                    'samples' => $samples
                ]); ?>
            </div>
        <?php } ?>

        <?php if (!empty($elementsComposition)) { ?>
            <div id="panel1" class="tab-pane fade">
                <?= $this->render('parts/_product_by_composition', [
                    'models' => $elementsComposition
                ]); ?>
            </div>
        <?php } ?>

    </div>
</div>