<?php
namespace thread\widgets\grid;

use Closure;
use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\helpers\{
    Html, Url
};
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ActionCheckboxColumn
 *
 * @package thread\widgets\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
     * @var string|Closure
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
        $action = '';
        if ($this->action instanceof Closure) {
            $action = $this->action;
            $action = $action($model);
        } else {
            $action = $this->action;
        }

        if ($action === false) {
            $dataAttributes = [
                'class' => 'ajax-switcher i-checks',
                'disabled' => true,
            ];
        } else {
            $dataAttributes = [
                'class' => 'ajax-switcher i-checks',
                'data' => [
                    'id' => $model->id,
                    'url' => Url::toRoute([$action]),
                ],
            ];
        }

        /** @var \yii\db\ActiveRecord $model */
        return Html::checkbox(null, (int)$model->{$this->attribute}, $dataAttributes);
    }
}
