<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;
//
use frontend\components\ImageResize;

/**
 * Class Product
 *
 * @property Samples[] $samples
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
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang', 'factory'])
            ->andFilterWhere([
                Product::tableName() . '.removed' => '0',
                Factory::tableName() . '.published' => '1',
                Factory::tableName() . '.deleted' => '0',
                Factory::tableName() . '.show_for_' . Yii::$app->city->getDomain() => '1',
            ])
            ->enabled()
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @return mixed
     */
    public static function findBaseWithoutLang()
    {
        return self::find()
            ->innerJoinWith(['factory'])
            ->andFilterWhere([
                Product::tableName() . '.removed' => '0',
                Factory::tableName() . '.published' => '1',
                Factory::tableName() . '.deleted' => '0',
                Factory::tableName() . '.show_for_' . Yii::$app->city->getDomain() => '1',
            ])
            ->enabled()
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @return mixed
     */
    public static function findBaseArray()
    {
        return self::findBase()
            ->asArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findByID($id)
    {
        return self::findBaseArray()->byID($id)->one();
    }

    /**
     * @param $ids
     * @return array
     */
    public static function findByIDs($ids): array
    {
        return self::findBase()->andWhere(['IN', self::tableName() . '.id', array_unique($ids)])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id'])->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasOne(Types::class, ['id' => 'catalog_type_id'])->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
//    public function getSamples()
//    {
//        return $this
//            ->hasMany(Samples::class, ['id' => 'samples_id'])
//            ->viaTable(ProductRelSamples::tableName(), ['catalog_item_id' => 'id']);
//    }

    /**
     * @param $alias
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function findByAlias($alias)
    {
        return self::find()
            ->innerJoinWith(['lang', 'factory'])
            ->orderBy('position DESC')
            ->byAlias($alias)
            ->enabled()
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryCatalogsFiles()
    {
        return $this
            ->hasMany(FactoryCatalogsFiles::class, ['id' => 'factory_file_id'])
            ->viaTable(ProductRelFactoryCatalogsFiles::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryPricesFiles()
    {
        return $this
            ->hasMany(FactoryPricesFiles::class, ['id' => 'factory_file_id'])
            ->viaTable(ProductRelFactoryPricesFiles::tableName(), ['catalog_item_id' => 'id']);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        return (new search\Product())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public static function minPrice($params)
    {
        return search\Product::minPrice($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public static function maxPrice($params)
    {
        return search\Product::maxPrice($params);
    }

    /**
     * @param string $image_link
     * @return bool
     */
    public static function isImage($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();

        $image = false;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = true;
        }

        return $image;
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
            $image = 'https://img.myarredo.' . DOMAIN . $url . '/' . $image_link;
        } else {
            $image = 'https://www.myarredo.ru/uploads/images/' . $image_link;
        }

        return $image;
    }

    /**
     * @param string $image_link
     * @param int $width
     * @param int $height
     * @return null|string
     */
    public static function getImageThumb($image_link = '', $width = 340, $height = 340)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image_link_path = explode('/', $image_link);

            $img_name = $image_link_path[count($image_link_path) - 1];

            unset($image_link_path[count($image_link_path) - 1]);

            $_image_link = $path . '/' . implode('/', $image_link_path) . '/thumb_' . $img_name;

            if (is_file($_image_link)) {
                $image = $_image_link;
            } else {
                $image = $path . '/' . $image_link;
            }

            // resize
            $ImageResize = new ImageResize();
            $image = 'https://img.myarredo.' . DOMAIN . $ImageResize->getThumb($image, $width, $height);
        } else {
            $image = 'https://img.myarredo.ru/uploads/images/' . $image_link;
        }

        return $image;
    }

    /**
     * @return array
     */
    public function getGalleryImageThumb()
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
            if (is_file($path . '/' . $image)) {
                $imagesSources[] = [
                    'img' => 'https://img.myarredo.' . DOMAIN . $url . '/' . $image,
                    'thumb' => self::getImageThumb($image, 600, 600)
                ];
            }
        }

        return $imagesSources;
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl($alias)
    {
        if (isset(Yii::$app->controller->factory)) {
            return Url::toRoute([
                '/catalog/template-factory/product',
                'alias' => Yii::$app->controller->factory->alias,
                'product' => $alias
            ], true);
        } else {
            return Url::toRoute([
                '/catalog/product/view',
                'alias' => $alias
            ], true);
        }
    }

    /**
     * Title
     *
     * @return string
     */
    public function getTitle()
    {
        $title = $this->lang->title ?? '{{-}}';

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
        $title = $model['lang']['title'] ?? '{{-}}';

        return $title;
    }

    /**
     * Status
     *
     * @return string
     */
    public function getStatus()
    {
        $status = Yii::t('app', 'Снят с производства');

        if (!$this->removed && $this->in_stock) {
            $status = Yii::t('app', 'Товар в наличии');
        } elseif (!$this->removed) {
            $status = Yii::t('app', 'Под заказ');
        }

        return $status;
    }

    /**
     * @param int $collections_id
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function getProductByCollection(int $collections_id)
    {
        $result = self::getDb()->cache(function ($db) use ($collections_id) {
            return parent::findBase()
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    self::tableName() . '.image_link',
                    self::tableName() . '.factory_id',
                    ProductLang::tableName() . '.title',
                ])
                ->enabled()
                ->andWhere([
                    self::tableName() . '.collections_id' => $collections_id,
                ])
                ->limit(12)
                ->all();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param $factory_id
     * @param $catalog_type_id
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function getProductByFactory($factory_id, $catalog_type_id)
    {
        $result = self::getDb()->cache(function ($db) use ($factory_id, $catalog_type_id) {
            return parent::findBase()
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    self::tableName() . '.image_link',
                    self::tableName() . '.factory_id',
                    ProductLang::tableName() . '.title',
                ])
                ->enabled()
                ->andWhere([
                    self::tableName() . '.factory_id' => $factory_id,
                    self::tableName() . '.catalog_type_id' => $catalog_type_id
                ])
                ->limit(12)
                ->all();
        }, 60 * 60);

        return $result;
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
            return $this->getProductsByCompositionId()->all();
        } else {
            $composition = $this->getCompositionByProductId()->all();

            if (!empty($composition)) {
                $aliasC = preg_replace('%^.+/%iu', '', trim(Yii::$app->request->url, '/'));

                if ($aliasC && !empty($composition[$aliasC])) {
                    $id_compos = $composition[$aliasC]->id;
                } else {
                    $id_compos = $composition[key($composition)]->id;
                }

                $model = self::findBase()->byID($id_compos)->one();

                if ($model != null && !empty($model->elementsComposition)) {
                    return $model->elementsComposition;
                }
            }

            return [];
        }
    }
}
