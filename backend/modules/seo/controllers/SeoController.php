<?php
namespace backend\modules\seo\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\seo\models\{
    Seo, SeoLang
};

/**
 * Class SeoController
 *
 * @package backend\modules\seo\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class SeoController extends BackendController
{
    public $model = Seo::class;
    public $modelLang = SeoLang::class;
    public $title = 'Seo';
    public $name = 'seo';
}
