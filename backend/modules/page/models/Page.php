<?php
namespace backend\modules\page\models;

use yii\helpers\ArrayHelper;
//
use common\modules\page\models\Page as CommonPageModel;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Page
 *
 * @package backend\modules\page\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Page extends CommonPageModel implements BaseBackendModel
{

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->joinWith(['lang'])->undeleted()->all(), 'id', 'lang.title');
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
