<?php

namespace thread\widgets;

use Yii;
use yii\helpers\{
    Html, Url, ArrayHelper, Json
};
use yii\web\JsExpression;
//
use kartik\widgets\{
    DatePicker, FileInput, Select2 as kartikSelect2
};
use kartik\switchinput\SwitchInput;
//
use thread\app\base\models\ActiveRecord;
use thread\widgets\editors\Editor;

//TODO На удаление

/**
 * Class HtmlForm
 *
 * @package thread\app\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
final class HtmlForm
{
    /**
     * Повертає блок відображення помилки визначеного атрибута та моделі
     * @param ActiveRecord $model
     * @param string $attribute
     * @param array $options
     * @return Html tag
     */
    public static function errorBlock($model, $attribute, $options = [])
    {
        $options['id'] = Html::getInputId($model, $attribute) . '-error';
        $options['class'] = 'help-block help-block-error';
        return Html::error($model, $attribute, $options);
    }

    /**
     * Повертає блок відображення мітки визначеного атрибута та моделі
     * @param ActiveRecord $model
     * @param string $attribute
     * @return html tag
     */
    public static function labelBlock($model, $attribute, $options = [])
    {
        $options['id'] = Html::getInputId($model, $attribute) . '-label';
        $options['class'] = 'control-label';
        return Html::activeLabel($model, $attribute, $options);
    }

    /**
     * Текстове поле вводу
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public static function textInput($model, $attribute, $options = [])
    {
        ?>
        <div class="form-group field-<?= Html::getInputId($model, $attribute) ?>">
            <?= static::labelBlock($model, $attribute); ?>
            <?=
            Html::activeTextInput($model, $attribute, ArrayHelper::merge($options, [
                'placeholder' => Html::encode($model->getAttributeLabel($attribute)),
                'style' => 'width:100%',
                'class' => 'form-control',
            ])
            );
            ?>
            <?= static::errorBlock($model, $attribute); ?>
        </div>
        <?php
    }

    /**
     * Текстове поле вводу
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public static function passwordInput($model, $attribute)
    {
        ?>
        <div class="row form-group">
            <div class="col-sm-2">
                <?= static::labelBlock($model, $attribute); ?>
            </div>
            <div class="col-sm-10">
                <?=
                Html::activePasswordInput($model, $attribute, [
                    'placeholder' => Html::encode($model->getAttributeLabel($attribute)),
                    'style' => 'width:100%',
                    'class' => 'form-control']);
                ?>
                <?= static::errorBlock($model, $attribute); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Текстове поле вводу
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public static function textInputOptions($model, $attribute, $options = [])
    {
        ?>
        <div class="row form-group">
            <div class="col-sm-2">
                <?= static::labelBlock($model, $attribute); ?>
            </div>
            <div class="col-sm-10">
                <?=
                Html::activeTextInput($model, $attribute, ArrayHelper::merge([
                    'placeholder' => Html::encode($model->getAttributeLabel($attribute)),
                    'style' => 'width:100%',
                    'class' => 'form-control'], $options));
                ?>
                <?= static::errorBlock($model, $attribute); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Текстовий блок для вводу
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public static function textArea($model, $attribute, $options = [])
    {
        ?>
        <div class="row form-group">
            <div class="col-sm-2">
                <?= static::labelBlock($model, $attribute); ?>
            </div>
            <div class="col-sm-10">
                <?= Html::activeTextarea($model, $attribute, ArrayHelper::merge($options, [
                    'placeholder' => Html::encode($model->getAttributeLabel($attribute)),
                    'style' => 'width:100%',
                    'class' => 'form-control'
                ]));
                static::errorBlock($model, $attribute); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Випадаючий список
     * @param ActiveRecord $model
     * @param string $attribute
     * @param [id=>title] $datalist
     */
    public static function dropDownList($model, $attribute, $datalist)
    {
        ?>
        <div class="row form-group">
            <div class="col-sm-2">
                <?= static::labelBlock($model, $attribute); ?>
            </div>
            <div class="col-sm-10">
                <?= Html::activeDropDownList($model, $attribute, $datalist, ["style" => "width:100%", 'class' => 'form-control']); ?>
                <?= static::errorBlock($model, $attribute); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Поле вводу дати
     * @param ActiveRecord $model
     * @param string $attribute
     * @param string $value
     */
    public static function datePicker($model, $attribute, $value = '', $format = 'dd.mm.yyyy')
    {
        ?>
        <div class="row form-group">
            <div class="col-sm-4">
                <?= static::labelBlock($model, $attribute); ?>
            </div>
            <div class="col-sm-8">
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => $attribute,
                    'options' => ['value' => $value, 'placeholder' => $format],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => $format
                    ]
                ]); ?>
                <?= static::errorBlock($model, $attribute); ?>
            </div>
        </div>
        <?php
    }

    /**
     *
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public static function switcher($model, $attribute, $options = [])
    {
        ?>
        <div class="row form-group">
            <div class="col-sm-12">
                <?= static::labelBlock($model, $attribute, $options); ?>
                <?=
                SwitchInput::widget([
                    'model' => $model,
                    'attribute' => $attribute,
                ]);
                ?>
                <?= static::errorBlock($model, $attribute, $options); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Поле вводу редактору
     * @param ActiveRecord $model
     * @param string $attribute
     * @param string $thema
     */
    public static function editor($model, $attribute, $thema = '', $settings = [])
    {
        ?>
        <div class="row form-group">
            <div class="col-sm-12">
                <?= static::labelBlock($model, $attribute); ?>
                <?= static::errorBlock($model, $attribute); ?>
            </div>
            <div class="col-sm-12">
                <?=
                Editor::widget([
                    'model' => $model,
                    'attribute' => $attribute,
                    'thema' => $thema,
                    //'language' => Yii::$app->params['themes']['language'],
                    'settings' => $settings
                ]);
                ?>
            </div>
        </div>
        <?php
    }


    /**
     * Випадаючий список на базі http://ivaynberg.github.io/select2
     * оформлений віджетом
     * @param ActiveRecord $model
     * @param string $attribute
     * @param array $datalist [][ 'id' => id, 'text' => title ]
     * @param string $url
     * @param array $setting
     */
    public static function selected($model, $attribute, $datalist, $url = null, $setting = [])
    {
        $setting = ArrayHelper::merge([
            'width' => '100%',
            'ajax' => [
                'dataType' => 'json',
                'url' => $url,
                'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                'results' => new JsExpression('function(data) { return {results:data}; }'),
                'delay' => 250,
                'current' => new JsExpression('function(){ return ' . Json::encode($datalist) . ';}'),
            ],
            'initSelection' => new JsExpression('function (element,callback) {
                                 callback(' . new JsExpression(Json::encode($datalist)) . ');
                         }'),
            'multiple' => true,
            'minimumInputLength' => 3
        ], $setting);
        ?>
        <div class="row form-group">
            <div class="col-sm-2">
                <?= static::labelBlock($model, $attribute); ?>
            </div>
            <div class="col-sm-10">
                <?=
                Select2::widget([
                    'model' => $model,
                    'attribute' => $attribute,
                    'options' => [
                        'multiple' => true,
                        'placeholder' => 'Choose item',
                        'value' => '0',
                    ],
                    'settings' => $setting,
                    'items' => $datalist,
                ]);
                ?>
                <?= static::errorBlock($model, $attribute); ?>
            </div>
        </div>
        <?php
    }

    public static function showTextInput($model, $attribute)
    {
        ?>
        <div class="row form-group">
            <div class="col-sm-2">
                <?= static::labelBlock($model, $attribute); ?>
            </div>
            <div class="col-sm-10">
                <p class="form-control"> <?= $model->$attribute ?> </p>
            </div>
        </div>
        <?php
    }

    /**
     * Випадаючий список на базі http://ivaynberg.github.io/select2
     * оформлений віджетом
     *
     * @param array $setting
     * @throws \Exception
     * @internal param ActiveRecord $model
     * @internal param string $attribute
     * @internal param array $datalist [][ 'id' => id, 'text' => title ]
     * @internal param string $url
     */
    public static function selectedAjax($name, $setting = [])
    {
        $errorLoading = Yii::t('app', "Waiting for results...");
        $inputTooShort = Yii::t('app', "Please, enter ' + remainingChars + ' or more symbols");
        $inputTooLong = Yii::t('app', "Please delete ' + overChars + ' character");
        $loadingMore = Yii::t('app', "Loading more results...");
        $maxSelected = Yii::t('app', "You can only select ' + args.maximum + ' item");
        $noResults = Yii::t('app', "No results found");
        $searching = Yii::t('app', "Searching…");


        echo kartikSelect2::widget(
            ArrayHelper::merge($setting, [
                'name' => $name,
//            'value' => '11',          //Так задавать стандартное значение
//            'data' => ['11' => '11'], //
                'initValueText' => Yii::t('front', 'Country, city or resort name'),
                'options' =>
                    ['placeholder' => Yii::t('front', 'Country, city or resort name')],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () {
                                return '" . $errorLoading . "';
                            }"),
                        'inputTooShort' => new JsExpression("function (args) {
                                var remainingChars = args.minimum - args.input.length;
                                return '" . $inputTooShort . "';
                            }"),
                        'inputTooLong' => new JsExpression("function (args) {
                                var overChars = args.input.length - args.maximum;
                                return message = '" . $inputTooLong . "';
                            }"),
                        'loadingMore' => new JsExpression("function () {
                                return '" . $loadingMore . "';
                            }"),
                        'maximumSelected' => new JsExpression("function (args) {
                                var message = '" . $maxSelected . "';
                                return message;
                            }"),
                        'noResults' => new JsExpression("function () {
                                return '" . $noResults . "';
                            }"),
                        'searching' => new JsExpression("function () {
                                return '" . $searching . "';
                            }"),
                    ],
                    'ajax' => [
                        'url' => Url::to('filter/searchtitle'),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ])
        );
    }

    /**
     * Панель елементів кнопок відправки даних форми
     * @param ActiveRecord $model
     * @param View $view
     */
    public static function buttonPanel($model, $view)
    {
        ?>
        <?= Html::hiddenInput('save_and_exit'); ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add and Exit') : Yii::t('app', 'Save and Exit'), ['class' => 'btn btn-success action_save_and_exit']); ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Save'), ['class' => 'btn btn-info']); ?>
        <?= Html::a(Yii::t('app', 'Cancel'), [$view->context->actionListLinkStatus], ['class' => 'btn btn-danger']); ?>
        <?php
        $view->registerJs("$('.action_save_and_exit').click(function(){
            $('input[name=\"save_and_exit\"]').val(1);
        });");
    }

    /**
     * Панель елементів інпутів відправки даних форми
     * @param ActiveRecord $model
     * @param View $view
     */
    public static function inputPanel($model, $view)
    {
        ?>
        <?= Html::hiddenInput('save_and_exit'); ?>
        <?= Html::submitInput($model->isNewRecord ? Yii::t('app', 'action_add_and_exit') : Yii::t('app', 'action_save_and_exit'), ['class' => 'btn btn-info action_save_and_exit']); ?>
        <?= Html::submitInput($model->isNewRecord ? Yii::t('app', 'action_add') : Yii::t('app', 'action_save'), ['class' => 'btn btn-success']); ?>
        <?= Html::a(Yii::t('app', 'action_cancel'), [$view->context->actionListLinkStatus], ['class' => 'btn btn-primary']); ?>
        <?php
        $view->registerJs("$('.action_save_and_exit').click(function(){
        $('input[name=\"save_and_exit\"]').val(1);
//    return false;
    });");
    }

    /**
     * Форма завантаження декілька фото
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public static function imageSeveral($model, $attribute, $options = [], $pluginOptions = [])
    {
        $name = uniqid();
        $initImageConfig = [];
        $initImage = [];
        if (isset($options['initialPreview']) && !empty($options['initialPreview'])) {
            foreach ($options['initialPreview'] as $key => $image) {
                $initImage[] = Html::img($image, ['class' => 'file-preview-image']);
                $initImageConfig[] = "{
                        key: '" . basename($image) . "',
                        url: '" . Url::toRoute(['filedelete', 'id' => $model->id]) . "'
                    }";
            }
        }

        /*
         *
         * {
          caption: 'desert.jpg',
          width: '120px',
          url: 'http://localhost/avatar/delete', // server delete action
          key: 100,
          extra: {id: 100}
          },
         */
        ?>
        <div class="row form-group">
            <div class="col-sm-12">
                <?= static::labelBlock($model, $attribute); ?>
                <?= Html::activeHiddenInput($model, $attribute); ?>
                <?=
                FileInput::widget([
                    'name' => $name,
                    'options' => [
                        'multiple' => true,
                        'class' => 'file-loading',
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' =>
                        ArrayHelper::merge([
                            'uploadUrl' => Url::toRoute(['fileupload', 'input_file_name' => $name]),
                            'uploadExtraData' => [
                                '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                            ],
                            'deleteExtraData' => [
                                '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                            ],
                            'uploadAsync' => true,
                            'showUpload' => true,
                            'showRemove' => false,
                            'overwriteInitial' => false,
                            'initialPreview' => $initImage,
                            'initialPreviewConfig' => new JsExpression('[' . implode(',', $initImageConfig) . ']'),
                            'minFileCount' => 1,
                            'maxFileCount' => 2,
//                        'maxFileSize' => '134217728999'
                        ], $pluginOptions),
                    'pluginEvents' => [
                        'filebatchselected' => 'function(event, files) {
//                               this.fileinput("upload");
                        }',
                        'filebatchuploadsuccess' => 'function(event, data, previewId, index){
                                var response = data.response;
                                var val = $("input[name=\'' . Html::getInputName($model, $attribute) . '\']").val();
                                var aval = val.split(\',\');
                                    aval.push(response.name);
                                    console.log(val, aval);
                                $("input[name=\'' . Html::getInputName($model, $attribute) . '\']").val(aval.join(\',\'));
                        }',
                        'fileuploaded' => 'function(event, data, previewId, index){
                                var response = data.response;
                                var val = $("input[name=\'' . Html::getInputName($model, $attribute) . '\']").val();
                                var aval = val.split(\',\');
                                    aval.push(response.name);
                                    console.log(val, aval);
                                $("input[name=\'' . Html::getInputName($model, $attribute) . '\']").val(aval.join(\',\'));
                        }',
                        'filedeleted' => 'function(event, key){
                            console.log(key);
                         }',
                        'fileclear' => 'function(event){
                            $("input[name=\'' . Html::getInputName($model, $attribute) . '\']").val("");
//                            console.log("clear");
                        }',
                    ]
                ]);
                ?>
                <?= static::errorBlock($model, $attribute); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Форма завантаження однієї фото
     *
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public static function imageOne($model, $attribute, $extra = ['image_url' => ''])
    {
        $name = uniqid();

        $imagePreview = (isset($extra['image_url']) && !empty($extra['image_url'])) ?
            Html::img($extra['image_url'], ['class' => 'file-preview-image', 'style' => ['max-height' => '150px']]) : '';
        ?>
        <div class="row form-group">
            <div class="col-sm-12">
                <?= static::labelBlock($model, $attribute); ?>
                <?= Html::activeHiddenInput($model, $attribute); ?>
                <?=
                FileInput::widget([
                    'name' => $name,
                    'options' => [
                        'class' => 'file-loading',
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' => [
                        'uploadUrl' => Url::toRoute(['fileupload', 'input_file_name' => $name]),
                        'uploadExtraData' => [
                            '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                        ],
                        'uploadAsync' => false,
                        'showUpload' => false,
                        'showRemove' => false,
                        'overwriteInitial' => true,
                        'initialPreview' => $imagePreview,
                    ],
                    'pluginEvents' => [
                        'filebatchselected' => 'function(event, files) {
//                               this.fileinput("upload");
                        }',
                        'filebatchuploadsuccess' => 'function(event, data, previewId, index){
                                var response = data.response;
                                $("input[name=\'' . Html::getInputName($model, $attribute) . '\']").val(response.name);
                        }',
                        'fileuploaded' => 'function(event, data, previewId, index){
                                var response = data.response;
                                $("input[name=\'' . Html::getInputName($model, $attribute) . '\']").val(response.name);
                        }',
                        'fileclear' => 'function(event){
                            $("input[name=\'' . Html::getInputName($model, $attribute) . '\']").val("");
//                            console.log("clear");
                        }',
                    ]
                ]);
                ?>
                <?= static::errorBlock($model, $attribute); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Панель елементів інпутів відправки даних форми
     * @param $searchParamsModel
     * @internal param ActiveRecord $model
     * @internal param View $view
     */
    public static function setDatePicker($searchParamsModel)
    {

        echo DateRangePicker::widget([
            'name' => SearchParams::nameFullDate,
//            'startAttribute'=> $searchParamsModel->getParamDateFrom(),
//            'endAttribute'=> $searchParamsModel->getParamDateTo(),

            'value' => $searchParamsModel->getParamFullDate(),
            'convertFormat' => true,
            'options' => [
                'class' => 'form-control',
                'minRangeDays' => 7,
//                'placeholder' => 'Бла бла'
            ],

            'pluginOptions' => [
//                'id' => 'ndaterange',
                'minRangeDays' => 7,
                'minDate' => date('Y-m-d'),
                'placeholder' => 'Дата',
                'locale' => ['format' => Yii::$app->params['formatDateRangePicker']]
            ],

            'pluginEvents' => [

                "apply.daterangepicker" => "function(ev, picker) {
                                var statDate = new Date( picker.startDate.format('YYYY-MM-DD') ),
                                    endDate  = new Date( picker.endDate.format('YYYY-MM-DD')   ),
                                    dateDifference =  endDate.getTime() - statDate.getTime() ,
                                    remainsDate = new Date(dateDifference);

                                 var remainsFullDays = (parseInt(  parseInt(remainsDate / 1000) / (24 * 60 * 60)));

                                 if (remainsFullDays < 7) {
                                    var startDateFormat = picker.startDate.format('YYYY-MM-DD'),
                                        endDateFormat   = statDate.setDate(statDate.getDate() + 7),
                                        endDateFormat   = statDate.toISOString().substring(0, 10);

                                    picker.setEndDate(endDateFormat);
                                    $(this).val(startDateFormat + ' - ' + endDateFormat)
                                 }

                              }",
                "hide.daterangepicker" => "function(ev, picker) {
                                var statDate = new Date( picker.startDate.format('YYYY-MM-DD') ),
                                    endDate  = new Date( picker.endDate.format('YYYY-MM-DD')   ),
                                    dateDifference =  endDate.getTime() - statDate.getTime() ,
                                    remainsDate = new Date(dateDifference);

                                 var remainsFullDays = (parseInt(  parseInt(remainsDate / 1000) / (24 * 60 * 60)));

                                 if (remainsFullDays < 7) {

                                    var startDateFormat = picker.startDate.format('YYYY-MM-DD'),
                                        endDateFormat   = statDate.setDate(statDate.getDate() + 7),
                                        endDateFormat   = statDate.toISOString().substring(0, 10);

                                    picker.setEndDate(endDateFormat);
                                    $(this).val(startDateFormat + ' - ' + endDateFormat)
                                 }

                              }",
            ],
        ]);
        echo '<i class="fa-2 fa-calendar glyphicon glyphicon-calendar"></i>';

    }
}
