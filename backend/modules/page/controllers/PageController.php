<?php
namespace backend\modules\page\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\page\models\{
    Page, PageLang, search\Page as filterPageModel
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class PageController extends BackendController
{
    public $model = Page::class;
    public $modelLang = PageLang::class;
    public $filterModel = filterPageModel::class;
    public $title = 'Pages';
}
