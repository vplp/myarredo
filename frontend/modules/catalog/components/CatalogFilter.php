<?php

namespace frontend\modules\catalog\components;

use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\base\Component;
use yii\web\NotFoundHttpException;
//
use frontend\modules\catalog\models\{
    Category,
    Factory,
    Types,
    Specification,
    Collection
};
use frontend\modules\location\models\{
    Country, City
};

/**
 * Class CatalogFilter
 *
 * @package frontend\modules\catalog\components
 */
class CatalogFilter extends Component
{
    /**
     * delimiter
     */
    const AMPERSAND_1 = '--';

    /**
     * delimiter
     */
    const AMPERSAND_2 = '-';

    /**
     * Filter parameters
     *
     * @var array
     */
    private static $_parameters = [];

    /**
     * Filter structure
     *
     * @var array
     */
    private static $_structure = [];

    /**
     * Filter keys
     *
     * @var array
     */
    static $keys = [
        'category' => '.10',
        'type' => '.20',
        'style' => '.30',
        'factory' => '.40',
        'collection' => '.50',
        //'price' => '.60',
        'country' => '.70',
        'city' => '.80',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return self::$_parameters;
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function setParam($name, $value)
    {
        return self::$_parameters[$name][] = $value;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return self::$keys;
    }

    /**
     * Create filter url
     *
     * @param array $paramsUrl
     * @param array $route
     * @return string
     */
    public function createUrl($paramsUrl = [], $route = ['/catalog/category/list'])
    {
        if (empty($paramsUrl)) {
            $paramsUrl = $this->getParams();
        }

        $labelEmptyKey = $this->getLabelEmptyKey();

        $structure = $this->getParams();

        $paramsUrl = array_merge($labelEmptyKey, $paramsUrl);

        $paramsUrl = array_merge($structure, $paramsUrl);

        ksort($paramsUrl, SORT_STRING);

        // Видалення пустих елементів з кінця масиву

        $reversed = array_reverse($paramsUrl);

        foreach ($reversed as $key => $val) {
            if (in_array($val, array_values($labelEmptyKey))) {
                unset($paramsUrl[$key]);
            } else {
                break;
            }
        }

        {
            $count = count($paramsUrl) - 1;
            for (; $count >= 0; $count--) {
                if (end($paramsUrl)) {
                    break;
                } else {
                    unset($paramsUrl[key($paramsUrl)]);
                }
            }
        }

        $reversed = array_reverse($paramsUrl);

        foreach ($reversed as $key => $val) {
            if (in_array($val, array_values($labelEmptyKey))) {
                unset($paramsUrl[$key]);
            } else {
                break;
            }
        }

        $url = '';

        foreach ($paramsUrl as $k => $v) {

            $res[$k] = '';

            if (is_array($v)) {
                if (isset($v['from']) && $v['from'] != '' || isset($v['to']) && $v['to'] != '')
                    $res[$k] = implode(self::AMPERSAND_2, $v);
                else if (!isset($v['from']) && !isset($v['to']))
                    $res[$k] = implode(self::AMPERSAND_2, $v);
            } else {
                $res[$k] = $v;
            }

            $url .=
                (($url) ? self::AMPERSAND_1 : '') .
                (($res[$k]) ? $res[$k] : ((!empty($labelEmptyKey[$k])) ? $labelEmptyKey[$k] : ''));
        }

        if ($url !== '') {
            return Url::toRoute($route) . $url . '/';
        } else {
            return Url::toRoute($route);
        }
    }

    /**
     * Filter stubs
     *
     * @return array
     */
    private function getLabelEmptyKey()
    {
        return [
            self::$keys['category'] => 'c',
            self::$keys['type'] => 't',
            self::$keys['style'] => 's',
            self::$keys['factory'] => 'f',
            self::$keys['collection'] => 'c',
            //self::$keys['price'] => 'price',
            self::$keys['country'] => 'country',
            self::$keys['city'] => 'city',
        ];
    }

    /**
     * Parser upl
     */
    public function parserUrl()
    {
        $elements = explode(self::AMPERSAND_1, Yii::$app->request->get('filter'));

        foreach ($elements as $k => $v) {
            if ($v) {
                $elements[$k] = explode(self::AMPERSAND_2, $v);

                // якщо значення співнадає із значенням масиву
                if (!empty($elements[$k][0]) && in_array($elements[$k][0], $this->getLabelEmptyKey())) {
                    $elements[$k] = [];
                }
            }
        }

        if (count($elements) > 1 && empty(end($elements))) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $i = 0;
        foreach (self::$keys as $key => $value) {
            if (!empty($elements[$i])) {
                self::$_structure[$key] = $elements[$i];
            }
            ++$i;
        }

        /**
         * Category
         */

        if (!empty(self::$_structure['category'])) {
            $model = Category::findByAlias(self::$_structure['category'][0]);

            if ($model == null || count(self::$_structure['category']) > 1) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['category']][] = $model['alias'];
        }

        /**
         * Type
         */

        if (!empty(self::$_structure['type'])) {

            $model = Types::findBase()
                ->andWhere(['IN', 'alias', self::$_structure['type']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['type']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['type']][] = $obj['alias'];
            }
        }

        /**
         * Style
         */

        if (!empty(self::$_structure['style'])) {
            $model = Specification::findBase()
                ->andFilterWhere(['IN', 'alias', self::$_structure['style']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['style']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['style']][] = $obj['alias'];
            }
        }

        /**
         * Factory
         */

        if (!empty(self::$_structure['factory'])) {
            $model = Factory::findBase()
                ->andFilterWhere(['IN', Factory::tableName().'.alias', self::$_structure['factory']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['factory']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['factory']][] = $obj['alias'];
            }
        }

        /**
         * Collection
         */

        if (!empty(self::$_structure['collection'])) {
            $model = Collection::findBase()
                ->andWhere(['IN', Collection::tableName() . '.id', self::$_structure['collection']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['collection']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['collection']][] = $obj['id'];
            }
        }

        /**
         * Country
         */

        if (!empty(self::$_structure['country'])) {
            $model = Country::findByAlias(self::$_structure['country'][0]);

            if ($model == null || count(self::$_structure['country']) > 1) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['country']][0] = $model['alias'];
        }

        /**
         * City
         */

        if (!empty(self::$_structure['city']) && !empty(self::$_structure['country'])) {

            $model = City::findBase()
                ->innerJoinWith(["country as country"], false)
                ->andFilterWhere(['IN', 'country.alias', self::$_structure['country']])
                ->andFilterWhere(['IN', City::tableName() . '.alias', self::$_structure['city']])
                ->indexBy('id')
                ->all();

            if ($model == null || count(self::$_structure['city']) !== count($model)) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['city']][] = $obj['alias'];
            }
        }
    }
}
