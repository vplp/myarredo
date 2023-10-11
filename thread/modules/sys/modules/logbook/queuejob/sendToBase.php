<?php

namespace thread\modules\sys\modules\logbook\queuejob;

use thread\modules\sys\modules\logbook\models\Logbook as LogbookModel;
use yii\base\BaseObject;

/**
 * Class sendToBase
 *
 * @package thread\modules\sys\modules\logbook\queuejob
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class sendToBase extends BaseObject implements \yii\queue\Job
{
    public $message;
    public $link;
    public $type = LogbookModel::TYPE_NOTICE;
    public $user_id = 0;
    public $category = 'app';
    public $time = 0;

    /**
     * @param \yii\queue\Queue $queue
     * @return bool
     */
    public function execute($queue)
    {
        $model = new LogbookModel([
            'scenario' => 'send',
            'message' => $this->message,
            'url' => $this->link,
            'type' => $this->type,
            'user_id' => $this->user_id,
            'category' => $this->category
        ]);
        if ($model->save()) {
            $model['created_at'] = $this->time;
            $model->save();
        }
    }
}
