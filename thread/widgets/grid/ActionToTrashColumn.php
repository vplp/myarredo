<?php

namespace thread\widgets\grid;

use Yii;
use yii\grid\Column;
use yii\helpers\Html;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ActionToTrashColumn
 *
 * @package thread\app\components\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActionToTrashColumn extends Column
{
    /**
     * @var string|array
     */
    public $link;

    /**
     * @param $model
     * @return array|mixed
     */
    protected function getLink($model)
    {
        if (!empty($this->link)) {
            if ($this->link instanceof \Closure) {
                $f = $this->link;
                return $f($model);
            } else {
                $r = ['intrash'];
                foreach ($this->link as $data) {
                    $r[$data] = $model->$data;
                }

                return $r;
            }
        } else {
            return ['intrash', 'id' => $model->id];
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::a(Yii::t('app', 'Delete'), $this->getLink($model));
    }
}
