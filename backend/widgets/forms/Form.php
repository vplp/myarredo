<?php

namespace backend\widgets\forms;

use Yii;
use yii\helpers\{
    ArrayHelper, Html, Url
};
use yii\web\JsExpression;

//
use thread\widgets\editors\Editor;

//
use kartik\switchinput\SwitchInput;
use kartik\widgets\{
    DatePicker, FileInput
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class Form extends \yii\bootstrap\ActiveField
{

    /**
     * Checkbox custom tamplate
     * @var string
     */
    public $checkboxTemplate = "<div class=\"i-checks\">\n{beginLabel}\n<div class='icheckbox_square-green'>{input}</div>\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>";

    /**
     * Field with WYSIWYG editor TinyMC
     * @return $this
     */
    public function editor()
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $this->parts['{input}'] = Editor::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'thema' => 'full'
        ]);
        return $this;
    }

    /**
     * Kartick switcher
     * @return $this
     */
    public function switcher($options = [])
    {
        return $this->widget(SwitchInput::class, ArrayHelper::merge($options, []));
    }

    /**
     * Custom checkbox
     *
     * @param array $options
     * @param bool $enclosedByLabel
     * @return $this
     */
    public function checkbox($options = [], $enclosedByLabel = true)
    {
        parent::checkbox($options, false);
        $options['style'] = 'position: absolute; opacity: 0;';
        if ($enclosedByLabel) {
            if (!isset($options['template'])) {
                $this->template = $this->form->layout === 'horizontal' ?
                    $this->horizontalCheckboxTemplate : $this->checkboxTemplate;
            } else {
                $this->template = $options['template'];
                unset($options['template']);
            }
            if (isset($options['label'])) {
                $this->parts['{labelTitle}'] = $options['label'];
            }
            if ($this->form->layout === 'horizontal') {
                Html::addCssClass($this->wrapperOptions, $this->horizontalCssClasses['offset']);
            }
            $this->labelOptions['class'] = null;
        }
        return $this;
    }

    /**
     * Form submit buttons
     *
     * @param $model
     * @param $view
     * @param string $position
     * @return string
     */
    public static function submit($model, $view, $position = 'right')
    {
        $content = Html::beginTag('div', ['class' => 'row form-group', 'style' => ["margin-$position" => '0px']]);
        $content .= Html::beginTag('div', [
            'class' => "text-$position submit-panel-buttons",
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
     * @param string $preview
     * @return $this
     * @throws \Exception
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
                'style' => ['max-height' => '150px']
            ]);
        }
        $inputName = Html::getInputName($this->model, $this->attribute);
        $this->parts['{input}'] = Html::activeHiddenInput($this->model, $this->attribute);
        $this->parts['{input}'] .= FileInput::widget([
            'name' => $name,
            'options' => [
                'class' => 'file-loading',
                'accept' => '.jpg,.jpeg,.png'
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
                'filebatchselected' => 'function(event, files) {}',
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
     * @param array $options
     * @param array $pluginOptions
     * @return $this
     * @throws \Exception
     */
    public function imageSeveral($options = [], $pluginOptions = [])
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $name = uniqid();
        $initImageConfig = [];
        $initImage = [];
        if (isset($options['initialPreview']) && !empty($options['initialPreview'])) {
            foreach ($options['initialPreview'] as $image) {
                $initImage[] = Html::img($image, [
                    'class' => 'file-preview-image',
                    'style' => ['max-height' => '150px']
                ]);
                $initImageConfig[] = "{
                    key: '" . basename($image) . "',
                    url: '" . Url::toRoute(['filedelete', 'id' => $this->model->id]) . "'
                }";
            }
        }
        $inputName = Html::getInputName($this->model, $this->attribute);
        $this->parts['{input}'] = Html::activeHiddenInput($this->model, $this->attribute);
        $this->parts['{input}'] .= FileInput::widget([
            'name' => $name,
            'options' => [
                'multiple' => true,
                'class' => 'file-loading',
                'accept' => '.jpg,.jpeg,.png'
            ],
            'pluginOptions' => ArrayHelper::merge([
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
                'minFileCount' => $options['minFileCount'] ?? 1,
                'maxFileCount' => $options['maxFileCount'] ?? 10,
//                        'maxFileSize' => '134217728999'
            ], $pluginOptions),
            'pluginEvents' => [
                'filebatchselected' => 'function(event, files) {
                }',
                'filebatchuploadsuccess' => 'function(event, data, previewId, index){
                        var response = data.response;
                        var val = $("input[name=\'' . $inputName . '\']").val();
                        var aval = val.split(\',\');
                            aval.push(response.name);
                            console.log(val, aval);
                        $("input[name=\'' . $inputName . '\']").val(aval.join(\',\'));
                }',
                'fileuploaded' => 'function(event, data, previewId, index){
                        var response = data.response;
                        var val = $("input[name=\'' . $inputName . '\']").val();
                        var aval = val.split(\',\');
                            aval.push(response.name);
                            console.log(val, aval);
                        $("input[name=\'' . $inputName . '\']").val(aval.join(\',\'));
                }',
                'filedeleted' => 'function(event, key){
                    console.log(key);
                 }',
                'fileclear' => 'function(event){
                    $("input[name=\'' . $inputName . '\']").val("");
                }',
            ]
        ]);
        return $this;
    }

    /**
     * @param $value
     * @param string $format
     * @return $this
     * @throws \Exception
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
}
