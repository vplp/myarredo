<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category, Factory, Types
};

/**
 * @var \frontend\modules\catalog\models\Sale $model
 * @var \frontend\modules\catalog\models\SaleLang $modelLang
 */

$this->title = 'Добавить товар в распродажу';

?>

<main>
    <div class="page create-sale">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="column-center">
                <div class="form-horizontal">

                    <?php $form = ActiveForm::begin([
                        //'action' => Url::toRoute(['/catalog/sale/' . Yii::$app->controller->action->id]),
                        'fieldConfig' => [
                            'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
                            'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
                        ],
                    ]); ?>

                    <?php if ($model->isNewRecord): ?>
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            Для загрузки изображений - сначала создайте товар
                        </div>
                    <?php else: ?>
                        df
                    <?php endif; ?>

                    <?= $form->field($modelLang, 'title') ?>
                    <?= $form->field($model, 'alias') ?>

                    <?= $form
                        ->field($model, 'category_ids')
                        ->widget(Select2::classname(), [
                            'data' => Category::dropDownList(),
                            'options' => [
                                'placeholder' => Yii::t('app', 'Select option'),
                                'multiple' => true
                            ],
                        ]) ?>

                    <?= $form
                        ->field($model, 'catalog_type_id')
                        ->widget(Select2::classname(), [
                            'data' => Types::dropDownList(),
                            'options' => ['placeholder' => Yii::t('app', 'Select option')],
                        ]) ?>

                    <?= $form
                        ->field($model, 'factory_id')
                        ->widget(Select2::classname(), [
                            'data' => Factory::dropDownList(),
                            'options' => ['placeholder' => Yii::t('app', 'Select option')],
                        ]) ?>

                    <?= $form->field($model, 'factory_name') ?>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Стиль</label>
                        <div class="col-sm-9">
                            <div class="dropdown arr-drop">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                    Выберите вариант
                                </button>
                                <ul class="dropdown-menu drop-down-find">
                                    <li>
                                        <input type="text" class="find">
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Арт деко, гламур</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Барокко, Рококо</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Классический</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Материал</label>
                        <div class="col-sm-9">
                            <div class="dropdown arr-drop">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                    Выберите вариант
                                </button>
                                <ul class="dropdown-menu drop-down-find">
                                    <li>
                                        <input type="text" class="find">
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Гранит</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">ДСП</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Замша</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?= $form->field($modelLang, 'description')->textarea() ?>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Длина</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Глубина</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Высота</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Диаметр</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Внутренняя длина</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Внутренняя глубина</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Обьем</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <?= $form
                        ->field(
                            $model,
                            'price',
                            ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
                        ) ?>

                    <div class="form-group row price-row">
                        <?= $form
                            ->field(
                                $model,
                                'price_new',
                                [
                                    'template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}",
                                    'options' => [
                                        'class' => '',
                                    ]
                                ]
                            ) ?>

                        <?= $form
                            ->field(
                                $model,
                                'currency',
                                [
                                    'template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}",
                                    'options' => [
                                        'class' => '',
                                    ]
                                ]
                            )
                            ->dropDownList($model::currencyRange())
                            ->label(false) ?>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Статус</label>

                        <div class="col-sm-9">
                            <div class="checkbox checkbox-primary">
                                <?= $form
                                    ->field(
                                        $model,
                                        'published',
                                        [
                                            'template' => '{input}{label}{error}{hint}',
                                            'options' => [
                                                'class' => '',
                                            ]
                                        ]
                                    )
                                    ->checkbox([], false)
                                    ->label() ?>
                            </div>
                        </div>
                    </div>

                    <div class="buttons-cont">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary btn-lg']) ?>
                        <?= Html::a(Yii::t('app', 'Cancel'), ['/catalog/sale/partner-list'], ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</main>