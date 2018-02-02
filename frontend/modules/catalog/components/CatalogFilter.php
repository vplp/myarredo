<?php

namespace frontend\modules\catalog\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\base\Component;
use yii\web\NotFoundHttpException;
use frontend\modules\catalog\models\{
    Product,
    Category,
    Factory,
    Types,
    Specification,
    Collection
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
//        'd' => 'd',
//        'dp' => 'dp',
//        'ed' => 'ed',
//        'el' => 'el',
//        'h' => 'h',
//        'id' => 'id',
//        'il' => 'il',
//        'l' => 'l',
//        'm' => 'm',
        'price' => 'p',
//        'city' => 'city',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->_parserUrl();
    }

    /**
     * Filter params
     *
     * @return array
     */
    public function getParams()
    {
        return self::$_parameters;
    }

    /**
     * Filter params
     *
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
        $labelEmptyKey = $this->getLabelEmptyKey();

        $structure = $this->getParams();

        $paramsUrl = array_merge($labelEmptyKey, $paramsUrl);

        $paramsUrl = array_merge($structure, $paramsUrl);

        ksort($paramsUrl, SORT_STRING);

        // Видалення пустих елементів з кінця масиву
        {
            $count = count($paramsUrl) - 1;
            for (; ; $count--) {
                if (!in_array(end($paramsUrl), array_values($labelEmptyKey))) {
                    break;
                } else {
                    unset($paramsUrl[key($paramsUrl)]);
                }
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
                else
                    $res[$k] = implode(self::AMPERSAND_2, $v);
            } else {
                $res[$k] = $v;
            }

            $url .=
                (($url) ? self::AMPERSAND_1 : '') .
                (($res[$k]) ? $res[$k] : ((!empty($labelEmptyKey[$k])) ? $labelEmptyKey[$k] : ''));
        }

        if ($url !== '') {
            return Url::toRoute(ArrayHelper::merge($route, ['filter' => $url]));
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
//            self::$keys['d'] => 'd',
//            self::$keys['dp'] => 'dp',
//            self::$keys['ed'] => 'ed',
//            self::$keys['el'] => 'el',
//            self::$keys['h'] => 'h',
//            self::$keys['id'] => 'id',
//            self::$keys['il'] => 'il',
//            self::$keys['l'] => 'l',
//            self::$keys['m'] => 'm',
            self::$keys['price'] => 'price',
//            self::$keys['city'] => 'city',
        ];
    }

    /**
     * Parser upl
     */
    private function _parserUrl()
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

        $i = 0;
        foreach (self::$keys as $key => $value) {
            if (!empty($elements[$i])) {
                self::$_structure[$key] = $elements[$i];
            }
            ++$i;
        }

        if (!empty(self::$_structure['category'])) {
            $model = Category::findByAlias(self::$_structure['category'][0]);

            if ($model === null || count(self::$_structure['category']) > 1) {
                throw new NotFoundHttpException;
            }

            self::$_parameters[self::$keys['category']][] = $model['alias'];
        }

        if (!empty(self::$_structure['type'])) {

            $model = Types::findBase()
                ->andWhere(['IN', 'alias', self::$_structure['type']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['type']) !== count($model) || $model === null) {
                throw new NotFoundHttpException;
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['type']][] = $obj['alias'];
            }
        }

        if (!empty(self::$_structure['style'])) {
            $model = Specification::findBase()
                ->andFilterWhere(['IN', 'alias', self::$_structure['style']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['style']) !== count($model) || $model === null) {
                throw new NotFoundHttpException;
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['style']][] = $obj['alias'];
            }
        }

        if (!empty(self::$_structure['factory'])) {
            $model = Factory::findBase()
                ->andFilterWhere(['IN', 'alias', self::$_structure['factory']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['factory']) !== count($model) || $model === null) {
                throw new NotFoundHttpException;
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['factory']][] = $obj['alias'];
            }
        }

        if (!empty(self::$_structure['collection'])) {
            $model = Collection::findBase()
                ->andWhere(['IN', 'id', self::$_structure['collection']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['collection']) !== count($model) || $model === null) {
                throw new NotFoundHttpException;
            }

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['collection']][] = $obj['id'];
            }
        }
    }
}
