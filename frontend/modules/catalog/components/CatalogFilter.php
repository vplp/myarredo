<?php

namespace frontend\modules\catalog\components;

use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\base\Component;
use yii\web\NotFoundHttpException;
use frontend\modules\catalog\models\{
    Category,
    Factory,
    Types,
    SubTypes,
    Specification,
    Collection,
    Colors
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
    /** delimiter */
    const AMPERSAND_1 = '--';

    /** delimiter */
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
        'country' => '.60',
        //'city' => '.70',
        'colors' => '.80',
        'subtypes' => '.90',
        'price' => '.91',
        'diameter' => '.92',
        'width' => '.93',
        'length' => '.94',
        'height' => '.95',
        'apportionment' => '.96',
        'producing_country' => '.97'
    ];

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
            //self::$keys['city'] => 'city',
            self::$keys['country'] => 'country',
            self::$keys['colors'] => 'colors',
            self::$keys['subtypes'] => 'st',
            self::$keys['price'] => 'price',
            self::$keys['diameter'] => 'diameter',
            self::$keys['width'] => 'width',
            self::$keys['length'] => 'length',
            self::$keys['height'] => 'height',
            self::$keys['apportionment'] => 'apportionment',
            self::$keys['producing_country'] => 'producing_country',
        ];
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

        $count = count($paramsUrl) - 1;
        for (; $count >= 0; $count--) {
            if (end($paramsUrl)) {
                break;
            } else {
                unset($paramsUrl[key($paramsUrl)]);
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
        $res = [];

        foreach ($paramsUrl as $k => $v) {
            $res[$k] = '';

            if (is_array($v) && $k == self::$keys['price']) {
                $res[$k] = 'price=' . implode(self::AMPERSAND_2, $v);
            } elseif (is_array($v) && $k == self::$keys['diameter']) {
                $res[$k] = 'diameter=' . implode(self::AMPERSAND_2, $v);
            } elseif (is_array($v) && $k == self::$keys['width']) {
                $res[$k] = 'width=' . implode(self::AMPERSAND_2, $v);
            } elseif (is_array($v) && $k == self::$keys['length']) {
                $res[$k] = 'length=' . implode(self::AMPERSAND_2, $v);
            } elseif (is_array($v) && $k == self::$keys['height']) {
                $res[$k] = 'height=' . implode(self::AMPERSAND_2, $v);
            } elseif (is_array($v) && $k == self::$keys['apportionment']) {
                $res[$k] = 'apportionment=' . implode(self::AMPERSAND_2, $v);
            } elseif (is_array($v)) {
                $res[$k] = implode(self::AMPERSAND_2, $v);
            } else {
                $res[$k] = $v;
            }

            $url .=
                (($url) ? self::AMPERSAND_1 : '') .
                (($res[$k]) ? $res[$k] : ((!empty($labelEmptyKey[$k])) ? $labelEmptyKey[$k] : ''));
        }

        if (!empty($route) && $url !== '') {
            return Url::toRoute($route) . $url . '/';
        } elseif (empty($route) && $url !== '') {
            return $url . '/';
        } else {
            return Url::toRoute($route);
        }
    }

    /**
     * Parser url
     *
     * @param string $url
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function parserUrl($url = '')
    {
        $url = $url ? $url : Yii::$app->request->get('filter');

        $elements = explode(self::AMPERSAND_1, $url);

        foreach ($elements as $k => $v) {
            if ($v) {
                $elements[$k] = explode(self::AMPERSAND_2, $v);

                // якщо значення співнадає із значенням масиву
                if (!empty($elements[$k][0]) && in_array($elements[$k][0], $this->getLabelEmptyKey())) {
                    $elements[$k] = [];
                }
            }
        }

//        if (count($elements) > 1 && empty(end($elements))) {
//            $key = array_key_last($elements);
//            $labelEmptyKey = array_values($this->getLabelEmptyKey());
//            $url = str_replace(self::AMPERSAND_1 . $labelEmptyKey[$key], '', $url);
//
//            Yii::$app->response->redirect(Url::toRoute(['/catalog/category/list', 'filter' => $url]), 301);
//            Yii::$app->end();
//        } elseif (count($elements) == 1 && empty(end($elements)) && Yii::$app->request->get('filter')) {
//            ///* !!! */ echo  '<pre style="color:red;">'; print_r(end($elements)); echo '</pre>'; /* !!! */
//            Yii::$app->response->redirect(Url::toRoute(['/catalog/category/list']), 301);
//            Yii::$app->end();
//        }

        $i = 0;
        foreach (self::$keys as $key => $value) {
            if (!empty($elements[$i])) {
                self::$_structure[$key] = $elements[$i];
            }
            ++$i;
        }

        /** Category */

        if (!empty(self::$_structure['category'])) {
            $model = Category::findByAlias(self::$_structure['category'][0]);

            if ($model == null || count(self::$_structure['category']) > 1) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            $alias = $model[Yii::$app->languages->getDomainAlias()];

            self::$_parameters[self::$keys['category']][] = $alias;
        }

        /** Type */

        if (!empty(self::$_structure['type'])) {
            $model = Types::findBase()
                ->andWhere([
                    'IN',
                    Types::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    self::$_structure['type']
                ])
                ->indexBy('id')
                ->orderBy(Types::tableName() . '.' . Yii::$app->languages->getDomainAlias())
                ->all();

            if (count(self::$_structure['type']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            // sort value

            foreach ($model as $obj) {
                self::setParam(self::$keys['type'], $obj[Yii::$app->languages->getDomainAlias()]);
            }

            // check value

            $result = array_diff_assoc(self::$_structure['type'], self::$_parameters[self::$keys['type']]);

            if (!empty($result)) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }
        }

        /** SubTypes */

        if (!empty(self::$_structure['subtypes'])) {
            $model = SubTypes::findBase()
                ->andWhere(['IN', SubTypes::tableName() . '.alias', self::$_structure['subtypes']])
                ->indexBy('id')
                ->orderBy(SubTypes::tableName() . '.alias')
                ->all();

            if (count(self::$_structure['subtypes']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            // sort value

            foreach ($model as $obj) {
                self::setParam(self::$keys['subtypes'], $obj['alias']);
            }

            // check value

            $result = array_diff_assoc(self::$_structure['subtypes'], self::$_parameters[self::$keys['subtypes']]);

            if (!empty($result)) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }
        }

        /** Style */

        if (!empty(self::$_structure['style'])) {
            $aliasField = Yii::$app->languages->getDomainAlias();
            $model = Specification::findBase()
                ->andFilterWhere([
                    'IN',
                    $aliasField,
                    self::$_structure['style']
                ])
                ->indexBy('id')
                ->orderBy(Specification::tableName() . '.' . $aliasField)
                ->all();

            if (count(self::$_structure['style']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            // sort value

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['style']][] = $obj[$aliasField];
            }

            // check value

            $result = array_diff_assoc(self::$_structure['style'], self::$_parameters[self::$keys['style']]);

            if (!empty($result)) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }
        }

        /** Factory */

        if (!empty(self::$_structure['factory'])) {
            $model = Factory::findBase()
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', self::$_structure['factory']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['factory']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            // sort value

            foreach ($model as $obj) {
                self::setParam(self::$keys['factory'], $obj['alias']);
            }

            // check value

            $result = array_diff_assoc(self::$_structure['factory'], self::$_parameters[self::$keys['factory']]);

            if (!empty($result)) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }
        }

        /** Collection */

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

        /** Country */

        if (!empty(self::$_structure['country'])) {
            $model = Country::findByAlias(self::$_structure['country'][0]);

            if ($model == null || count(self::$_structure['country']) > 1) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['country']][0] = $model['alias'];
        }

        /** producing_country */

        if (!empty(self::$_structure['producing_country'])) {
            $model = Country::findBase()->byAlias(self::$_structure['producing_country'][0])->one();

            if ($model == null || count(self::$_structure['producing_country']) > 1) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['producing_country']][0] = $model['alias'];
        }

        /** City */

        /*
        if (!empty(self::$_structure['city'])) {
            $model = City::findBase()
                ->innerJoinWith(["country as country"], false)
                ->andFilterWhere(['IN', 'country.alias', DOMAIN_TYPE])
                ->andFilterWhere(['IN', City::tableName() . '.alias', self::$_structure['city']])
                ->indexBy('id')
                ->all();

            if ($model == null || count(self::$_structure['city']) !== count($model)) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            // sort value

            foreach ($model as $obj) {
                self::$_parameters[self::$keys['city']][] = $obj['alias'];
            }

            // check value

            $result = array_diff_assoc(self::$_structure['city'], self::$_parameters[self::$keys['city']]);

            if (!empty($result)) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }
        }
        */

        /** Colors */

        if (!empty(self::$_structure['colors'])) {
            $aliasField = Yii::$app->languages->getDomainAlias();
            $model = Colors::findBase()
                ->andWhere(['IN', Colors::tableName() . '.' . $aliasField, self::$_structure['colors']])
                ->indexBy('id')
                ->all();

            if (count(self::$_structure['colors']) != count($model) || $model == null) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            // sort value

            foreach ($model as $obj) {
                self::setParam(self::$keys['colors'], $obj[$aliasField]);
            }

            // check value

            $result = array_diff_assoc(self::$_structure['colors'], self::$_parameters[self::$keys['colors']]);

            if (!empty($result)) {
                //throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }
        }

        /** Price */

        if (!empty(self::$_structure['price'])) {
            $data = self::$_structure['price'];
            if (strpos($data[0], 'price=') === false) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            if (count($data) != 3) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            $_data = [
                preg_replace("/[^0-9]/", '', $data[0]),
                preg_replace("/[^0-9]/", '', $data[1]),
                $data[2]
            ];

            if ($_data[0] >= $_data[1]) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            if (!in_array($_data[2], ['EUR', 'RUB'])) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['price']] = $_data;
        }

        /** Diameter */

        if (!empty(self::$_structure['diameter'])) {
            $data = self::$_structure['diameter'];
            if (strpos($data[0], 'diameter=') === false) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            if (count($data) != 2) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            $_data = [
                preg_replace("/[^0-9]/", '', $data[0]),
                preg_replace("/[^0-9]/", '', $data[1])
            ];

            if ($_data[0] >= $_data[1]) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['diameter']] = $_data;
        }

        /** width */

        if (!empty(self::$_structure['width'])) {
            $data = self::$_structure['width'];
            if (strpos($data[0], 'width=') === false) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            if (count($data) != 2) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            $_data = [
                preg_replace("/[^0-9]/", '', $data[0]),
                preg_replace("/[^0-9]/", '', $data[1])
            ];

            if ($_data[0] >= $_data[1]) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['width']] = $_data;
        }

        /** length */

        if (!empty(self::$_structure['length'])) {
            $data = self::$_structure['length'];
            if (strpos($data[0], 'length=') === false) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            if (count($data) != 2) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            $_data = [
                preg_replace("/[^0-9]/", '', $data[0]),
                preg_replace("/[^0-9]/", '', $data[1])
            ];

            /*if ($_data[0] >= $_data[1]) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }*/

            self::$_parameters[self::$keys['length']] = $_data;
        }

        /** height */

        if (!empty(self::$_structure['height'])) {
            $data = self::$_structure['height'];
            if (strpos($data[0], 'height=') === false) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            if (count($data) != 2) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            $_data = [
                preg_replace("/[^0-9]/", '', $data[0]),
                preg_replace("/[^0-9]/", '', $data[1])
            ];

            if ($_data[0] >= $_data[1]) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['height']] = $_data;
        }

        /** apportionment */

        if (!empty(self::$_structure['apportionment'])) {
            $data = self::$_structure['apportionment'];
            if (strpos($data[0], 'apportionment=') === false) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            if (count($data) != 2) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            $_data = [
                preg_replace("/[^0-9]/", '', $data[0]),
                preg_replace("/[^0-9]/", '', $data[1])
            ];

            if ($_data[0] >= $_data[1]) {
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            }

            self::$_parameters[self::$keys['apportionment']] = $_data;
        }
    }
}
