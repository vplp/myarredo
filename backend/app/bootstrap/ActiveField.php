<?php

namespace backend\app\bootstrap;

use Yii;
use yii\helpers\{
    ArrayHelper, Html, Url
};
use yii\web\JsExpression;
use kartik\file\FileInput;

/**
 * Class ActiveField
 *
 * @package backend\app\bootstrap
 */
class ActiveField extends \thread\app\bootstrap\ActiveField
{
    /**
     * @param string $preview
     * @return $this|\thread\app\bootstrap\ActiveField
     * @throws \Exception
     */
    public function imageOne($preview = '')
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();

        $name = uniqid();

        $initImageConfig = "{  
                    name: '" . basename($preview) . "',
                    key: '" . $preview . "',
                    url: '" . Url::toRoute(['filedelete', 'id' => $this->model->id]) . "'
                }";
        $inputName = Html::getInputName($this->model, $this->attribute);
        $this->parts['{input}'] = Html::activeHiddenInput($this->model, $this->attribute);
        $this->parts['{input}'] .= FileInput::widget([
            'name' => $name,
            'options' => [
                'accept' => '.jpeg,.png'
            ],
            'pluginOptions' => [
                'uploadUrl' => Url::toRoute(['fileupload', 'input_file_name' => $name, 'id' => $this->model->id]),
                'uploadExtraData' => [
                    '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                ],
                'deleteExtraData' => [
                    '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                ],
                'uploadAsync' => true,
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'overwriteInitial' => false,
                'initialPreview' => [$preview],
                'initialPreviewConfig' => new JsExpression('[' . $initImageConfig . ']'),
                'initialPreviewAsData' => true,
                'autoReplace' => true,
                'maxFileCount' => 1,
                'append' => true,
            ],
            'pluginEvents' => [
                'filebatchselected' => 'function(event, files) {
                    $(this).fileinput("upload"); 
                }',
                'filebatchuploadsuccess' => 'function(event, data, previewId, index){
                    var response = data.response;
                    $("input[name=\'' . $inputName . '\']").val(response.name);
                }',
                'fileuploaded' => 'function(event, data, previewId, index){
                    var response = data.response;
                    $("input[name=\'' . $inputName . '\']").val(response.name);
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
            foreach ($options['initialPreview'] as $key => $image) {
                $initImage[] = $image;
                $initImageConfig[] = "{
                    name: '" . basename($image) . "',
                    key: '" . $image . "',
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
                'accept' => '.jpeg,.png'
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
                'showUpload' => false,
                'showCaption' => false,
                'showRemove' => false,
                'overwriteInitial' => true,
                'initialPreview' => $initImage,
                'initialPreviewConfig' => new JsExpression('[' . implode(',', $initImageConfig) . ']'),
                'initialPreviewAsData' => true,
                'minFileCount' => $options['minFileCount'] ?? 1,
                'maxFileCount' => $options['maxFileCount'] ?? 10,
            ], $pluginOptions),
            'pluginEvents' => [
                'filebatchselected' => 'function(event, files) {           
                    $(this).fileinput("upload");                            
                }',
                'filebatchuploadsuccess' => 'function(event, data, previewId, index) {
                    var response = data.response;
                    var val = $("input[name=\'' . $inputName . '\']").val();
                    var aval = val.split(\',\');
                        aval.push(response.name);
                        console.log(val, aval);
                    $("input[name=\'' . $inputName . '\']").val(aval.join(\',\'));
                }',
                'fileuploaded' => 'function(event, data, previewId, index) {
                    var response = data.response;
                    var val = $("input[name=\'' . $inputName . '\']").val();
                    var aval = val.split(\',\');
                        aval.push(response.name);
                        console.log(val, aval);
                    $("input[name=\'' . $inputName . '\']").val(aval.join(\',\'));
                }',
                'filedeleted' => 'function(event, key) {
                    console.log(key);
                 }',
                'fileclear' => 'function(event) {
                    $("input[name=\'' . $inputName . '\']").val("");
                }',
            ]
        ]);
        return $this;
    }

    /**
     * @param string $preview
     * @param array $options
     * @param array $pluginOptions
     * @return $this
     * @throws \Exception
     */
    public function fileInputWidget($preview = '', $options = [], $pluginOptions = [])
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();

        $name = uniqid();

        $initialPreviewConfig = "{  
                    key: '" . basename($preview) . "',
                    filename: '" . basename($preview) . "',
                    caption: '" . basename($preview) . "',
                    size: " . filesize(Yii::getAlias('@frontend-web') . $preview) . ",
                    url: '" . Url::toRoute(['one-file-delete', 'id' => $this->model->id]) . "'
                }";

        $inputName = Html::getInputName($this->model, $this->attribute);
        $this->parts['{input}'] = Html::activeHiddenInput($this->model, $this->attribute);
        $this->parts['{input}'] .= FileInput::widget([
            'name' => $name,
            'options' => ArrayHelper::merge([], $options),
            'pluginOptions' => ArrayHelper::merge([
                'uploadUrl' => Url::toRoute(['one-file-upload', 'input_file_name' => $name]),
                'uploadExtraData' => [
                    '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                ],
                'deleteExtraData' => [
                    '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                ],
                'uploadAsync' => true,
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'overwriteInitial' => false,
                'initialPreview' => [$preview],
                'initialPreviewConfig' => new JsExpression('[' . $initialPreviewConfig . ']'),
                'preferIconicPreview' => true,
                'previewFileIconSettings' => [
                    'doc' => '<i class="fa fa-file-word-o text-primary"></i>',
                    'xls' => '<i class="fa fa-file-excel-o text-success"></i>',
                    'ppt' => '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                    'pdf' => '<i class="fa fa-file-pdf-o text-danger"></i>',
                    'zip' => '<i class="fa fa-file-archive-o text-muted"></i>',
                    'htm' => '<i class="fa fa-file-code-o text-info"></i>',
                    'txt' => '<i class="fa fa-file-text-o text-info"></i>',
                    'mov' => '<i class="fa fa-file-movie-o text-warning"></i>',
                    'mp3' => '<i class="fa fa-file-audio-o text-warning"></i>',
                    'jpg' => '<i class="fa fa-file-photo-o text-danger"></i>',
                    'gif' => '<i class="fa fa-file-photo-o text-muted"></i>',
                    'png' => '<i class="fa fa-file-photo-o text-primary"></i>'
                ],
                'autoReplace' => true,
                'maxFileCount' => 1,
                'append' => true,
                'maxFileSize' => 200000000
            ], $pluginOptions),
            'pluginEvents' => [
                'filebatchselected' => 'function(event, files) {
                     $(this).fileinput("upload"); 
                }',
                'filebatchuploadsuccess' => 'function(event, data, previewId, index){
                    var response = data.response;
                    $("input[name=\'' . $inputName . '\']").val(response.name);
                }',
                'fileuploaded' => 'function(event, data, previewId, index){
                    var response = data.response;
                    $("input[name=\'' . $inputName . '\']").val(response.name);
                }',
            ]
        ]);
        return $this;
    }
}
