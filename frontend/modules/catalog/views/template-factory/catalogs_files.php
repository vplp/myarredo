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

<?= Html::tag('h1', $this->context->title); ?>

<?php if (!empty($factory->catalogsFiles)) { ?>
    <ul class="list">
        <?php foreach ($factory->catalogsFiles as $catalogFile) {
            echo Html::beginTag('li') .
                Html::a(
                    ($catalogFile->image_link
                        ? Html::img($catalogFile->getImageLink())
                        : ''
                    ) .
                    Html::tag('span', $catalogFile->title, ['class' => 'for-catalog-list']),
                    $catalogFile->getFileLink(),
                    ['target' => '_blank', 'class' => 'click-on-factory-file', 'data-id' => $catalogFile->id]
                ) .
                Html::endTag('li');
        } ?>
    </ul>
<?php } ?>
