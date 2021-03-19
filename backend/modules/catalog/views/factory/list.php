<?php

use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};
use backend\app\bootstrap\ActiveForm;
use backend\widgets\GridView\{
    GridView, gridColumns\ActionColumn
};
use backend\modules\catalog\models\{
    Factory, FactoryLang
};
use backend\modules\location\models\Country;
use backend\modules\sys\modules\logbook\models\Logbook;

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

$visible = in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor']) ? true : false;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        [
            'attribute' => 'title',
            'value' => 'title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => Yii::t('app', 'Producing country'),
            'value' => 'producingCountry.title',
            'filter' => GridViewFilter::selectOne(
                $filter,
                'producing_country_id',
                [0 => '-'] + Factory::dropDownListProducingCountry()
            ),
        ],
        [
            'attribute' => 'Редактор',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var $model Factory */

                if ($model->editor && Logbook::getCountItems($model->id, 'Factory')) {
                    return $this->render('parts/_editors_modal', [
                        'model' => $model
                    ]);
                } else {
                    return '';
                }
            },
            'filter' => GridViewFilter::selectOne($filter, 'editor_id', [0 => '-'] + Factory::dropDownListEditor()),
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                /** @var $model Factory */
                return date('j.m.Y H:i', $model->updated_at);
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'show_for_ru',
            'action' => 'show_for_ru',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'show_for_ua',
            'action' => 'show_for_ua',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'show_for_com',
            'action' => 'show_for_com',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'show_for_de',
            'action' => 'show_for_de',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionColumn::class,
        ],
    ]
]);
