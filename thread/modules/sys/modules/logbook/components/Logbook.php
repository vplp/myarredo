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
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Logbook extends Component
{
    /**
     * @param $message
     * @param $link
     * @param string $type
     * @param string $category
     * @throws \yii\db\Exception
     */
    public function send($message, $link, $type = LogbookModel::TYPE_NOTICE, $category = 'app')
    {
        $model = new LogbookModel([
            'scenario' => 'send',
            'message' => $message,
            'url' => $link,
            'type' => $type,
            'user_id' => Yii::$app->getUser()->id,
            'category' => $category,
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