<?php

namespace thread\widgets\grid;

use Yii;
use yii\grid\Column;
use yii\helpers\Html;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ActionDeleteColumn
 *
 * @package thread\widgets\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActionDeleteColumn extends Column
{

    /**
     * @var string|array
     */
    public $link;

    /**
     * @param ActiveRecord $model
     * @return mixed
     */
    protected function getLink($model)
    {
        if (!empty($this->link)) {
            if ($this->link instanceof \Closure) {
                $f = $this->link;

                return $f($model);
            } else {
                $r = ['delete'];
                foreach ($this->link as $data) {
                    $r[$data] = $model->$data;
                }

                return $r;
            }
        } else {
            return ['delete', 'id' => $model->id];
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::a(
            Yii::t('app', 'Delete'),
            $this->getLink($model),
            [
                'class' => 'ActionDeleteColumn',
                'data-message' => Yii::t('app', 'Do you confirm the deletion?')
            ]
        );
    }
}
