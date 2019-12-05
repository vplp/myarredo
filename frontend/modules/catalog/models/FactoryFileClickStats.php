<?php

namespace frontend\modules\catalog\models;

use Yii;

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
        $model = FactoryFileClickStats::find()
            ->andWhere([
                'user_id' => Yii::$app->user->identity->id,
                'factory_file_id' => $factory_file_id
            ])
            ->one();

        /** @var $model FactoryFileClickStats */

        if ($model != null) {
            $model->setScenario('frontend');

            ++$model->views;

            $model->save();
        } else {
            $model = new FactoryFileClickStats();

            $model->setScenario('frontend');

            $model->user_id = Yii::$app->getUser()->id;
            $model->factory_file_id = $factory_file_id;
            $model->views = 1;

            $model->save();
        }
    }
}
