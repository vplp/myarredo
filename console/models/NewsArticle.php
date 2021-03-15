<?php

namespace console\models;

/**
 * Class NewsArticle
 *
 * @package console\models
 */
class NewsArticle extends \frontend\modules\news\models\Article
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy(['published_time' => SORT_DESC])
            ->enabled();
    }
}
