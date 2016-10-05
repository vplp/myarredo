<?php
namespace backend\modules\sys\modules\growl\models\search;

use Yii;
//
use backend\modules\sys\modules\growl\models\{
    Growl as GrowlModel
};

/**
 * Class Bell
 *
 * @package backend\modules\sys\modules\growl\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Bell extends GrowlModel
{
    /**
     * @return mixed
     */
    public static function find_base()
    {
        return self::find()->user_id(Yii::$app->getUser()->id)->isnt_read();
    }

    /**
     * @return mixed
     */
    public static function getUnreadMessagesCount()
    {
        return self::find_base()->count();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public static function getUnreadMessages(int $limit)
    {
        return self::find_base()->limit($limit)->all();
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->url;
    }

    /**
     * @return bool|string
     */
    public function getDateTime()
    {
        return date('d.m.Y H;i', $this->updated_at);
    }
}
