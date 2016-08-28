<?php
namespace backend\modules\page\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\page\models\{
    Page, PageLang, search\Page as filterPageModel
};

/**
 * Class PageController
 *
 * @package backend\modules\page\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class PageController extends BackendController
{
    public $model = Page::class;
    public $modelLang = PageLang::class;
    public $filterModel = filterPageModel::class;
    public $title = 'Pages';
    public $name = 'page';
}
