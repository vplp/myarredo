<?php

namespace frontend\modules\shop\models;

/**
 * Class OrderComment
 *
 * @package frontend\modules\shop\models
 */
class OrderComment extends \common\modules\shop\models\OrderComment
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()
            ->byID($id)
            ->one();
    }

    /**
     * @return mixed
     */
    public static function getReminder()
    {
        $query = OrderComment::findBase();

        $start = mktime(0, 0, 0, date('m'), date('j'), date('Y'));
        $end = mktime(23, 59, 0, date('m'), date('j'), date('Y'));

        $query->andFilterWhere(['processed' => '0']);
        $query->andFilterWhere(['between', 'reminder_time', $start, $end]);

        return $query;
    }

    public static function getCountReminder()
    {
        return OrderComment::getReminder()->count();
    }
}
