<?php
namespace backend\modules\forms\controllers;

use backend\modules\forms\models\search\Topic;
use backend\modules\forms\models\TopicLang;
use thread\app\base\controllers\BackendController;
use yii\filters\AccessControl;

/**
 * @author Alla Kuzmenko
 */
class TopicController extends BackendController
{
    public $model = Topic::class;
    public $modelLang = TopicLang::class;
    public $title = 'Topic form';
}