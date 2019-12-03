<?php

namespace frontend\modules\catalog\models;

use Yii;
//
use frontend\modules\catalog\Catalog;

/**
 * Class FactoryFileClickStats
 *
 * @package frontend\modules\catalog\models
 */
class FactoryFileClickStats extends \common\modules\catalog\models\FactoryFileClickStats
{
    /**
     * @param $factory_file_id
     */
    public static function create($factory_file_id)
    {
            $model = new self();

            $model->setScenario('frontend');

            $model->user_id = Yii::$app->getUser()->id ?? 0;
            $model->factory_file_id = $factory_file_id;
            $model->views = 1;

            $model->save();
    }
}
