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
 * Class ActionStatusColumn
 *
 * @package thread\widgets\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActionStatusColumn extends DataColumn
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
     * @var array
     */
    public $statusLabel = [
        ActiveRecord::STATUS_KEY_OFF => 'Off',
        ActiveRecord::STATUS_KEY_ON => 'Published',
    ];
    /**
     * @var array
     */
    protected $statusCssClass = [
        ActiveRecord::STATUS_KEY_OFF => 'label-danger',
        ActiveRecord::STATUS_KEY_ON => 'label-primary',
    ];

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
        $show = $model[$this->attribute] == ActiveRecord::STATUS_KEY_ON ? 'inline' : 'none';

        $dataAttributesCheck = [
            'class' => 'ajax-status-switcher i-checks label ' . $this->statusCssClass[ActiveRecord::STATUS_KEY_ON],
            'style' => 'padding:5px 10px 5px 10px; cursor:pointer; display:' . $show,
            'data' => [
                'id' => $model->id,
                'url' => Url::toRoute([$this->action]),
            ],
        ];

        $show = $show == 'inline' ? 'none' : 'inline';

        $dataAttributesUnCheck = [
            'class' => 'ajax-status-switcher i-unchecks label ' . $this->statusCssClass[ActiveRecord::STATUS_KEY_OFF],
            'style' => 'padding:5px 10px 5px 10px; cursor:pointer; display:' . $show,
            'data' => [
                'id' => $model->id,
                'url' => Url::toRoute([$this->action]),
            ],
        ];

        /** @var \yii\db\ActiveRecord $model */
        return Html::tag('span', $this->statusLabel[ActiveRecord::STATUS_KEY_ON], $dataAttributesCheck) . Html::tag('span', $this->statusLabel[ActiveRecord::STATUS_KEY_OFF], $dataAttributesUnCheck);
    }
}
