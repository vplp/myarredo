<?php

namespace thread\modules\sys\modules\logbook\components;

use thread\modules\sys\modules\logbook\{models\LogbookAuthModel, queuejob\sendAuthToBase};
use yii;
use yii\base\Component;
use yii\log\Logger;

/**
 * Class LogbookAuth
 *
 * @package thread\modules\sys\modules\logbook\components
 */
class LogbookAuth extends Component
{
    /**
     * @param $action
     * @param string $type
     * @throws yii\db\Exception
     */
    public function send($action, $type = LogbookAuthModel::TYPE_NOTICE)
    {
        $agent = Yii::$app->getRequest()->getUserAgent() ?? '';
        $agent = mb_substr($agent, 0, 254);
        $model = new LogbookAuthModel([
            'scenario' => 'send',
            'type' => $type,
            'action' => $action,
            'user_id' => Yii::$app->getUser()->getId(),
            'user_ip' => Yii::$app->getRequest()->getUserIP() ?? '',
            'user_agent' => $agent,
        ]);
        /**
         * @var $t yii\db\Transaction
         */
        $t = $model::getDb()->beginTransaction();
        try {
            $model['created_at'] = \time();
            $save = $model->save();
            ($save === true) ? $t->commit() : $t->rollBack();
        } catch (\Exception $exception) {
            Yii::getLogger()->log($exception->getMessage(), Logger::LEVEL_ERROR);
            $t->rollBack();
        }
    }

    /**
     * @param $action
     * @param string $type
     * @return mixed
     * @throws yii\base\InvalidConfigException
     */
    public function sendThroughQueue($action, $type = LogbookAuthModel::TYPE_NOTICE)
    {
        $agent = Yii::$app->getRequest()->getUserAgent() ?? '';
        $agent = mb_substr($agent, 0, 254);
        $queue = Yii::$app->get('queue');
        return $queue->push(new sendAuthToBase([
            'scenario' => 'send',
            'type' => $type,
            'action' => $action,
            'user_id' => Yii::$app->getUser()->id,
            'user_ip' => Yii::$app->getRequest()->getUserIP() ?? '',
            'user_agent' => $agent,
            'time' => time()
        ]));
    }
}
