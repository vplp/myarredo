<?php
namespace common\modules\news;

use Yii;

/**
 * Class News
 *
 * @package common\modules\news
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class News extends \thread\modules\news\News
{
    /**
     * Image upload path
     * @return string
     */
    public function getArticleUploadPath()
    {
        return Yii::getAlias('@uploads') . '/' . $this->name . '/article';
    }

    /**
     * Image upload URL
     * @return string
     */
    public function getArticleUploadUrl()
    {
        return '/uploads/' . $this->name . '/article';
    }
}
