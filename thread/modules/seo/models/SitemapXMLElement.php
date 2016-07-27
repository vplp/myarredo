<?php
namespace thread\modules\seo\models;

use thread\app\base\models\ActiveRecord;

/**
 * Class SitemapXMLElement
 *
 * @package app\modules\sitemap\models;
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class SitemapXMLElement extends ActiveRecord
{

    public $loc;
    public $lastmod;
    public $changefreq = 'weekly';
    public $priority = 0.5;
    protected static $timeformat = 'Y-m-d';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loc'], 'required'],
            [['loc'], 'string', 'max' => 512],
//            [['loc'], 'url'],
            [['lastmod'], 'integer'],
            [['priority'], 'in', 'range' => range(0, 1, 0.1)],
            [['changefreq'], 'in', 'range' => self::changefreqRange()],
            [['lastmod'], 'default', 'value' => date(self::$timeformat, time())],
            [['changefreq'], 'default', 'value' => 'weekly'],
            [['priority'], 'default', 'value' => 0.5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['loc', 'lastmod', 'changefreq', 'priority'],
        ];
    }

    /**
     * @param integer $timestamp
     * @return string
     */
    public static function timeStampToLastmod($timestamp)
    {
        return date(self::$timeformat, (int) $timestamp);
    }

    /**
     * @return array
     */
    public static function changefreqRange()
    {
        return [
            'always',
            'hourly',
            'daily',
            'weekly',
            'monthly',
            'yearly',
            'never',
        ];
    }

    /**
     * @return string
     */
    public function render()
    {
        return '<url>'
            . '<loc><![CDATA[' . $this->loc . ']]></loc>'
            . '<lastmod>' . self::timeStampToLastmod($this->lastmod) . '</lastmod>'
            . '<changefreq>' . $this->changefreq . '</changefreq>'
            . '<priority>' . $this->priority . '</priority>'
            . '</url>';
    }
}
