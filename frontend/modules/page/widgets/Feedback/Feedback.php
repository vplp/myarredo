<?php

namespace frontend\modules\page\widgets\Feedback;
use thread\app\base\widgets\Widget;
use backend\modules\forms\models\Topic;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class LogIn
 *
 * @package frontend\modules\forms\widgets\Feedback
 * @author Alla Kuzmenko
 * @copyright (c) 2016, Thread
 *
 * 
 *
 */
class Feedback extends Widget {

    public $view = 'Feedback';
    public $name = 'feedback';
    public $TopicDropdownList;
    

    public function init() {

       $this->TopicDropdownList = ArrayHelper::merge(
            ['' => '---' . Yii::t('form', 'Choose topic') . '---'],
            Topic::getDropdownList()
        );

    }
    

    public function run() {
        return $this->render($this->view, ['TopicDropdownList' => $this->TopicDropdownList]);
    }

}