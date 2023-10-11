<?php

namespace thread\modules\seo\modules\sitemap\models;

use yii\base\Model;

/**
 * Class XMLSimple
 *
 * @package thread\modules\seo\modules\sitemap\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class XMLSimple extends Model
{

    public $collection = [];

    /**
     * @param XMLElement $item
     * @return array|bool
     */
    public function addItem(XMLElement $item)
    {
        if ($item->validate()) {
            $this->collection[] = $item;
            return true;
        } else {
            return $item->getErrors();
        }
    }

    /**
     * @return string
     */
    public static function headTag()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>';
    }

    /**
     * @return string
     */
    public static function beginTag()
    {
        return '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    }

    /**
     * @return string
     */
    public static function endTag()
    {
        return '</urlset> ';
    }

    /**
     * @return string
     */
    public function render()
    {
        $r = [];
        if (!empty($this->collection)) {
            $r[] = self::headTag();
            $r[] = self::beginTag();

            foreach ($this->collection as $url) {
                $r[] = $url->render();
            }

            $r[] = self::endTag();
        }

        return implode('', $r);
    }
}
