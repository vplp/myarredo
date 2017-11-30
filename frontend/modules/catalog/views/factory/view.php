<?php

use yii\helpers\{
    Url, Html
};
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\Factory;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 */

$keys = Yii::$app->catalogFilter->keys;

$this->title = $this->context->title;
?>

<main>
    <div class="page factory-page">
        <div class="letter-nav">
            <div class="container large-container">
                <ul class="letter-select">

                    <?php
                    foreach (Factory::getListLetters() as $letter) {
                        echo Html::beginTag('li') .
                            Html::a(
                                $letter['first_letter'],
                                Url::toRoute(['/catalog/factory/list', 'letter' => strtolower($letter['first_letter'])])
                            ) .
                            Html::endTag('li');
                    } ?>

                </ul>
                <?= Html::a('Все', Url::toRoute(['/catalog/factory/list']), ['class' => 'all']); ?>
            </div>
        </div>
        <div class="container large-container">

            <div class="row">
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>
            </div>

            <div class="row factory-det">
                <div class="col-sm-3 col-md-3">
                    <div class="fact-img">
                        <?= Html::img(Factory::getImage($model['image_link'])); ?>
                    </div>
                </div>
                <div class="col-sm-9 col-md-9">
                    <div class="descr">

                        <?= Html::tag(
                            'h1',
                            'Итальянская мебель ' . $model['lang']['title'],
                            ['class' => 'title-text']
                        ); ?>

                        <div class="fact-link">
                            <?= Html::a($model['url'], 'http://' . $model['url'], ['target' => '_blank']); ?>
                        </div>

                        <div class="fact-assort">
                            <div class="all-list">
                                <a href="#" class="title">Все предметы мебели</a>
                                <ul class="list">

                                    <?php
                                    $key = 1;
                                    $FactoryTypes = Factory::getFactoryTypes($model['id']);
                                    foreach ($FactoryTypes as $item) {

                                        $params = Yii::$app->catalogFilter->params;

                                        $params[$keys['factory']][] = $model['alias'];
                                        $params[$keys['type']][] = $item['alias'];

                                        echo Html::beginTag('li') .
                                            Html::a(
                                                $item['title'] . ' (' . $item['count'] . ')',
                                                Yii::$app->catalogFilter->createUrl($params)
                                            ) .
                                            Html::endTag('li');

                                        if ($key == 10) {
                                            echo '</ul><ul class="list post-list">';
                                        }

                                        ++$key;

                                    } ?>

                                </ul>

                                <?php
                                if (count($FactoryTypes) > 10) {
                                    echo Html::a(
                                        'Весь список',
                                        'javascript:void(0);',
                                        ['class' => 'view-all']
                                    );
                                } ?>

                            </div>
                            <div class="all-list">
                                <a href="#" class="title">
                                    Все коллекции
                                </a>
                                <ul class="list">

                                    <?php
                                    $key = 1;
                                    $FactoryCollection = Factory::getFactoryCollection($model['id']);
                                    foreach ($FactoryCollection as $item) {

                                        $params = Yii::$app->catalogFilter->params;

                                        $params[$keys['factory']][] = $model['alias'];
                                        $params[$keys['collection']][] = $item['id'];

                                        echo Html::beginTag('li') .
                                            Html::a(
                                                $item['title'] . ' (' . $item['count'] . ')',
                                                Yii::$app->catalogFilter->createUrl($params)
                                            ) .
                                            Html::endTag('li');

                                        if ($key == 10) {
                                            echo '</ul><ul class="list post-list">';
                                        }

                                        ++$key;

                                    } ?>

                                </ul>

                                <?php
                                if (count($FactoryCollection) > 10) {
                                    echo Html::a(
                                        'Весь список',
                                        'javascript:void(0);',
                                        ['class' => 'view-all']
                                    );
                                } ?>

                            </div>
                        </div>

                        <?= $this->render(
                            'parts/_factory_files',
                            [
                                'model' => $model
                            ]
                        ); ?>

                        <div class="text">
                            <?= $model['lang']['content']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row menu-style">
                <a href="#">Все</a>

                <?php
                $key = 1;
                $FactoryCategory = Factory::getFactoryCategory([$model['id']]);

                foreach ($FactoryCategory as $item) {
                    $params = Yii::$app->catalogFilter->params;

                    $params[$keys['factory']][] = $model['alias'];
                    $params[$keys['category']][] = $item['alias'];

                    echo Html::a(
                            $item['title'],
                            Yii::$app->catalogFilter->createUrl($params)
                        ) .
                        Html::endTag('li');
                } ?>

            </div>

            <div class="cat-prod catalog-wrap">

                <?php
                foreach ($product as $item) {
                    echo $this->render('/category/_list_item', [
                        'model' => $item,
                        'factory' => [$model->id => $model]
                    ]);
                }

                echo Html::a(
                    'смотреть полный<div>Каталог</div>',
                    Yii::$app->catalogFilter->createUrl(['factory' => $model['alias']]),
                    ['class' => 'one-prod-tile last']
                ); ?>

            </div>

        </div>
    </div>
</main>
