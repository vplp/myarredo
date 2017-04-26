<?php

namespace backend\modules\sys\modules\translation\controllers;

use thread\app\base\controllers\BackendController;
use backend\modules\sys\modules\translation\models\{
    Message,
    Source,
    search\Source as SourceSearch
};

/**
 * Class TranslationController
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package backend\modules\sys\modules\translation\controllers
 */
class TranslationController extends BackendController
{
    public $model = Source::class;
    public $modelLang = Message::class;
    public $filterModel = SourceSearch::class;
    public $title = 'Translation';
    public $name = 'translation';
}
