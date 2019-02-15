<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\Tabs;

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

$visible = in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])
    ? true
    : false;

$form = ActiveForm::begin();

echo $form->submit($model, $this);

echo Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'General'),
            'content' => $this->render('parts/_settings', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ]),
            'visible' => $visible
        ],
        [
            'label' => Yii::t('page', 'Page'),
            'content' => $this->render('parts/_page', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ]),
        ],
        [
            'label' => Yii::t('app', 'Image'),
            'content' => $this->render('parts/_image', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ]),
            'visible' => $visible
        ],
        [
            'label' => 'Коллекции',
            'content' => $this->render('parts/_collections', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ]),
            'visible' => $visible
        ],
        [
            'label' => Yii::t('app', 'Catalogs'),
            'content' => $this->render('parts/_catalogs', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ]),
            'visible' => $visible
        ],
        [
            'label' => Yii::t('app', 'Prices'),
            'content' => $this->render('parts/_prices', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ]),
            'visible' => $visible
        ],
        [
            'label' => 'Meta',
            'content' => $this->render('parts/_meta', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
    ]
]);

echo $form->submit($model, $this);

ActiveForm::end();
