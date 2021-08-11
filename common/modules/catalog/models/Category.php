<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use voskobovich\behaviors\ManyToManyBehavior;
use common\modules\catalog\Catalog;
use common\actions\upload\UploadBehavior;
use thread\app\base\models\ActiveRecord;

/**
 * Class Category
 *
 * @property integer $id
 * @property string $alias
 * @property string $alias_en
 * @property string $alias_it
 * @property string $alias_de
 * @property string $alias_fr
 * @property string $alias_he
 * @property string $image_link
 * @property string $image_link2
 * @property string $image_link3
 * @property string $image_link_com
 * @property string $image_link2_com
 * @property string $image_link_home
 * @property integer $position
 * @property integer $popular
 * @property integer $popular_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property CategoryLang $lang
 * @property TypesRelCategory[] $types
 *
 * @package common\modules\catalog\models
 */
class Category extends ActiveRecord
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_group}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'types_ids' => 'types',
                ],
            ],
            'uploadBehavior' => [
                'class' => UploadBehavior::class,
                'attributes' => [
                    'image_link' => [
                        'path' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                    ],
                    'image_link2' => [
                        'path' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                    ],
                    'image_link3' => [
                        'path' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                    ],
                    'image_link_com' => [
                        'path' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                    ],
                    'image_link2_com' => [
                        'path' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                    ],
                    'image_link_home' => [
                        'path' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getCategoryUploadPath(),
                    ],
                ]
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he'], 'required'],
            [['created_at', 'updated_at', 'position', 'product_count'], 'integer'],
            [['published', 'deleted', 'popular', 'popular_by'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [[
                'alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he',
                'image_link', 'image_link2', 'image_link3', 'image_link_com', 'image_link2_com', 'image_link_home'
            ], 'string', 'max' => 255],
            [['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he'], 'unique'],
            [['position', 'product_count'], 'default', 'value' => '0'],
            [['types_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'popular' => ['popular'],
            'popular_by' => ['popular_by'],
            'deleted' => ['deleted'],
            'position' => ['position'],
            'product_count' => ['product_count'],
            'backend' => [
                'product_count',
                'alias',
                'alias_en',
                'alias_it',
                'alias_de',
                'alias_fr',
                'alias_he',
                'image_link',
                'image_link2',
                'image_link3',
                'image_link_com',
                'image_link2_com',
                'image_link_home',
                'popular',
                'popular_by',
                'position',
                'published',
                'deleted',
                'types_ids'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'alias_en' => 'Alias for en',
            'alias_it' => 'Alias for it',
            'alias_de' => 'Alias for de',
            'alias_fr' => 'Alias for fr',
            'alias_he' => 'Alias for he',
            'image_link' => Yii::t('app', 'Image link'),
            'image_link2' => 'Вторая картинка',
            'image_link3' => 'Иконка для главного меню',
            'image_link_com' => 'Изображение для .com',
            'image_link2_com' => 'Вторая картинка для .com',
            'image_link_home' => 'Картинка на главной',
            'position' => Yii::t('app', 'Position'),
            'popular' => 'Популярный Ru',
            'popular_by' => 'Популярный By',
            'product_count' => 'product_count',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'types_ids' => Yii::t('app', 'Types'),
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang'])->orderBy(self::tableName() . '.position');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CategoryLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTypes()
    {
        return $this
            ->hasMany(Types::class, ['id' => 'type_id'])
            ->viaTable(TypesRelCategory::tableName(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getProduct()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'catalog_item_id'])
            ->viaTable(ProductRelCategory::tableName(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getSale()
    {
        return $this
            ->hasMany(Sale::class, ['id' => 'sale_item_id'])
            ->viaTable(SaleRelCategory::tableName(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getItalianProduct()
    {
        return $this
            ->hasMany(ItalianProduct::class, ['id' => 'item_id'])
            ->viaTable(ItalianProductRelCategory::tableName(), ['group_id' => 'id']);
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }

        return $image;
    }

    /**
     * @return null|string
     */
    public function getImageLink2()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();

        $image = null;

        if (!empty($this->image_link2) && is_file($path . '/' . $this->image_link2)) {
            $image = $url . '/' . $this->image_link2;
        }

        return $image;
    }

    /**
     * @return null|string
     */
    public function getImageLink3()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();

        $image = null;

        if (!empty($this->image_link3) && is_file($path . '/' . $this->image_link3)) {
            $image = $url . '/' . $this->image_link3;
        }

        return $image;
    }

    /**
     * @return null|string
     */
    public function getImageLinkCom()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();

        $image = null;

        if (!empty($this->image_link_com) && is_file($path . '/' . $this->image_link_com)) {
            $image = $url . '/' . $this->image_link_com;
        }

        return $image;
    }

    /**
     * @return null|string
     */
    public function getImageLink2Com()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();

        $image = null;

        if (!empty($this->image_link2_com) && is_file($path . '/' . $this->image_link2_com)) {
            $image = $url . '/' . $this->image_link2_com;
        }

        return $image;
    }

    /**
     * @return null|string
     */
    public function getImageLinkHome()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();

        $image = null;

        if (!empty($this->image_link_home) && is_file($path . '/' . $this->image_link_home)) {
            $image = $url . '/' . $this->image_link_home;
        }

        return $image;
    }

    /**
     * @inheritDoc
     */
    public static function updateEnabledProductCount($id = 0)
    {
        $query = self::find();

        if ($id) {
            $query->andFilterWhere([
                self::tableName() . '.id' => $id,
            ]);
        }

        $groups = $query->all();

        foreach ($groups as $group) {
            /** @var $group self */
            $group['product_count'] = $group
                    ->getProduct()
                    ->enabled()
                    ->andFilterWhere([
                        Product::tableName() . '.removed' => '0',
                    ])
                    ->count() ?? 0;

            $group->save(false);
        }
    }
}
