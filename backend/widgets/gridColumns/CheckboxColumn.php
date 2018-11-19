<?php
namespace backend\widgets\gridColumns;

use yii\helpers\{
    ArrayHelper, Html, Json
};

/**
 * Class CheckboxColumn
 * @package backend\widgets\gridColumns
 */
class CheckboxColumn extends \yii\grid\CheckboxColumn
{

    public $name = 'input';

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->checkboxOptions instanceof \Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
        } else {
            $options = $this->checkboxOptions;
        }

        if (!isset($options['value'])) {
            $options['value'] = is_array($key) ? Json::encode($key) : $key;
        }

        $checkbox = Html::beginTag('div', ['class' => 'icheckbox_square-green', 'style' => ['position' => 'relative']]);
        $checkbox .= Html::checkbox($this->name, !empty($options['checked']),
            ArrayHelper::merge(['class' => 'i-checks', 'style' => ['position' => 'absolute', 'opacity' => 0]],
                $options));
        $checkbox .= Html::tag('ins', '', [
            'class' => 'iCheck-helper',
            'style' => [
                'position' => 'absolute',
                'top' => '0%',
                'left' => '0%',
                'display' => 'block',
                'width' => '100%',
                'height' => '100%',
                'margin' => '0px',
                'padding' => '0px',
                'border' => '0px',
                'opacity' => 0,
                'background' => 'rgb(255, 255, 255)'
            ]
        ]);
        $checkbox .= Html::endTag('div');
        return $checkbox;
    }
}
