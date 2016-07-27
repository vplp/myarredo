<?php
namespace backend\modules\news\controllers;

use backend\modules\news\models\search\Group;
use backend\modules\news\models\GroupLang;
use thread\app\base\controllers\BackendController;
use yii\filters\AccessControl;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class GroupController extends BackendController
{
    public $model = Group::class;
    public $modelLang = GroupLang::class;
    public $title = 'Article groups';
}
