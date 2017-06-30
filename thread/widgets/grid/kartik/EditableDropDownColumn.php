<?php

namespace thread\widgets\grid\kartik;

use Yii;
use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\helpers\{
    Url
};
//
use kartik\editable\Editable;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class EditableDropDownColumn
 *
 * @package thread\widgets\grid\kartik
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class EditableDropDownColumn extends DataColumn
{

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $link = ['attribute-save'];

    /**
     * @var array
     */
    public $data = [];

    /**
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
     * @param $model
     * @return array|mixed|string
     */
    protected function getLink($model)
    {
        /**
         * @var $model ActiveRecord
         */
        if (!empty($this->link)) {
            if ($this->link instanceof \Closure) {
                $f = $this->link;
                return $f($model);
            } else {
                $r = ['update'];
                foreach ($this->link as $data) {
                    $r[$data] = $model->$data;
                }
                return $r;
            }
        } else {
            return $this->link;
        }
    }

    /**
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return mixed
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        /**
         * @var $model ActiveRecord
         */
        $attribute = $this->attribute;

        return Editable::widget([
            'name' => $attribute . '[' . $model['id'] . ']',
            'id' => $attribute . uniqid(),
            'value' => $model[$attribute],
            'inputType' => Editable::INPUT_DROPDOWN_LIST,
            'data' => $this->data??[],
            'asPopover' => false,
            'header' => $model->getAttributeLabel($attribute),
            'size' => 'xs',
            'formOptions' => [
                'action' => Url::toRoute($this->link),
            ],
            'options' => [
                'class' => 'form-control',
            ],
            'buttonsTemplate' => '<span style="float: right;">{submit}</span>'
        ]);
    }

}
