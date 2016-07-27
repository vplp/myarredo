<?php
namespace backend\modules\page\controllers;

use backend\modules\page\models\search\Page;
use backend\modules\page\models\PageLang;
use thread\app\base\controllers\BackendController;
use yii\filters\AccessControl;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class PageController extends BackendController
{
    public $model = Page::class;
    public $modelLang = PageLang::class;
    public $title = 'Pages';
}
