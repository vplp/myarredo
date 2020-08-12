<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    Factory, FactoryCatalogsFiles
};

/**
 * @var $factory Factory
 * @var $catalogFile FactoryCatalogsFiles
 */

$this->title = $this->context->title;
?>

<main>
    <div class="page concact-page">
        <div class="container large-container">
            <div class="col-md-12">

                <?= Html::tag('h1', $this->context->title); ?>

                <?php if (!empty($factory->catalogsFiles)) { ?>
                    <ul class="list factory-catlist">
                        <?php foreach ($factory->catalogsFiles as $catalogFile) {
                            echo Html::beginTag('li') .
                                Html::a(
                                    ($catalogFile->image_link
                                        ? Html::img($catalogFile->getImageLink())
                                        : ''
                                    ) .
                                    Html::tag('i', '', ['class' => 'fa fa-file-pdf-o']).
                                    Html::tag('span', $catalogFile->title, ['class' => 'for-catalog-list']),
                                    $catalogFile->getFileLink(),
                                    ['target' => '_blank', 'class' => 'click-on-factory-file btn-inpdf', 'data-id' => $catalogFile->id]
                                ) .
                                Html::endTag('li');
                        } ?>
                    </ul>
                <?php } ?>

            </div>
        </div>
    </div>
</main>