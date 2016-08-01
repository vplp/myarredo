<?php
namespace backend\modules\page\models;

use yii\helpers\ArrayHelper;
//
use common\modules\page\models\Page as CommonPageModel;
use thread\modules\seo\behaviors\SeoBehavior;


/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class Page extends CommonPageModel
{

    /**
     * Behaviors
     *
     * @return array
     */
    public function behaviors()
    {

        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'SeoBehavior' => [
                    'class' => SeoBehavior::class,
                    'modelNamespace' => self::COMMON_NAMESPACE
                ]
            ]
        );
    }
}
