<?php

namespace backend\modules\catalog\widgets\grid;

use yii\helpers\Html;
use yii\grid\DataColumn;
use backend\modules\catalog\models\Specification;

/**
 * Class ManyToManySpecificationValueDataColumn
 *
 * @package backend\modules\catalog\widgets\grid
 */
class ManyToManySpecificationValueDataColumn extends DataColumn
{
    public $contentOptions = [
        'class' => 'text-center',
    ];

    public $headerOptions = [
        'class' => 'text-center'
    ];

    /**
     * Url to send AJAX request
     * @var string
     */
    //public $action = 'ajax-many-to-many';

    public $model = null;

    /**
     * namespace of class
     * @var
     */
    public $namespace;

    /** @var null Публичный ключь первой таблицы  (Из модели которая используетьсяв гриде ID ) */
    public $primaryKeyFirstTable = null;

    /** @var null значение ключа  первой таблицы */
    public $valueFirstTable = null;

    /** @var null Публичный ключь первой таблицы */
    public $primaryKeySecondTable = null;

    /** @var null значение ключа второй таблицы */
    public $valueSecondTable = null;

    /** @var array Дополнительные поля attribute (if нету этого значения счиатеться что модель удаляеться или создаеться) */
    public $additionalField = null;

    public $attributeRow;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->filter)) {
            $this->filter = \Yii::$app->formatter->booleanFormat;
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $model = ($this->model === null) ? $model : call_user_func($this->model, $model);

        $this->valueFirstTable = $model->id;

        $namespace = $this->namespace;

        $relationModel = $namespace::findBase()
            ->andWhere([
                $this->primaryKeyFirstTable => $model->id,
                $this->primaryKeySecondTable => $this->valueSecondTable
            ])
            ->one();

        $dataAttributes = [
            'class' => 'form-control i-checks',
        ];

        /* @var $model Specification */

        if ($model->parent_id == 0) {
            return null;
        } elseif ($model->type == 1) {
            return Html::input(
                'text',
                'SpecificationValue[' . $model->id . ']',
                (isset($relationModel)) ? $relationModel->{$this->attributeRow} : '',
                $dataAttributes
            );
        } else {
            return Html::checkbox(
                'SpecificationValue[' . $model->id . ']',
                (isset($relationModel)) ? $relationModel->{$this->attributeRow} : '',
                $dataAttributes
            );
        }
    }
}
