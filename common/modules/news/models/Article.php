<?php

namespace common\modules\news\models;

use Yii;

/**
 * Class Article
 *
 * @package common\modules\news\models
 */
class Article extends \thread\modules\news\models\Article
{
    /** for seo */
    const COMMON_NAMESPACE = self::class;

    /**
     * @return null|string
     */
    public function getArticleImage()
    {
        $module = Yii::$app->getModule('news');

        $path = $module->getArticleUploadPath();
        $url = $module->getArticleUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = Yii::$app->getRequest()->hostInfo . $url . '/' . $this->image_link;
        }

        return $image;
    }
}
