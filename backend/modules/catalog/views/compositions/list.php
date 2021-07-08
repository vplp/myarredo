<?php

use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Category, Factory, Composition, CompositionLang
};
use backend\app\bootstrap\ActiveForm;

/**
 * @var $form ActiveForm
 * @var $model Composition
 * @var $filter Composition
 * @var $modelLang CompositionLang
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                /** @var $model Product */
                return date('j.m.Y H:i', $model->created_at);
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                /** @var $model Composition */
                return date('j.m.Y H:i', $model->updated_at);
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'attribute' => 'Редактор',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var $model Composition */

                if ($model->editor) {
                    return $this->render('parts/_editors_modal', [
                        'model' => $model
                    ]);
                } else {
                    return '';
                }
            },
            'filter' => GridViewFilter::selectOne($filter, 'editor_id', [0 => '-'] + Composition::dropDownListEditor()),
        ],
        [
            'label' => 'Время обновления',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var $model Factory */

                if ($model->editor && Logbook::getCountItems($model->id, 'Composition')) {
                    $dataProvider = Logbook::getLastItem($model->id, 'Composition');
                    return date('j.m.Y H:i', $dataProvider->updated_at);
                } else {
                    return '';
                }
            },
            'filter' => false,
        ],
        [
            'attribute' => 'category',
            'value' => function ($model) {
                /** @var $model Composition */
                $result = [];
                foreach ($model->category as $category) {
                    $result[] = ($category->lang) ? $category->lang->title : '(не задано)';
                }
                return implode(', ', $result);
            },
            'label' => Yii::t('app', 'Category'),
            'filter' => GridViewFilter::selectOne($filter, 'category', Category::dropDownList()),
        ],
        [
            'attribute' => Yii::t('app', 'Factory'),
            'value' => 'factory.title',
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
