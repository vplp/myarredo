<?php
namespace thread\app\bootstrap;

use Yii;
use yii\helpers\{
    Html, Url
};
//
use kartik\widgets\{DatePicker, DateTimePicker, FileInput, ColorInput, Select2};
//
use thread\widgets\editors\Editor;

/**
 * Class ActiveField
 *
 * @package thread\app\bootstrap
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActiveField extends \yii\bootstrap\ActiveField
{
    /**
     * @param $sign
     * @return $this
     */
    public function sign($sign)
    {
        $this->inputTemplate = '<div class="input-group"><span class="input-group-addon">' . $sign . '</span>{input}</div>';
        return $this;
    }

    /**
     * @return $this|ActiveField
     */
    public function sign_lang()
    {
        return $this->sign(\Yii::$app->language);
    }

    /**
     * @param $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        $this->inputOptions['placeholder'] = $placeholder;
        return $this->textInput($this->inputOptions);
    }

    /**
     * @param $value
     * @return $this
     */
    public function value($value)
    {
        $this->inputOptions['value'] = $value;
        return $this->textInput($this->inputOptions);
    }

    /**
     * Field with WYSIWYG editor TinyMC
     * @return $this
     */
    public function editor($thema = 'full')
    {
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $this->parts['{input}'] = Editor::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'thema' => $thema
        ]);
        return $this;
    }

    /**
     * DatePicker form field widget
     *
     * @param $value
     * @param string $format
     * @return $this
     */
    public function datePicker($value, $format = 'dd.mm.yyyy')
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $this->parts['{input}'] = DatePicker::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => [
                'placeholder' => $format,
                'value' => $value,
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => $format
            ]
        ]);
        return $this;
    }

    /**
     * DateTimePicker form field widget
     *
     * @param $value
     * @param string $format
     * @return $this
     */
    public function dateTimePicker($value, $format = null)
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $this->parts['{input}'] = DateTimePicker::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => [
                'placeholder' => $format,
                'value' => $value,
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => $format
            ]
        ]);
        return $this;
    }

    /**
     * Image upload widget field
     *
     * @param string $preview image url
     * @return $this
     */
    public function imageOne($preview = '')
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $name = uniqid();
        $imagePreview = '';
        if (!empty($preview)) {
            $imagePreview = Html::img($preview, [
                'class' => 'file-preview-image',
                'style' => ['max-height' => '200px', 'max-width' => '200px']
            ]);
        }
        $inputName = Html::getInputName($this->model, $this->attribute);
        $this->parts['{input}'] = Html::activeHiddenInput($this->model, $this->attribute);
        $this->parts['{input}'] .= FileInput::widget([
            'language' => Yii::$app->params['themes']['language'],
            'name' => $name,
            'options' => [
                'class' => 'file-loading',
                'accept' => '.jpg,.jpeg,.png'
            ],
            'pluginOptions' => [
                'uploadUrl' => Url::toRoute(['fileupload', 'input_file_name' => $name, 'model_id' => $this->model->id]),
                'uploadExtraData' => [
                    '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                ],
                'browseClass' => 'btn btn-success',
                'uploadClass' => 'btn btn-info',
                'removeClass' => 'btn btn-danger',
                'uploadAsync' => true,
                'showUpload' => true,
                'showRemove' => true,
                'overwriteInitial' => true,
                'initialPreview' => $imagePreview,
                'browseOnZoneClick' => true,
                'maxFileSize' => 2048
            ],
            'pluginEvents' => [
                'filebatchselected' => 'function(event, files) {
                }',
                'filebatchuploadsuccess' => 'function(event, data, previewId, index){
                    var response = data.response;
                    $("input[name=\'' . $inputName . '\']").val(response.name);
                }',
                'fileuploaded' => 'function(event, data, previewId, index){
                    var response = data.response;
                    $("input[name=\'' . $inputName . '\']").val(response.name);
                }',
                'fileclear' => 'function(event){
                    $("input[name=\'' . $inputName . '\']").val("");
                }',
            ]
        ]);
        return $this;
    }

    /**
     * @return $this
     */
    public function colorPicker()
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $this->parts['{input}'] = ColorInput::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => [
                'placeholder' => Yii::t('app', 'Choose your color'),
            ],
        ]);
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function selectOne(array $data)
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $this->parts['{input}'] = Select2::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'data' => $data,
            'options' => [
                'placeholder' => Yii::t('app', 'Choose'),
            ],
        ]);
        return $this;
    }
}
