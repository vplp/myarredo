<?php
namespace backend\modules\location\controllers;

use backend\modules\location\models\search\Company;
use backend\modules\location\models\CompanyLang;
use thread\app\base\controllers\BackendController;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class CompanyController extends BackendController
{
    public $model = Company::class;
    public $modelLang = CompanyLang::class;
    public $title = 'Company';
}
