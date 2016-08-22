<?php

namespace thread\modules\menu\models;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\menu\Menu as MenuModule;

/**
 * Class MenuItem
 *
 * @property integer $id
 * @property string $alias
 * @property integer $group_id
 * @property integer $parent_id
 * @property string $type
 * @property string $link
 * @property string $link_type
 * @property string $link_target
 * @property string $internal_source
 * @property integer $internal_source_id
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property Menu $menu
 * @property MenuItemLang $lang
 * @property MenuItem[] $items
 *
 * @package thread\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MenuItem extends ActiveRecord
{

    /**
     * Переопределяем active query
     * @var
     */
    public static $commonQuery = query\ActiveQuery::class;

    /**
     * @var array
     */
    protected static $sources = [];

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return Menu::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%menu_item}}';
    }

    public function init()
    {
        self::getInternalSourcesFromModule();
        parent::init();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['group_id, type'], 'required'],
            [['created_at', 'updated_at', 'group', 'position', 'group_id', 'parent_id'], 'integer'],
            //
            [['type'], 'in', 'range' => array_keys(static::typeRange())],
            ['type', 'default', 'value' => array_keys(static::typeRange())[0]],
            //
            [['link_type'], 'in', 'range' => array_keys(static::linkTypeRange())],
            ['link_type', 'default', 'value' => array_keys(static::linkTypeRange())[0]],
            //
            [['link_target'], 'in', 'range' => array_keys(static::linkTargetRange())],
            ['link_target', 'default', 'value' => array_keys(static::linkTargetRange())[0]],
            //
            ['internal_source', 'default', 'value' => ['page_page']],
            //
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['link', 'internal_source'], 'string', 'max' => 255],
            //default
            [['type'], 'default', 'value' => 'normal'],
            [['position', 'parent_id'], 'default', 'value' => '0']
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'order' => ['position'],
            'backend' => [
                'link',
                'group_id',
                'type',
                'published',
                'deleted',
                'position',
                'internal_source',
                'internal_source_id',
                'link_target',
                'link_type',
                'parent_id'
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
            'group_id' => Yii::t('app', 'Menu'),
            'parent_id' => Yii::t('app', 'Parent'),
            'type' => Yii::t('app', 'Type'),
            'link' => Yii::t('app', 'Link'),
            'link_type' => Yii::t('app', 'Link type'),
            'link_target' => Yii::t('app', 'Link Target'),
            'internal_source' => Yii::t('app', 'Internal Source'),
            'internal_source_id' => Yii::t('app', 'Internal Source Id'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'group_id'])->undeleted();
    }

    /**
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(MenuItemLang::class, ['rid' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])->undeleted();
    }

    /**
     * @return ActiveQuery
     */
    public function getSource()
    {
        if (!isset(self::$sources[$this->internal_source])) {
            return null;
        }
        return $this->hasOne(self::$sources[$this->internal_source]['class'], ['id' => 'internal_source_id']);
    }

    /**
     * @return array
     */
    public static function getInternalSourcesFromModule()
    {
        /** @var MenuModule $module */
        $module = Yii::$app->getModule('menu');
        $module->setInternalSourse();
        self::$sources = $module->internal_sources_list;
    }

    /**
     * @return array
     */
    public static function getTypeSources()
    {
        return ArrayHelper::map(self::$sources, 'key', 'label');
    }

    /**
     * @return array
     */
    public static function getSourcesList()
    {
        return self::$sources;
    }

    /**
     * Варіанти типів елементів меню
     * Значення параметра type
     * @return array
     */
    public static function typeRange()
    {
        return [
            'normal' => Yii::t('app', 'Default'),
            'divider' => Yii::t('app', 'Divider'),
            'header' => Yii::t('app', 'Header'),
        ];
    }

    /**
     * Варіанти типів посилань елементів
     * Значення параметра link_type
     * @return array
     */
    public static function linkTypeRange()
    {
        return [
            'external' => Yii::t('app', 'External'),
            'internal' => Yii::t('app', 'Internal'),
        ];
    }

    /**
     * Варіанти типів відкриття посилань посилань елементів
     * Значення параметра link_type
     * @return array
     */
    public static function linkTargetRange()
    {
        return [
            '_blank' => Yii::t('app', '_blank'),
            '_self' => Yii::t('app', '_self'),
        ];
    }

    /**
     *
     * @return string
     */
    public function getLink()
    {
        if ($this->link_type == 'internal' && isset($this->source)) {
            return $this->source->getUrl();
        } else {
            return $this->link;
        }
    }
}
