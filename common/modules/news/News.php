<?php

namespace common\modules\news;

use Yii;

/**
 * Class News
 *
 * @package common\modules\news
 */
class News extends \thread\modules\news\News
{
    /**
     * Product upload path
     * @return string
     */
    public function getArticleUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/news';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Product upload URL
     * @return string
     */
    public function getArticleUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/news';
    }

    /**
     * Image upload path
     * @return string
     */
    public function getBaseUploadPath()
    {
        return Yii::getAlias('@uploads');
    }

    /**
     * Base upload URL
     * @return string
     */
    public function getBaseUploadUrl()
    {
        return '/uploads';
    }
}
