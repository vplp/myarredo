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

    private static $params = [];

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
     * Create Url
     *
     * @param string $key
     * @return string
     */
    public function createUrl($key, $value)
    {
        $filter = '';
        $_filter = [];

        if ($key == 'category') {
            $_filter[] = $value;
        } elseif (isset(self::$params['category'])) {
            $_filter[] = self::$params['category']['alias'];
        } else {
            $_filter[] = 'c';
        }

        if ($key == 'type') {
            $_filter[] = $value;
        } elseif (isset(self::$params['type'])) {
            $_filter[] = self::$params['type']['alias'];
        } else {
            $_filter[] = 't';
        }

        if ($key == 'style') {
            $_filter[] = $value;
        } elseif (isset(self::$params['style'])) {
            $_filter[] = self::$params['style']['alias'];
        } else {
            $_filter[] = 's';
        }

        if ($key == 'factory') {
            $_filter[] = $value;
        } elseif (isset(self::$params['factory'])) {
            $_filter[] = self::$params['factory']['alias'];
        } else {
            $_filter[] = 'f';
        }

        $filter = implode(self::AMPERSAND_1, $_filter);

        return Url::toRoute(['/catalog/category/list', 'filter' => $filter]);
    }

    /**
     * Filter params
     *
     * @return array
     */
    public function getParams()
    {
        return self::$params;
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

        $structure = [];
        foreach (self::$keys as $key => $value) {
            if (isset($elements[$key])) {
                $structure[$value] = $elements[$key];
            }
        }

        if (!empty($structure['category'])) {
            $model = Category::findByAlias($structure['category'][0]);

            if ($model === null) {
                throw new NotFoundHttpException;
            }

            self::$params['category'] = $model;
        }

        if (!empty($structure['type'])) {
            $model = Types::findByAlias($structure['type'][0]);

            if ($model === null) {
                throw new NotFoundHttpException;
            }

            self::$params['type'] = $model;
        }

        if (!empty($structure['style'])) {
            $model = Specification::findByAlias($structure['style'][0]);

            if ($model === null) {
                throw new NotFoundHttpException;
            }

            self::$params['style'] = $model;
        }

        if (!empty($structure['factory'])) {
            $model = Factory::findByAlias($structure['factory'][0]);

            if ($model === null) {
                throw new NotFoundHttpException;
            }

            self::$params['factory'] = $model;
        }
    }
}