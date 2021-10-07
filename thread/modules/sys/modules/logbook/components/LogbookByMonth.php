<?php

namespace thread\modules\sys\modules\logbook\components;

use thread\modules\sys\modules\logbook\models\LogbookByMonth as LogbookModel;
use thread\modules\sys\modules\logbook\queuejob\sendToBase;
use Yii;
use yii\base\Component;
use yii\log\Logger;

/**
 * Class LogbookByMonth
 *
 * @package thread\modules\sys\modules\logbook\components
 */
class LogbookByMonth extends Component
{
    /**
     * @param $action_method
     * @throws \yii\base\InvalidConfigException
     */
    public function send($action_method, $date = 0)
    {
        if ($date) {
            $action_date = mktime(0, 0, 0, date('m', $date)  , 1, date('Y', $date));
        } else {
            $action_date = mktime(0, 0, 0, date('m')  , 1, date('Y'));
        }


        $model = LogbookModel::find()
            ->where([
                'user_id' => Yii::$app->getUser()->id,
                'action_method' => $action_method,
                'action_date' => $action_date,
            ])
            ->one();

        if ($model != null) {
            $model->setScenario('send');
            $model->count = $model->count + 1;
        } else {
            $model = new LogbookModel([
                'scenario' => 'send',
                'user_id' => Yii::$app->getUser()->id,
                'action_method' => $action_method,
                'action_date' => $action_date,
            ]);

            $model->count = 1;
        }

        /**
         * @var $t yii\db\Transaction
         */
        $t = $model::getDb()->beginTransaction();
        try {
            $save = $model->save();
            ($save === true) ? $t->commit() : $t->rollBack();
        } catch (\Exception $exception) {
            Yii::getLogger()->log($exception->getMessage(), Logger::LEVEL_ERROR);
            $t->rollBack();
        }
    }
}
