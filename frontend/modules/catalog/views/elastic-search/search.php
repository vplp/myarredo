<?php

use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var \frontend\modules\catalog\models\ElasticSearchProduct $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="row">
                    <?= Html::tag('h1', $this->title, []); ?>
                </div>
                <div class="cat-content">
                    <div class="row">

                        <div class="col-md-12 col-lg-12">
                            <div class="cont-area">
                                <h3>Результат поиска
                                    для <?php echo "<span class='label label-success'>" . $query . "</span>" ?></h3>

                                <div class="cat-prod-wrap">
                                    <div class="cat-prod">

                                        <?php foreach ($models as $model) {

                                            $product = Product::findByID($model['_source']['id']);

                                            $factory = [];
                                            $factory[$product['factory']['id']] = $product['factory'];

                                            echo $this->render('/category/_list_item', [
                                                'model' => $product,
                                                'factory' => $factory,
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
