<?php
namespace thread\widgets\grid;

use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class CheckboxActionColumn
 */
class ActionCheckboxColumn extends DataColumn
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
    public $action;

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
        $dataAttributes = [
            'class' => 'ajax-switcher i-checks',
            'data' => [
                'id' => $model->id,
                'url' => Url::toRoute([$this->action]),
            ],
        ];
        /** @var \yii\db\ActiveRecord $model */
        return Html::checkbox(null, (int)$model->{$this->attribute}, $dataAttributes);
    }
}
