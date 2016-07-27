<?php
namespace backend\modules\seo\controllers;

use backend\modules\seo\models\search\Seo;
use backend\modules\seo\models\SeoLang;
use thread\app\base\controllers\BackendController;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class SeoController extends BackendController
{
    public $model = Seo::class;
    public $modelLang = SeoLang::class;
    public $title = 'SEO';
}
