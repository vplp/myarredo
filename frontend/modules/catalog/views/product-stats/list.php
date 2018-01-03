<?php

/**
 * @var $pages \yii\data\Pagination
 * @var $model \frontend\modules\catalog\models\Product
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?= $this->render('_form_filter', [
                'model' => $model,
                'params' => $params,
            ]); ?>

            <div class="cat-prod-wrap">
                <div class="cat-prod">

                    <?php foreach ($models as $model) {
                        echo $this->render('_list_item', [
                            'model' => $model,
                        ]);
                    } ?>

                </div>
                <div class="pagi-wrap">

                    <?= frontend\components\LinkPager::widget([
                        'pagination' => $pages,
                    ]);
                    ?>

                </div>
            </div>

        </div>
    </div>
</main>
