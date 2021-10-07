<?php

namespace thread\modules\sys\modules\logbook\components;

use thread\modules\sys\modules\logbook\models\Logbook as LogbookModel;
use thread\modules\sys\modules\logbook\queuejob\sendToBase;
use Yii;
use yii\base\Component;
use yii\log\Logger;

/**
 * Class Logbook
 *
 * @package thread\modules\sys\modules\logbook\components
 */
class Logbook extends Component
{
    /**
     * @param $message
     * @param $link
     * @param string $type
     * @param string $category
     * @param string $model_name
     * @param string $action_method
     * @param int $model_id
     * @throws \yii\db\Exception
     */
    public function send($message, $link, $type = LogbookModel::TYPE_NOTICE, $category = 'app', $model_name = '', $action_method = '', $model_id = 0)
    {
        $model = new LogbookModel([
            'scenario' => 'send',
            'message' => $message,
            'url' => Yii::$app->request->url, //$link,
            'type' => $type,
            'user_id' => Yii::$app->getUser()->id,
            'category' => $category,
            'model_name' => $model_name,
            'action_method' => $action_method,
            'model_id' => $model_id,
        ]);

        /**
         * @var $t yii\db\Transaction
         */
        $t = $model::getDb()->beginTransaction();
        try {
            $save = false;
            if ($model->save(false)) {
                $model['created_at'] = \time();
                $save = $model->save();
            }
            ($save === true) ? $t->commit() : $t->rollBack();
        } catch (\Exception $exception) {
            Yii::getLogger()->log($exception->getMessage(), Logger::LEVEL_ERROR);
            $t->rollBack();
        }
    }

    /**
     * @param $message
     * @param $link
     * @param string $type
     * @param string $category
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function sendThroughQueue($message, $link, $type = LogbookModel::TYPE_NOTICE, $category = 'app')
    {
        $queue = Yii::$app->get('queue');
        return $queue->push(new sendToBase([
            'message' => $message,
            'url' => $link,
            'type' => $type,
            'user_id' => Yii::$app->getUser()->id ?? 0,
            'category' => $category,
            'time' => \time()
        ]));
    }
}
