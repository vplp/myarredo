<?php
namespace backend\widgets\forms;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class ActiveForm extends \yii\bootstrap\ActiveForm
{
    /**
     * Class using for fields
     * @var string
     */
    public $fieldClass = Form::class;

    /**
     * @inheritdoc
     * @return Form the created ActiveField object
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }
}
