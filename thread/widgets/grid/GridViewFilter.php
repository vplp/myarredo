<?php
namespace thread\widgets\grid;

use Yii;
use yii\helpers\Html;
use kartik\widgets\{
    DatePicker, Select2
};
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;

/**
 * Class GridViewFilter
 *
 * @package thread\app\bootstrap
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class GridViewFilter
{
    /**
     * @param BaseBackendSearchModel $model
     * @param $attribute
     * @param array $list
     * @return string
     */
    public static function dropDownList(BaseBackendSearchModel $model, $attribute, array $list)
    {
        return Html::activeDropDownList($model, $attribute, $list,
            ['class' => 'form-control', 'prompt' => '  ---  ']);
    }

    /**
     * @param BaseBackendSearchModel $model
     * @param $attribute
     * @param array $list
     * @return mixed
     */
    public static function selectOne(BaseBackendSearchModel $model, $attribute, array $list)
    {
        return Select2::widget([
            'model' => $model,
            'attribute' => $attribute,
            'data' => $list,
            'options' => [
                'placeholder' => Yii::t('app', 'Choose'),
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }

    /**
     * @param BaseBackendSearchModel $model
     * @param $attribute_from
     * @param $attribute_to
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function datePickerRange(BaseBackendSearchModel $model, $attribute_from, $attribute_to, $format = 'dd.mm.yyyy')
    {
        return DatePicker::widget([
            'model' => $model,
            'attribute' => $attribute_from,
            'attribute2' => $attribute_to,
            'options' => ['placeholder' => Yii::t('app', 'Start date')],
            'options2' => ['placeholder' => Yii::t('app', 'End date')],
            'type' => DatePicker::TYPE_RANGE,
            'pluginOptions' => [
                'format' => $format,
                'autoclose' => true,
            ]
        ]);
    }
}
