<?php
namespace backend\modules\sys\modules\messages\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class MessagesFile
 *
 * @package backend\modules\sys\modules\messages\models
 */
class MessagesFile extends \common\modules\sys\modules\messages\models\MessagesFile implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\MessagesFile())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\MessagesFile())->trash($params);
    }

    /**
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->innerJoinWith('lang')->asArray()->all(), 'id', 'lang.title');
    }
}
