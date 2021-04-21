<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    Factory, FactoryPricesFiles
};

/**
 * @var $factory Factory
 * @var $priceFile FactoryPricesFiles
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page concact-page">
        <div class="container large-container">
            <div class="col-md-12">

                <?= Html::tag('h1', $this->context->title); ?>

                <?= $factory->lang->working_conditions ?>

            </div>
        </div>
    </div>
</main>
