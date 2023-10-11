<?php

namespace backend\app\bootstrap;

use Yii;
use yii\helpers\{
    Url, Html, ArrayHelper
};
//
use kartik\switchinput\SwitchInput;

/**
 * Class ActiveForm
 *
 * @package backend\app\bootstrap
 */
class ActiveForm extends \yii\bootstrap\ActiveForm
{
    public $fieldClass = ActiveField::class;

    public $enableClientValidation = true;
    public $enableAjaxValidation = false;
    public $validateOnSubmit = true;
    public $enableClientScript = true;

    public function init()
    {

        $this->action = Url::current();

        parent::init();
    }

    /**
     * @param array $models
     * @param null $attributes
     * @return array
     */
    public static function validateMultiple($models, $attributes = null)
    {
        $result = [];
        /** @var Model $model */
        foreach ($models as $model) {
            $model->validate($attributes);
            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;
            }
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
        return $this
            ->field($model, $attribute)
            ->placeholder(Html::encode($model->getAttributeLabel($attribute)))
            ->textInput($options);
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
     * @return $this
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

    /**
     * Form submit buttons
     *
     * @param $model
     * @param $view
     * @return string
     */
    public function cancel($model, $view)
    {
        $content = Html::beginTag('div', ['class' => 'row form-group', 'style' => ["margin-right" => '0px']]);
        $content .= Html::beginTag('div', [
            'class' => "text-right submit-panel-buttons",
        ]);

        $content .= Html::a(Yii::t('app', 'Cancel'), $view->context->actionListLinkStatus, ['class' => 'btn btn-danger']);
        $content .= Html::endTag('div');
        $content .= Html::endTag('div');

        return $content;
    }
}
