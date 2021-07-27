<?php

namespace backend\modules\seo\modules\directlink\models;

use Yii;
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Directlink
 *
 * @package backend\modules\seo\modules\directlink\models
 */
class Directlink extends \common\modules\seo\modules\directlink\models\Directlink implements BaseBackendModel
{
    /**
     * @inheritdoc
     */
    public function validateUrl($attribute)
    {
        $model = self::find()
            ->andFilterWhere(['url' => $this->$attribute])
            ->andFilterWhere(['<>', 'id', $this->id])
            ->one();


        $post = Yii::$app->request->post($this->formName());

        if ($model != null && !empty($model->city_ids) && !empty($post['city_ids'])) {
            foreach ($model->city_ids as $Mcity) {
                foreach ($post['city_ids'] as $Pcity) {
                    if ($Mcity == $Pcity) {
                        $this->addError(
                            'url',
                            Yii::t(
                                'yii',
                                '{attribute} "{value}" has already been taken.',
                                ['attribute' => 'url', 'value' => $this->$attribute]
                            )
                        );
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [
                ['published', 'deleted', 'add_to_sitemap', 'dissallow_in_robotstxt'],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['meta_robots'], 'in', 'range' => array_keys(static::statusMetaRobotsRange())],
            [['url', 'image_url'], 'string', 'max' => 255],
            ['url', 'validateUrl', 'on' => 'backend'],
            [['image_url'], 'default', 'value' => ''],
            [['city_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Directlink())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Directlink())->trash($params);
    }
}
