<?php

namespace frontend\modules\catalog\components;

use Yii;
use yii\helpers\Url;
use yii\base\{
    Component
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

    static $keys = array(
        'category' => '.10',
        'type' => '.20',
        'style' => '.30',
        'factory' => '.40',
        'collection' => '.50',
        'd' => 'd',
        'dp' => 'dp',
        'ed' => 'ed',
        'el' => 'el',
        'h' => 'h',
        'id' => 'id',
        'il' => 'il',
        'l' => 'l',
        'm' => 'm',
        'price' => 'p',
        'city' => 'city',
    );

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Create Url
     *
     * @param string $key
     * @return string
     */
    public function createUrl(string $key)
    {
        $filter = $key;
        return Url::toRoute(['/catalog/category/list', 'filter' => $filter]);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return self::$params;
    }
}