<?php
namespace backend\modules\page\models;

use yii\helpers\ArrayHelper;
//
use common\modules\page\models\Page as CommonPageModel;
//
use thread\modules\seo\behaviors\SeoBehavior;
use thread\app\model\interfaces\BaseBackendModel;


/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class Page extends CommonPageModel implements BaseBackendModel
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

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Page())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Page())->trash($params);
    }
}
