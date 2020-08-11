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

                <?php if (!empty($factory->pricesFiles)) { ?>
                    <ul class="list factory-catlist">
                        <?php foreach ($factory->pricesFiles as $priceFile) {
                            echo Html::beginTag('li') .
                                Html::a(
                                    ($priceFile->image_link
                                        ? Html::img($priceFile->getImageLink())
                                        : ''
                                    ) .
                                    Html::tag('i', '', ['class' => 'fa fa-file-pdf-o']) .
                                    Html::tag('span', $priceFile->title, ['class' => 'for-catalog-list']),
                                    $priceFile->getFileLink(),
                                    ['target' => '_blank', 'class' => 'click-on-factory-file btn-inpdf', 'data-id' => $priceFile->id]
                                ) .
                                Html::endTag('li');
                        } ?>
                    </ul>
                <?php } ?>

            </div>
        </div>
    </div>
</main>
