<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\forms\models\FormsFeedback;

/**
 * @var FormsFeedback $model
 */

?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title"><?= Yii::t('app', 'Связаться с оператором сайта') ?></h3>
        </div>
        <div class="modal-body">

            <?php if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) { ?>
                <h4><?= Yii::t('app', 'Contacts') ?></h4>

                <?php
                if (DOMAIN_TYPE == 'com') {
                    $phone = '<a href="tel:+3904221500215">+39 (0422) 150-02-15</a>';
                } elseif (DOMAIN_TYPE == 'ua') {
                    $phone = '<a href="tel:+3904221500215">+39 (0422) 150-02-15</a>';
                } else {
                    $phone = '<a href="tel:+79683533636">+7 968 353 36 36</a>';
                }
                $email = (DOMAIN_TYPE == 'ua') ? '<a href="mailto:help@myarredo.ua">help@myarredo.ua</a>' : '<a href="mailto:help@myarredo.ru">help@myarredo.ru</a>';
                ?>

                <p><i class="fa fa-phone" aria-hidden="true"></i> <?= $phone ?></p>
                <p><i class="fa fa-envelope-o" aria-hidden="true"></i> <?= $email ?></p>
                <p><i class="fa fa-skype" aria-hidden="true"></i>
                    skype: <?= Html::a('daniellalazareva123', 'skype:daniellalazareva123?chat') ?></p>
            <?php } ?>

            <h4 class="fdback-title"><?= Yii::t('app', 'Заполните форму') ?></h4>

            <?= $this->renderAjax('@app/modules/forms/views/forms/parts/form', [
                'model' => $model
            ]) ?>

        </div>
    </div>
</div>
