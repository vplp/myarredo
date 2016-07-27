<?php
namespace common\modules\news\models;

use Yii;
//
use thread\modules\news\models\Article as BaseArticleModel;
use yii\helpers\ArrayHelper;

/**
 * Class Article
 * @package common\modules\news\models
 *
 * @property string $gallery_link
 */
class Article extends BaseArticleModel
{
    /** for seo */
    const COMMON_NAMESPACE = self::class;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['gallery_link'], 'string']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['group_id', 'alias', 'image_link', 'gallery_link', 'published', 'deleted', 'published_time'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'gallery_link' => Yii::t('app', 'Gallery'),
        ]);
    }
}
