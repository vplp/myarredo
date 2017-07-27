<?php

namespace backend\modules\catalog\controllers;

use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Collection, CollectionLang, search\Collection as filterCollection
};

/**
 * Class CollectionController
 *
 * @package backend\modules\catalog\controllers
 */
class CollectionController extends BackendController
{
    public $model = Collection::class;
    public $modelLang = CollectionLang::class;
    public $filterModel = filterCollection::class;
    public $title = 'Collection';
    public $name = 'collection';
}