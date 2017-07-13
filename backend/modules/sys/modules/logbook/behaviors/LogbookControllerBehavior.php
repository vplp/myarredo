<?php
namespace backend\modules\sys\modules\logbook\behaviors;

use Closure;
use yii\base\{
    Behavior, Exception
};
use yii\base\Controller;
use common\modules\sys\modules\logbook\models\Logbook;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 *
 *
 * public function behaviors()
 * {
 * return ArrayHelper::merge(
 * parent::behaviors(),
 * [
 * 'LogbookControllerBehavior' => [
 * 'class' => LogbookControllerBehavior::class,
 * 'action' =>         [
 * 'action' => 'insert',
 * 'message' => 'test insert',
 * ],
 * ]
 * ]);
 * }
 */
class LogbookControllerBehavior extends Behavior
{
    public $category;
    public $action = [
        [
            'action' => 'insert',
            'message' => 'test insert',
        ],
        [
            'action' => 'update',
            'message' => 'test update',
        ]
    ];
    public $insertMessage;
    public $updateMessage;
    public $deleteMessage;

    /**
     * @throws Exception
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_AFTER_ACTION => 'runAction',
        ];
    }

    /**
     * @param $event
     */
    public function runAction($event)
    {
        if (!empty($this->action)) {
            foreach ($this->action as $k => $item) {
                if (isset($item['action']) && $item['action'] == $event->action->id) {
                    $this->runActionInsertToLog($event, $this->action[$k]);
                }
            }
        }
    }

    /**
     * @param $event
     */
    public function runActionInsertToLog($event, $action)
    {
        $model = new Logbook();
        $model->scenario = 'backend';
        $model->message = $this->getInsertMessage($action);
        $model->type = "notice";
        $model->user_id = \Yii::$app->getUser()->id;
        $model->category = $this->getCategory($event);
        $model->save();
    }

    /**
     * @param $event
     * @return mixed
     */
    public function getCategory($event)
    {
        $m = $this->category;
        $mess = ($m instanceof \Closure) ? $m() : $m;
        if (empty($mess)) {
            $mess = $event->action->controller->getTitle();
        }
        return $mess;
    }

    /**
     * @return string
     */
    public function getInsertMessage($action)
    {
        $m = ($action['message'])??"User run action: " . $action['action'];
        $mess = ($m instanceof \Closure) ? $m() : $m;
        return $mess;
    }

}