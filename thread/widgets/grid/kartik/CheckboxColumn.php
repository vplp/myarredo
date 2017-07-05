<?php

namespace thread\widgets\grid\kartik;

use Closure;
use yii\helpers\{
    Html, Url
};

/**
 * Class CheckboxColumn
 *
 * @package backend\components\grid\kartik
 * @author Daria Kharlan
 * @copyright (c) 2015, VipDesign
 */
class CheckboxColumn extends \kartik\grid\BooleanColumn
{

    /**
     * Renders a data cell.
     * @param mixed $model the data model being rendered
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data item among the item array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    public function renderDataCell($model, $key, $index)
    {
        if ($this->contentOptions instanceof Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }
        $icon = Html::a($this->renderDataCellContent($model, $key, $index), '#', [
            'class' => 'checkbox-button',
            'data' => [
                'action' => Url::toRoute([$this->attribute, 'id' => $key]),
            ],
            'onclick' => 'return false;'
        ]);

        Html::addCssStyle($options, 'text-align:center;');

        return Html::tag('td', $icon, $options);
    }

}
