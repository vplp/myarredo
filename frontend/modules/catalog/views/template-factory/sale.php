<?php

/**
 * @var $pages \yii\data\Pagination
 * @var $model \frontend\modules\catalog\models\Sale
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area">

                            <div class="cat-prod-wrap">
                                <div class="cat-prod">

                                    <?php foreach ($models as $model) {
                                        echo $this->render('/sale/_list_item', [
                                            'model' => $model
                                        ]);
                                    } ?>

                                </div>

                                <?php if ($pages->totalCount > $pages->defaultPageSize) { ?>
                                    <div class="pagi-wrap">
                                        <?= frontend\components\LinkPager::widget([
                                            'pagination' => $pages,
                                        ]) ?>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="comp-advanteges">
                        <?= Yii::$app->metatag->seo_content ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
