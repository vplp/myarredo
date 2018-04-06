<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="prod-card-page page">
        <div class="container large-container">
            <div class="row">
                <div class="product-title">
                    <?= Html::tag(
                        'h1',
                        $model->getTitle(),
                        ['class' => 'prod-model', 'itemprop' => 'name']
                    ); ?>
                </div>

                <div class="col-md-12">

                    <?= $this->render('_form_filter', [
                        'model' => $modelProductStatsDays,
                        'params' => $params,
                    ]); ?>

                    <table border="1">
                        <tr>
                            <td>город</td>
                            <td>количество просмотров</td>
                        </tr>
                        <?php foreach ($modelsStats as $item): ?>
                            <tr>
                                <td><?= $item['city']['lang']['title'] ?></td>
                                <td><?= $item['views'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <?= frontend\components\LinkPager::widget([
                        'pagination' => $pagesStats,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</main>