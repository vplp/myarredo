<?php
namespace backend\modules\page\models;

use thread\models\query\ActiveQuery;
use common\modules\page\models\Page as CommonPageModel;
use thread\modules\seo\behaviors\SeoBehavior;
use yii\helpers\ArrayHelper;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class Page extends CommonPageModel
{
    /**
     * Find base Page object for current language active and undeleted
     * @return ActiveQuery
     */
    public static function findBase()
    {
        return parent::findBase()->_lang()->enabled();
    }
    
    /**
     * Find ONE Page object in array by its alias
     * @param string $alias
     * @return array
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->alias($alias)->asArray()->one();
    }

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
