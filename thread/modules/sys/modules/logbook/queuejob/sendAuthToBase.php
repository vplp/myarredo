<?php

namespace thread\modules\sys\modules\logbook\queuejob;

use thread\modules\sys\modules\logbook\models\LogbookAuthModel as LogbookModel;
use yii\base\BaseObject;

/**
 * Class sendAuthToBase
 *
 * @package thread\modules\sys\modules\logbook\queuejob
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class sendAuthToBase extends BaseObject implements \yii\queue\Job
{
    public $message;
    public $action;
    public $type = LogbookModel::TYPE_NOTICE;
    public $user_id = 0;
    public $time = 0;

    /**
     * @param \yii\queue\Queue $queue
     * @return bool
     */
    public function execute($queue)
    {
        $model = new LogbookModel([
            'scenario' => 'send',
            'type' => $this->type,
            'action' => $this->action,
            'user_id' => $this->user_id,
            "time" => 0
        ]);
        if ($model->save()) {
            $model['created_at'] = $this->time;
            $model->save();
        }
    }
}
