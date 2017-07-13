<?php

use yii\db\Migration;
use thread\modules\sys\Sys as SysModule;

/**
 * Class m161115_153703_insert_default_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161115_153703_insert_default_lang extends Migration
{
    /**
     * @var string
     */
    public $tableLang = '{{%system_languages}}';

    /**
     *
     */
    public function init()
    {
        $this->db = SysModule::getDb();
        parent::init();
    }

    /**
     *
     */
    public function safeUp()
    {
        /** Insert news_group */
        $this->batchInsert(
            $this->tableLang,
            [
                'id',
                'alias',
                'local',
                'label',
                'created_at',
                'updated_at',
                'published',
                'deleted',
                'img_flag',
                'by_default'
            ],
            [
                [
                    'id' => 1,
                    'alias' => 'ua',
                    'local' => 'uk-UA',
                    'label' => 'Українська',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'img_flag' => '',
                    'by_default' => '0'
                ],
                [
                    'id' => 2,
                    'alias' => 'en',
                    'local' => 'en-EN',
                    'label' => 'English',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'img_flag' => '',
                    'by_default' => '1'
                ],
                [
                    'id' => 3,
                    'alias' => 'ru',
                    'local' => 'ru-RU',
                    'label' => 'Русский',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'img_flag' => '',
                    'by_default' => '0'
                ],
            ]
        );

    }

    /**
     *
     */
    public function safeDown()
    {

    }
}
