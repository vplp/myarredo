<?php

use yii\grid\GridView;
use yii\helpers\{
    Url, Html
};
use kartik\widgets\Select2;
use backend\modules\catalog\models\FactorySubdivision;
use backend\modules\catalog\models\Factory;
use backend\modules\user\models\{
    Profile, ProfileLang
};
use backend\modules\location\models\{
    City, Country
};
use backend\app\bootstrap\ActiveForm;
use thread\widgets\grid\ActionStatusColumn;

/** @var $model Profile */
/** @var $modelLang ProfileLang */
/** @var $form ActiveForm */

if (in_array($model['user']['group_id'], [3])) {
    echo $form->field($model, 'factory_id')
        ->selectOne([0 => '--'] + Factory::dropDownList($model->factory_id));

    echo $form->text_line($model, 'email_company');

    echo $form->text_line($model, 'website');

    echo $form->text_line($modelLang, 'address');

    echo $form
        ->field($model, 'country_ids')
        ->label(Yii::t('app', 'Ответ на заявку из страны'))
        ->widget(Select2::class, [
            'data' => Country::dropDownList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);

    echo Html::tag('h3', Yii::t('app', 'Представительство'));

    echo GridView::widget([
        'dataProvider' => (new FactorySubdivision())->search([
            'FactorySubdivision' => [
                'user_id' => $model->id,
            ]
        ]),
        'columns' => [
            'company_name',
            [
                'attribute' => 'region',
                'value' => function ($item) {
                    return FactorySubdivision::regionKeyRange($item['region']);
                },
                'format' => 'raw',
            ],
            'contact_person',
            'email',
            'phone',
            [
                'attribute' => 'updated_at',
                'value' => function ($item) {
                    return date('j.m.Y H:i', $item->updated_at);
                },
                'format' => 'raw',
                'filter' => false
            ],
            [
                'class' => ActionStatusColumn::class,
                'attribute' => 'published',
                'action' => '/catalog/factory-subdivision/published'
            ],
//            [
//                'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
//                'updateLink' => function ($item) {
//                    return Url::toRoute([
//                        '/catalog/factory-subdivision/update',
//                        'user_id' => $item['user_id'],
//                        'id' => $item['id']
//                    ]);
//                },
//                'deleteLink' => function ($item) {
//                    return Url::toRoute([
//                        '/catalog/factory-subdivision/intrash',
//                        'user_id' => $item['user_id'],
//                        'id' => $item['id']
//                    ]);
//                }
//            ],
        ]
    ]);
}
