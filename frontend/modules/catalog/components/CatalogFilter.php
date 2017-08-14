<?php

namespace frontend\modules\catalog\components;

use Yii;
use yii\helpers\Url;
use yii\base\{
    Component
};
use yii\web\NotFoundHttpException;
use frontend\modules\catalog\models\{
    Product, Category, Factory, Types, Specification, Collection
};

/**
 * Class CatalogFilter
 *
 * @package frontend\modules\catalog\components
 */
class CatalogFilter extends Component
{
    const AMPERSAND_1 = '--';

    const AMPERSAND_2 = '-';

    private static $_parameters = [];

    private static $_structure = [];

    static $keys = [
        'category',
        'type',
        'style',
        'factory',
        'collection',
        'd',
        'dp',
        'ed',
        'el',
        'h',
        'id',
        'il',
        'l',
        'm',
        'price',
        'city',
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
     * @param $key
     * @param $value
     * @return string
     */
    public function createUrl($key, $value)
    {
        $labelEmptyKey = self::getLabelEmptyKey();

        $_structure = [];

        foreach ($labelEmptyKey as $Lk => $Lv) {
            if (isset(self::$_parameters[$Lk]) && ($value == self::$_parameters[$Lk]['alias'])) {
                // если есть значение в $_parameters и $value == self::$_parameters[$Lk]['alias']
                $_structure[$Lk] = '';
            } elseif ($Lk == $key) {
                // если $Lk == $key
                $_structure[$Lk][0] = $value;
            } elseif (isset(self::$_parameters[$Lk])) {
                // если есть значение в $_parameters
                $_structure[$Lk][0] = self::$_parameters[$Lk]['alias'];
            } else {
                // значение по умолчанию
                $_structure[$Lk]= '';
            }
        }

        /* Видалення пустих елементів з кінця масиву */
        {
            $count = count($_structure)-1;
            for (; $count >= 0; $count--) {
                if (end($_structure)) {
                    break;
                } else {
                    unset($_structure[key($_structure)]);
                }
            }
        }

        $filter = '';

        foreach ($_structure as $k => $v) {
            $res[$k] = '';

            if (is_array($v)) {
                $res[$k] = implode(self::AMPERSAND_2, $v);
            } else {
                $res[$k] = $v;
            }
            $filter .=
                (($filter) ? self::AMPERSAND_1 : '')
                . (($res[$k]) ? $res[$k] : ((!empty($labelEmptyKey[$k])) ? $labelEmptyKey[$k] : ''));
        }

        if ($filter !== '') {
            return Url::toRoute(['/catalog/category/list', 'filter' => $filter]);
        } else {
            return Url::toRoute(['/catalog/category/list']);
        }
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
     * @return array
     */
    private static function getLabelEmptyKey()
    {
        return [
            self::$keys[0] => 'c',
            self::$keys[1] => 't',
            self::$keys[2] => 's',
            self::$keys[3] => 'f',
            self::$keys[4] => 'c',
            self::$keys[5] => 'd',
            self::$keys[6] => 'dp',
            self::$keys[7] => 'ed',
            self::$keys[8] => 'el',
            self::$keys[9] => 'h',
            self::$keys[10] => 'id',
            self::$keys[11] => 'il',
            self::$keys[12] => 'l',
            self::$keys[13] => 'm',
            self::$keys[14] => 'price',
            self::$keys[15] => 'city',
        ];
    }

    /**
     * Parser upl
     */
    private function _parserUrl()
    {
        /* Розбиття на елементи */
        $elements = explode(self::AMPERSAND_1, Yii::$app->request->get('filter'));

        foreach ($elements as $k => $v) {
            if ($v) {
                /* Розбиття параметрів елементів */
                $elements[$k] = explode(self::AMPERSAND_2, $v);

                /* якщо значення співнадає із значенням масиву  */
                if (!empty($elements[$k][0]) && in_array($elements[$k][0], self::getLabelEmptyKey()))
                    $elements[$k] = array();
            }
        }

        foreach (self::$keys as $key => $value) {
            if (!empty($elements[$key]) && $value !== '') {
                self::$_structure[$value] = $elements[$key];
            }
        }

        if (!empty(self::$_structure['category'])) {
            $model = Category::findByAlias(self::$_structure['category'][0]);

            if ($model === null) {
                throw new NotFoundHttpException;
            }

            self::$_parameters['category'] = $model;
        }

        if (!empty(self::$_structure['type'])) {
            $model = Types::findByAlias(self::$_structure['type'][0]);

            if ($model === null) {
                throw new NotFoundHttpException;
            }

            self::$_parameters['type'] = $model;
        }

        if (!empty(self::$_structure['style'])) {
            $model = Specification::findByAlias(self::$_structure['style'][0]);

            if ($model === null) {
                throw new NotFoundHttpException;
            }

            self::$_parameters['style'] = $model;
        }

        if (!empty(self::$_structure['factory'])) {
            $model = Factory::findByAlias(self::$_structure['factory'][0]);

            if ($model === null) {
                throw new NotFoundHttpException;
            }

            self::$_parameters['factory'] = $model;
        }
    }
}