<?php
namespace backend\modules\sys\modules\logbook\behaviors;

use Closure;
use yii\base\{
    Behavior, Exception
};
use yii\db\ActiveRecord;
use thread\modules\sys\modules\logbook\models\Logbook;

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
 * 'LogbookBehavior' => [
 * 'class' => LogbookBehavior::class,
 * 'category' => 'Новости',
 * 'updateMessage' => function () {
 * return "<a href='/core-cms/web/backend/news/article/update?id=" . $this->owner->id . "'>Обновлена новость " . $this->owner->lang->title . "</a>";
 * }
 * ]
 * ]
 * );
 * }
 */
class LogbookBehavior extends Behavior
{
    public $category;
    public $insertMessage;
    public $updateMessage;
    public $deleteMessage;

    /**
     * @throws Exception
     */
    public function init()
    {
        if (empty($this->category)) {
            throw new Exception('attribute $category must be not empty');
        }
        parent::init();
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsertLog',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateLog',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDeleteLog',
        ];
    }

    /**
     * @param $event
     */
    public function afterInsertLog($event)
    {
        $model = new Logbook();
        $model->scenario = 'backend';
        $model->message = $this->getInsertMessage();
        $model->type = "notice";
        $model->user_id = \Yii::$app->getUser()->id;
        $model->category = $this->category;
        $model->save();
    }

    /**
     * @return string
     */
    public function getInsertMessage()
    {
        $m = $this->insertMessage;
        if ($m instanceof \Closure) {
            $mess = $m();
        } elseif (!empty($m)) {
            $mess = $m;
        } else {
            $mess = "New record has been inserted ID:" . $this->owner->id;
        }
        return $mess;
    }

    /**
     * @param $event
     */
    public function afterUpdateLog($event)
    {
        try {
            $model = new Logbook();
            $model->scenario = 'backend';
            $model->message = $this->getUpdateMessage();
            $model->type = "notice";
            $model->user_id = \Yii::$app->getUser()->id;
            $model->category = $this->category;
//            var_dump($model);
            $model->save(false);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getUpdateMessage()
    {
        $m = $this->updateMessage;
        if ($m instanceof \Closure) {
            $mess = $m();
        } elseif (!empty($m)) {
            $mess = $m;
        } else {
            $mess = "Record has been updated ID:" . $this->owner->id;
        }
        return $mess;
    }

    /**
     * @param $event
     */
    public function afterDeleteLog($event)
    {
        $model = new Logbook();
        $model->scenario = 'backend';
        $model->message = $this->getDeleteMessage();
        $model->type = "notice";
        $model->user_id = \Yii::$app->getUser()->id;
        $model->category = $this->category;
        $model->save();
    }

    /**
     * @return string
     */
    public function getDeleteMessage()
    {
        $m = $this->updateMessage;
        if ($m instanceof \Closure) {
            $mess = $m();
        } elseif (!empty($m)) {
            $mess = $m;
        } else {
            $mess = "Record has been deleted ID:" . $this->owner->id;
        }
        return $mess;
    }
}