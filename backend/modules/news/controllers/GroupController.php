<?php
namespace backend\modules\news\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\news\models\{
    Group, GroupLang
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class GroupController extends BackendController
{
    public $model = Group::class;
    public $modelLang = GroupLang::class;
    public $title = 'Article groups';
}
