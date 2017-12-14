<?php

//use frontend\themes\myarredo\assets\JqueryUiAsset;
//JqueryUiAsset::register($this);

/**
 * @var $pages \yii\data\Pagination
 * @var $model \frontend\modules\catalog\models\Product
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'admin') {
                echo $this->render('_form_filter', [
                    'model' => $model,
                ]);
            } ?>

            <div class="cat-prod-wrap">
                <div class="cat-prod">

                    <?php
                    foreach ($models as $model) {
                        echo $this->render('_list_item', [
                            'model' => $model,
                        ]);
                    } ?>

                </div>
                <div class="pagi-wrap">

                    <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                        'registerLinkTags' => true,
                        'nextPageLabel' => 'Далее<i class="fa fa-angle-right" aria-hidden="true"></i>',
                        'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>Назад'
                    ]);
                    ?>

                </div>
            </div>

        </div>
    </div>
</main>
