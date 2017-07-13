<?php

namespace thread\widgets\grid;

use Yii;
use yii\grid\Column;
use yii\helpers\Html;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ActionRestoreColumn
 * @package thread\app\components\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActionRestoreColumn extends Column
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
                $r = ['outtrash'];
                foreach ($this->link as $data) {
                    $r[$data] = $model->$data;
                }

                return $r;
            }
        } else {
            return ['outtrash', 'id' => $model->id];
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::a(Yii::t('app', 'Restore'), $this->getLink($model));
    }
}
