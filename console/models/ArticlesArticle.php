<?php

namespace console\models;

/**
 * Class ArticlesArticle
 *
 * @package console\models
 */
class ArticlesArticle extends \frontend\modules\articles\models\Article
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
