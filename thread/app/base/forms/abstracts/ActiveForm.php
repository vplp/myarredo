<?php
namespace thread\app\base\forms\abstracts;

use yii\base\Model;
use yii\helpers\{
    Html, Url
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
abstract class ActiveForm extends \yii\bootstrap\ActiveForm
{

    public $enableClientValidation = true;
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->action = Url::current();
    }

    /**
     * @inheritdoc
     * @return ActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }

    /**
     *
     * @param Model[] $models
     * @param Model[] $attributes
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
}
