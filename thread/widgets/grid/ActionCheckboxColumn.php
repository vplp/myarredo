<?php
namespace thread\widgets\grid;

use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\helpers\{
    Html, Url
};
//
use thread\app\base\models\ActiveRecord;

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
            throw new InvalidConfigException(\Yii::t('app',
                    'You should set "action" attribute to "') . $this->attribute . '"');
        }
//        if (empty($this->filter)) {
//            $this->filter = \Yii::$app->formatter->booleanFormat;
//        }
    }

    /**
     * @inheritdoc
     */
    protected function renderFilterCellContent()
    {
        if (empty($this->filter)) {

            $model = $this->grid->filterModel;

            $this->filter = Html::activeDropDownList($model, $this->attribute, ActiveRecord::statusKeyRange(),
                ['class' => 'form-control', 'prompt' => '  ---  ']);
        }
        return parent::renderFilterCellContent();
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
