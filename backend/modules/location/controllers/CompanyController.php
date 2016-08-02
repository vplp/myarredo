<?php
namespace backend\modules\location\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    Company, CompanyLang
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class CompanyController extends BackendController
{
    public $model = Company::class;
    public $modelLang = CompanyLang::class;
    public $title = 'Company';
}
