<?php

namespace thread\app\bootstrap;

use Yii;
use yii\helpers\{
    Url, Html, ArrayHelper
};
use yii\web\JsExpression;
//
use kartik\switchinput\SwitchInput;

/**
 * Class ActiveForm
 *
 * @package thread\app\bootstrap
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActiveForm extends \yii\bootstrap\ActiveForm
{
    public $fieldClass = ActiveField::class;
    //
    public $enableClientValidation = true;
    public $enableAjaxValidation = true;
    public $validateOnSubmit = true;
    public $enableClientScript = true;
    public $validationUrl = 'validation';

    public function init()
    {

        $this->action = Url::current();

        parent::init();

        $this->validationUrl = Url::toRoute($this->validationUrl) . '?id=' . ((isset($_GET['id'])) ? $_GET['id'] : 0);
        $view = $this->getView();
        $view->registerJs($this->setSubmit());
    }

    public function setSubmit()
    {
        return new JsExpression('$("#' . $this->getId() . ' button[type=submit]").on( "click", function() {
            var formId = "#' . $this->getId() . '";
            var url = "' . $this->validationUrl . '";
            var is_valid = false;

            if(url.length){
                var dataForm = $(formId).serialize();

                $.post(url, dataForm, function(data){
                    var obj = data;
                    var classExtError = ".help-block-error";

                    console.log(obj);

                    if(data.length == 0){
                        is_valid = true;
                        $(formId).submit();
                    }

                    for(attr in obj){
                        $("#"+attr).parents(".form-group").addClass("has-error");
                        $("#"+attr).parents(".form-group").find(classExtError).html(obj[attr]);
                    }

                });

            }

            return is_valid;
        });');
    }

    /**
     *
     * @param type $models
     * @param type $attributes
     * @return array
     */
    public static function validateMultiple($models, $attributes = null)
    {
        $result = [];
        /** @var Model $model */
        foreach ($models as $model) {
            $model->validate($attributes);
            foreach ($model->getErrors() as $attribute => $errors)
                $result[Html::getInputId($model, $attribute)] = $errors;
        }

        return $result;
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $options
     * @return mixed
     */
    public function text_line($model, $attribute, $options = [])
    {
        return $this->field($model, $attribute, $options)->placeholder(Html::encode($model->getAttributeLabel($attribute)))->textInput(['maxlength' => true]);
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $options
     * @return mixed
     */
    public function text_line_lang($model, $attribute, $options = [])
    {
        return $this->text_line($model, $attribute, $options)->sign_lang();
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $options
     * @return mixed
     */
    public function text_password($model, $attribute, $options = [])
    {
        return $this->field($model, $attribute, $options)->passwordInput();
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $options
     * @return mixed
     */
    public function text_editor($model, $attribute, $options = [])
    {
        return $this->field($model, $attribute, $options)->editor();
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $options
     * @param string $thema
     * @return mixed
     */
    public function text_editor_lang($model, $attribute, $options = [], $thema = 'full')
    {

        $template = [
            'template' => '<div class="input-group" style="text-align: left;">{label}<span class="input-group-addon" style="display: inline;">' . Yii::$app->language . '</span></div>{input}{error}{hint}'
        ];

        return $this->field($model, $attribute, ArrayHelper::merge($template, $options))->editor($thema);
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $options
     * @return $this
     */
    public function checkbox($model, $attribute, $options = [])
    {
        return $this->field($model, $attribute, $options)->checkbox();
    }

    /**
     * @param $model
     * @param $attribute
     * @param array $options
     * @return $this
     */
    public function switcher($model, $attribute, $options = [])
    {
        return $this->field($model, $attribute, $options)->widget(SwitchInput::classname(), []);
    }

    /**
     * Form submit buttons
     *
     * @param $model
     * @param $view
     * @return string
     */
    public function submit($model, $view)
    {
        $view->registerJs("$('.action_save_and_exit').click(function(){
        $('input[name=\"save_and_exit\"]').val(1);
//    return false;
    });");

        $content = Html::beginTag('div', ['class' => 'row form-group', 'style' => ["margin-right" => '0px']]);
        $content .= Html::beginTag('div', [
            'class' => "text-right submit-panel-buttons",
        ]);

        $content .= Html::hiddenInput('save_and_exit');
        $content .= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add and Exit') : Yii::t('app', 'Save and Exit'), ['class' => 'btn btn-success action_save_and_exit']);
        $content .= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Save'), ['class' => 'btn btn-info']);
        $content .= Html::a(Yii::t('app', 'Cancel'), $view->context->actionListLinkStatus, ['class' => 'btn btn-danger']);
        $content .= Html::endTag('div');
        $content .= Html::endTag('div');
        return $content;
    }
}