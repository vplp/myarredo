<?php
namespace thread\widgets\grid;

use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class CheckboxActionColumn
 */
class AjaxManyToManyCheckboxColumn extends DataColumn
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
    public $action = 'ajax-many-to-many';

    public $model = null;


    /**
     *  namespace of class
     * @var
     */
    public $namespace;

    /** @var null Публичный ключь первой таблицы  (Из модели которая используетьсяв гриде ID )*/
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
        if (!$this->action) {
            throw new InvalidConfigException(\Yii::t('app', 'You should set "action" attribute to "') . $this->attribute . '"');
        }
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
            ->andWhere([$this->primaryKeyFirstTable => $model->id, $this->primaryKeySecondTable => $this->valueSecondTable])
            ->one();

        $dataAttributes = [
            'class' => 'ajax-many-to-many i-checks',
            'data' => [
                'id' => (isset($model->id)) ? $model->id : null,
                'url' => Url::toRoute([$this->action]),
                'namespace' => $this->namespace,
                'primary-key-first-table' => $this->primaryKeyFirstTable,
                'value-first-table' => $this->valueFirstTable,
                'primary-key-second-table' => $this->primaryKeySecondTable,
                'value-second-table' => $this->valueSecondTable,
                'additional-fields' => $this->additionalField
            ],
//            'disabled' => (isset($model->id)) ? false : true
        ];
//        echo '<pre style="color:red">'; print_r($dataAttributes); echo '<pre>'; die();
        /** @var \yii\db\ActiveRecord $model */


        if ($relationModel && $this->attributeRow !== null) {
            return Html::checkbox(null, (isset($relationModel)) ? $relationModel->{$this->attributeRow} : '', $dataAttributes);
        }

        return Html::checkbox(null, (isset($relationModel)) ? true : '', $dataAttributes);
    }

}