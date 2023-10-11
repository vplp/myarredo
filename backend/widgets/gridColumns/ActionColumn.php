<?php
namespace backend\widgets\gridColumns;

use yii\grid\Column;
use yii\helpers\Html;
//
use thread\app\base\models\ActiveRecord;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class ActionColumn extends Column
{

    /**
     * @var array
     */
    public $contentOptions = [
        'class' => 'text-center',
    ];

    /**
     * @var array
     */
    public $headerOptions = [
        'class' => 'text-center'
    ];

    /**
     * @var string|array
     */
    public $updateLink;

    /**
     * @var string|array
     */
    public $deleteLink;

    /**
     * @var string
     */
    public $header = 'Actions';

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $updateLink = ($this->getUpdateLink($model) !== false) ? Html::a('<i class="fa fa-pencil"></i> ', $this->getUpdateLink($model), ['class' => 'btn btn-success btn-s']) : '';
        $deleteLink = ($this->getDeleteLink($model) !== false) ? Html::a('<i class="fa fa-trash"></i> ', $this->getDeleteLink($model), ['class' => 'btn btn-danger btn-s']) : '';

        return '<table style="display: inline-block;"><tr><td>' . $updateLink .
        '</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>' . $deleteLink . '</td></tr></table>';
    }

    /**
     * @param ActiveRecord $model
     * @return array
     */
    protected function getUpdateLink($model)
    {
        if (!empty($this->updateLink)) {
            if ($this->updateLink instanceof \Closure) {
                $f = $this->updateLink;
                return $f($model);
            } else {
                $r = ['update'];
                foreach ($this->updateLink as $data) {
                    $r[$data] = $model->$data;
                }
                return $r;
            }
        } else {
            return ['update', 'id' => $model->id];
        }
    }

    /**
     * @param ActiveRecord $model
     * @return array
     */
    protected function getDeleteLink($model)
    {
        if (!empty($this->deleteLink)) {
            if ($this->deleteLink instanceof \Closure) {
                $f = $this->deleteLink;
                return $f($model);
            } else {
                $r = ['intrash'];
                foreach ($this->deleteLink as $data) {
                    $r[$data] = $model->$data;
                }

                return $r;
            }
        } else {
            return ['intrash', 'id' => $model->id];
        }
    }

    /**
     * Renders the header cell content.
     * The default implementation simply renders [[header]].
     * This method may be overridden to customize the rendering of the header cell.
     * @return string the rendering result
     */
    protected function renderHeaderCellContent()
    {
        return trim($this->header) !== '' ? \Yii::t('app', $this->header) : $this->getHeaderCellLabel();
    }
}
