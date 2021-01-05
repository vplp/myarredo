<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;
use frontend\components\ImageResize;

/**
 * Class Product
 * @property ProductRelFactoryCatalogsFiles[] $factoryCatalogsFiles
 * @property ProductRelFactoryPricesFiles[] $factoryPricesFiles
 * @property Samples[] $samples
 *
 * @package frontend\modules\catalog\models
 */
class Product extends \common\modules\catalog\models\Product
{
    public $min;

    public $max;

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
        return parent::scenarios();
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
        return parent::rules();
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        $query = self::find()
            ->innerJoinWith(['lang', 'factory'])
            ->andFilterWhere([
                Product::tableName() . '.removed' => '0',
                Factory::tableName() . '.published' => '1',
                Factory::tableName() . '.deleted' => '0',
                //Factory::tableName() . '.show_for_' . DOMAIN_TYPE => '1',
            ])
            ->enabled()
            ->orderBy(self::tableName() . '.updated_at DESC');

        return $query;
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
                //Factory::tableName() . '.show_for_' . DOMAIN_TYPE => '1',
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
     * @param $alias
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function findByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::find()
                ->innerJoinWith(['lang', 'factory'])
                ->andWhere([self::tableName() . '.' . Yii::$app->languages->getDomainAlias() => $alias])
                //->byAlias($alias)
                ->enabled()
                ->one();
        }, 7200);

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByID($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findBaseArray()->byId($id)->one();
        }, 7200);

        return $result;
    }

    /**
     * @param $ids
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByIDs($ids): array
    {
        $result = self::getDb()->cache(function ($db) use ($ids) {
            return self::findBase()->andWhere(['IN', self::tableName() . '.id', array_unique($ids)])->all();
        }, 7200);

        return $result;
    }

    /**
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findLastUpdated()
    {
        $result = self::getDb()->cache(function ($db) {
            return self::findBaseArray()
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.factory_id',
                    self::tableName() . '.updated_at',
                    ProductLang::tableName() . '.title',
                    ProductLang::tableName() . '.description'
                ])
                ->orderBy([self::tableName() . '.updated_at' => SORT_DESC])
                ->limit(1)
                ->one();
        },7200);

        return $result;
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
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::class, ['id' => 'collections_id'])->enabled();
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
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryCatalogsFiles()
    {
        return $this
            ->hasMany(FactoryCatalogsFiles::class, ['id' => 'factory_file_id'])
            ->viaTable(ProductRelFactoryCatalogsFiles::tableName(), ['catalog_item_id' => 'id'])
            ->published();
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryPricesFiles()
    {
        return $this
            ->hasMany(FactoryPricesFiles::class, ['id' => 'factory_file_id'])
            ->viaTable(ProductRelFactoryPricesFiles::tableName(), ['catalog_item_id' => 'id'])
            ->published();
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
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $url . '/' . $image_link;
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
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $ImageResize->getThumb($image, $width, $height);
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
                    'img' => 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $url . '/' . $image,
                    'thumb' => self::getImageThumb($image, 600, 600)
                ];
            } else {
                $imagesSources[] = [
                    'img' => 'https://img.myarredo.ru/' . $url . '/' . $image,
                    'thumb' => 'https://img.myarredo.ru/' . $url . '/' . $image,
                ];
            }
        }

        return $imagesSources;
    }

    /**
     * @param $alias
     * @param bool $scheme
     * @return string
     */
    public static function getUrl($alias, $scheme = true)
    {
        if (isset(Yii::$app->controller->factory)) {
            return Url::toRoute([
                '/catalog/template-factory/product',
                'alias' => Yii::$app->controller->factory->alias,
                'product' => $alias
            ], $scheme);
        } else {
            return Url::toRoute([
                '/catalog/product/view',
                'alias' => $alias
            ], $scheme);
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->lang->title ?? '{{-}}';
    }

    /**
     * @param $model
     * @return string
     */
    public static function getImageAlt($model)
    {
        $alt = [];

        if (!empty($model['types'])) {
            $alt[] = $model['types']['lang']['title'];
        }

        if (!empty($model['factory'])) {
            $alt[] = $model['factory']['title'];
        }

        if ($model['article']) {
            $alt[] = $model['article'];
        }

        if ($model['collection']) {
            $alt[] = $model['collection']['title'];
        }

        return implode(' ', $alt);
    }

    /**
     * @param $model
     * @return string
     */
    public static function getStaticTitle($model)
    {
        return $model['lang']['title'] != ''
            ? $model['lang']['title']
            : '{{-}}';
    }

    /**
     * @param $model
     * @return string
     */
    public static function getStaticTitleForList($model)
    {
        return $model['lang']['title_for_list'] != ''
            ? $model['lang']['title_for_list']
            : self::getStaticTitle($model);
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
                    self::tableName() . '.alias_en',
                    self::tableName() . '.alias_it',
                    self::tableName() . '.alias_de',
                    self::tableName() . '.alias_he',
                    self::tableName() . '.image_link',
                    self::tableName() . '.factory_id',
                    ProductLang::tableName() . '.title',
                ])
                ->andFilterWhere([
                    Product::tableName() . '.removed' => '0'
                ])
                ->enabled()
                ->andWhere([
                    self::tableName() . '.collections_id' => $collections_id,
                ])
                ->andFilterWhere(['NOT IN', self::tableName() . '.alias', Yii::$app->request->get('alias')])
                ->limit(12)
                ->all();
        }, 7200);

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
                    self::tableName() . '.alias_en',
                    self::tableName() . '.alias_it',
                    self::tableName() . '.alias_de',
                    self::tableName() . '.alias_he',
                    self::tableName() . '.image_link',
                    self::tableName() . '.factory_id',
                    ProductLang::tableName() . '.title',
                ])
                ->andFilterWhere([
                    Product::tableName() . '.removed' => '0'
                ])
                ->enabled()
                ->andWhere([
                    self::tableName() . '.factory_id' => $factory_id,
                    self::tableName() . '.catalog_type_id' => $catalog_type_id
                ])
                ->andFilterWhere(['NOT IN', self::tableName() . '.alias', Yii::$app->request->get('alias')])
                ->limit(12)
                ->all();
        }, 7200);

        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
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

    /**
     * @param array $params
     * @param bool $isCountriesFurniture
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getPriceRange($params = [], $isCountriesFurniture = false)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBaseWithoutLang();

        if ($isCountriesFurniture) {
            $query->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]]);
        } else {
            $query->andFilterWhere(['IN', Factory::tableName() . '.producing_country_id', [4]]);
        }

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"], false)
                ->andFilterWhere([
                    'IN',
                    Category::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"], false)
                ->andFilterWhere([
                    'IN',
                    Types::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["subTypes"], false)
                ->andFilterWhere(['IN', SubTypes::tableName() . '.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"], false)
                ->andFilterWhere([
                    'IN',
                    Specification::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"], false)
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(["collection"], false)
                ->andFilterWhere(['IN', Collection::tableName() . '.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"], false)
                ->andFilterWhere(['IN', Colors::tableName() . '.' . Yii::$app->languages->getDomainAlias(), $params[$keys['colors']]]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->select([
                    self::tableName() . '.factory_id',
                    'max(' . self::tableName() . '.price_from) as max',
                    'min(' . self::tableName() . '.price_from) as min'
                ])
                ->asArray()
                ->one();
        }, 7200);

        return $result;
    }
}
