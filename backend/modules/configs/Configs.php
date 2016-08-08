<?php
namespace backend\modules\configs;

use Yii;
//
use common\modules\configs\Configs as CommonConfigsModule;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class Configs extends CommonConfigsModule
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    /**
     * Image upload path
     * @return string
     */
    public function getUploadPath()
    {
        return Yii::getAlias('@uploads') . '/' . $this->name . '/';
    }

    /**
     * Image upload URL
     * @return string
     */
    public function getUploadUrl()
    {
        return '/uploads/' . $this->name . '/';
    }
}
