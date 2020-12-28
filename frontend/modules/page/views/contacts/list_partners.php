<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\user\widgets\partner\PartnerMap;
use frontend\modules\forms\widgets\FormFeedback;

$this->title = $this->context->title;
?>

<main>
    <div class="page concact-page">
        <div class="container large-container mob-fulwidth">
            <div class="col-md-12">
                <?= Html::tag('h1', $this->context->title); ?>

                <div class="map-cont">

                    <?= PartnerMap::widget([]) ?>

                    <?php if (in_array(DOMAIN_TYPE, ['com', 'de', 'co.il'])) {
                        echo FormFeedback::widget(['view' => 'form_become_partner']);
                    } ?>

                    <?php if (!in_array(DOMAIN_TYPE, ['com', 'de', 'co.il'])) {
                        echo Html::a(
                            Yii::t('app', 'Вернуться назад'),
                            Url::toRoute('/page/contacts/index'),
                            ['class' => 'view-all']
                        );
                    } ?>

                </div>
            </div>

        </div>
    </div>
</main>
