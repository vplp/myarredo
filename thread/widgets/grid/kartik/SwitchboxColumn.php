<?php

namespace thread\widgets\grid\kartik;

use yii\grid\CheckboxColumn;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\base\InvalidConfigException;
//
use kartik\switchinput\SwitchInput;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class SwitchboxColumn
 *
 * @package thread\app\components\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class SwitchboxColumn extends CheckboxColumn
{
    /**
     * @var bool
     */
    public $multiple = false;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $link = [];

    /**
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->attribute)) {
            throw new InvalidConfigException('The "name" property must be set.');
        }
    }

    /**
     * @param ActiveRecord $model
     * @return string
     */
    protected function getLink($model)
    {
        $attributes = [];
        if ($this->link) {
            foreach ($this->link as $attribute) {
                if (isset($model->$attribute)) {
                    $attributes[$attribute] = $model->$attribute;
                }
            }
        }

        return Url::toRoute(
            ArrayHelper::merge(
                [
                    $this->attribute,
                    'id' => $model->id,
                    $this->attribute => $model[$this->attribute]
                ],
                $attributes
            )
        );
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return SwitchInput::widget(
            [
                'name' => $this->attribute,
                'value' => $model[$this->attribute],
                'pluginEvents' => [
                    "switchChange.bootstrapSwitch" => "function(){ location.href='" . $this->getLink($model) . "' }",
                ],
            ]
        );
    }
}
