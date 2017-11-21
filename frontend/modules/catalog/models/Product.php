<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;

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
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy(self::tableName() . '.id DESC')
            ->enabled()
            ->asArray();
    }

    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy('updated_at DESC')
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


            $img_path = explode('/', $image_link);
            $img = $img_path[count($img_path)-1];
            unset($img_path[count($img_path)-1]);
//            $dir    = $path . '/' . implode('/' ,$exp);
//            $files = scandir($dir);

            $image = $url . '/' . implode('/', $img_path) . '/thumb_' . $img;
        }

        // resize
//        $ImageResize = new ImageResize($path, $url);
//        $image = $ImageResize->getThumb($image, 340, 340);

        return $image;
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl(string $alias)
    {
        return Url::toRoute(['/catalog/product/view', 'alias' => $alias], true);
    }

    /**
     * @param array $model
     * @param array $types
     * @param array $collections
     * @return string
     */
    public static function getTitle(array $model, $types = null, $collections = null)
    {
        // TODO: !!!

//        $title = (($this->catalog_type_id > 0 && !empty($this->types)) ? $this->types->lang->title . ' ' : '');
//        $title .= (($this->collections_id > 0 && !empty($this->collection)) ? $this->collection->lang->title . ' ' : '');
//        $title .= ((!$this->is_composition && !empty($this->article)) ? $this->article . ' ' : '');
//        $title = (($this->is_composition) ? $this->getСompositionTitle() : '') . $title;

        $title = '';

        if ($types)
            $title .= $types['lang']['title'] . ' ';

        if ($collections)
            $title .= $collections['lang']['title'] . ' ';

        if (!$model['is_composition'])
            $title .= $model['article'];

        if ($model['is_composition'])
            $title = 'КОМПОЗИЦИЯ ' . $title;


        return $title;
    }

    public function getFullTitle()
    {
        $title = (($this->catalog_type_id > 0 && !empty($this->types)) ? $this->types->lang->title . ' ' : '');
        $title .= (($this->factory_id > 0 && !empty($this->factory)) ? $this->factory->lang->title . ' ' : '');
        $title .= (($this->collections_id > 0 && !empty($this->collection)) ? $this->collection->lang->title . ' ' : '');
        $title .= ((!$this->is_composition && !empty($this->article)) ? $this->article . ' ' : '');

        if ($this->is_composition && $this->category[0]->lang->composition_title !== null) {
            $title = $this->category[0]->lang->composition_title . ' ' . $title;
        } elseif ($this->is_composition) {
            $title = 'КОМПОЗИЦИЯ ' . $title;
        }

        return $title;
    }

    /**
     * @param $collections_id
     * @param $catalog_type_id
     * @return mixed
     */
    public static function getProductByCollection(int $collections_id, int $catalog_type_id)
    {
        //TODO Переделать
        return parent::findBase()
            ->enabled()
            ->andFilterWhere([
                'collections_id' => $collections_id,
                'catalog_type_id' => $catalog_type_id
            ])
            //->orderBy('RAND()')
            ->limit(12)
            ->all();
    }

    /**
     * @param $factory_id
     * @param $catalog_type_id
     * @return mixed
     */
    public static function getProductByFactory($factory_id, $catalog_type_id)
    {
        return parent::findBase()
            ->enabled()
            ->andFilterWhere([
                'factory_id' => $factory_id,
                'catalog_type_id' => $catalog_type_id
            ])
            //->orderBy('RAND()')
            ->limit(12)
            ->all();
    }
}