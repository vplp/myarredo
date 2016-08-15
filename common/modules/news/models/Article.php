<?php
namespace common\modules\news\models;

use Yii;

/**
 * Class Article
 *
 * @package common\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
        $newsModule = Yii::$app->getModule('news');
        $path = $newsModule->getArticleUploadPath();
        $url = $newsModule->getArticleUploadUrl();
        $image = null;
        if (!empty($this->image_link) && is_file($path . $this->image_link)) {
            $image = $url . $this->image_link;
        }
        return $image;
    }
}
