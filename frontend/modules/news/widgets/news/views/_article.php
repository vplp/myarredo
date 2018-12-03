<?php

use yii\helpers\Html;

?>

<div class="newsbox-item">
    <div class="newsbox-item-title"><?= Html::encode($article['lang']['title']) ?></div>
    <div class="newsbox-item-descr"><?= $article['lang']['description'] ?></div>
    <div class="newsbox-item-more">
        <?php if ($article['lang']['content'] !== '') { ?>
            <?= Html::a(
                Yii::t('app', 'Подробнее'),
                'javascript:void(0);',
                [
                    'class' => 'btn-descr',
                    'data-toggle' => 'modal',
                    'data-target' => '#articleForPartners' . $article['id']
                ]
            ) ?>
        <?php } ?>
    </div>
    <?php if ($article['lang']['content'] !== '') { ?>
        <div class="modal fade" id="articleForPartners<?= $article['id'] ?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><?= Html::encode($article['lang']['title']) ?></h4>
                    </div>
                    <div class="modal-body">

                        <?= $article['lang']['content']?>

                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>