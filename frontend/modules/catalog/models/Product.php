<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;
//
use frontend\components\ImageResize;

/**
 * Class Product
 *
 * @package frontend\modules\catalog\models
 */
class Product extends \common\modules\catalog\models\Product
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * findBase
     *
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy(self::tableName() . '.position DESC')
            ->enabled()
            ->asArray();
    }

    /**
     * findByAlias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy('position DESC')
            ->enabled()
            ->byAlias($alias)
            ->innerJoinWith([
                    'category' => function ($q) {
                        $q->with(['lang']);
                    }]
            )
            ->one();
    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Product())->search($params);
    }

    /**
     * Image
     *
     * @param string $image_link
     * @return null|string
     */
    public static function getImage($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();
        $url = $module->getProductUploadUrl();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = $url . '/' . $image_link;
        }

        return $image;
    }

    /**
     * ImageThumb
     *
     * @param string $image_link
     * @return null|string
     */
    public static function getImageThumb($image_link  = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();
        $url = $module->getProductUploadUrl();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {

            $image_link_path = explode('/', $image_link);

            $img_name = $image_link_path[count($image_link_path)-1];

            unset($image_link_path[count($image_link_path)-1]);

//            $dir    = $path . '/' . implode('/' ,$image_link_path);
//            $files = scandir($dir);

            $_image_link = $path . '/' . implode('/', $image_link_path) . '/thumb_' . $img_name;

            if (is_file($_image_link)) {
                $image = $_image_link;
            } else {
                $image = $path . '/' . $image_link;
            }

            // resize
            $ImageResize = new ImageResize($path, $url);
            $image = $ImageResize->getThumb($image, 340, 340);
        }

        return $image;
    }

    /**
     * @return array
     */
    public function getGalleryImage()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();
        $url = $module->getProductUploadUrl();

        $images = [];

        if (!empty($this->gallery_image)) {
            $this->gallery_image = $this->gallery_image[0] == ','
                ? substr($this->gallery_image, 1)
                : $this->gallery_image;

            $images = explode(',', $this->gallery_image);
        }

        $imagesSources = [];

        foreach ($images as $image) {
            if (file_exists($path . '/' . $image)) {

                //$imagesSources[] = self::getImageThumb($image);
                $imagesSources[] = $url . '/' . $image;
            }
        }

        return $imagesSources;
    }

    /**
     * Url
     *
     * @param string $alias
     * @return string
     */
    public static function getUrl(string $alias)
    {
        return Url::toRoute(['/catalog/product/view', 'alias' => $alias], true);
    }

    /**
     * Title
     *
     * @return string
     */
    public function getTitle()
    {
        $title = $this->lang->title;

        if ($this->is_composition)
            $title = 'КОМПОЗИЦИЯ ' . $title;

        return $title;
    }

    /**
     * Static title
     *
     * @param $model
     * @return string
     */
    public static function getStaticTitle($model)
    {
        $title = $model['lang']['title'];

        if ($model['is_composition'])
            $title = 'КОМПОЗИЦИЯ ' . $title;

        return $title;
    }

    /**
     * Product By Collection
     *
     * @param $collections_id
     * @param $catalog_type_id
     * @return mixed
     */
    public static function getProductByCollection(int $collections_id, int $catalog_type_id)
    {
        return parent::findBase()
            ->enabled()
            ->andWhere([
                'collections_id' => $collections_id,
            ])
            ->limit(12)
            ->all();
    }

    /**
     * Product By Factory
     *
     * @param $factory_id
     * @param $catalog_type_id
     * @return mixed
     */
    public static function getProductByFactory($factory_id, $catalog_type_id)
    {
        return parent::findBase()
            ->enabled()
            ->andWhere([
                'factory_id' => $factory_id,
                'catalog_type_id' => $catalog_type_id
            ])
            ->limit(12)
            ->all();
    }

    /**
     * Products By Composition Id
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsByCompositionId()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(ProductRelComposition::tableName(), ['composition_id' => 'id']);
    }

    /**
     * Composition By Product Id
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompositionByProductId()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'composition_id'])
            ->viaTable(ProductRelComposition::tableName(), ['catalog_item_id' => 'id'])
            ->indexBy('alias')
            ->enabled();
    }

    /**
     * Elements Composition
     *
     * @return \yii\db\ActiveQuery
     */
    public function getElementsComposition()
    {
        if ($this->is_composition) {
            return $this->getProductsByCompositionId();
        } else {

            $composition = $this->getCompositionByProductId()->all();

            if (!empty($composition)) {

                $aliasC = preg_replace('%^.+/%iu', '', trim(Yii::$app->request->url, '/'));

                if ($aliasC && !empty($composition[$aliasC])) {
                    $id_compos = $composition[$aliasC]->id;
                } else {
                    $id_compos = $composition[key($composition)]->id;
                }

                $model = self::findByID($id_compos);

                if ($model !== null) {
                    return $model->elementsComposition;
                }
            }

            return [];
        }
    }
}