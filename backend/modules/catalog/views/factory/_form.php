<?php

use backend\widgets\Tabs;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Factory, FactoryLang
};

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

$visible = (in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])) ? true : false;

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
            'label' => Yii::t('app', 'Dealers'),
            'content' => $this->render('parts/_dealers', [
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
        [
            'label' => Yii::t('app', 'Условия работы'),
            'content' => $this->render('parts/_working_conditions', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => Yii::t('app', 'Представительство'),
            'content' => $this->render('parts/_subdivision', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => 'Редактор',
            'content' => $this->render('parts/_editors', [
                'model' => $model
            ])
        ],
        [
            'label' => 'Варианты отделки',
            'content' => $this->render('parts/_samples', [
                'model' => $model
            ])
        ],
    ]
]);

echo $form->submit($model, $this);

ActiveForm::end();
