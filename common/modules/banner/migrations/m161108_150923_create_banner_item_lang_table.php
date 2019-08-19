<?php

use yii\db\Migration;
//
use common\modules\banner\BannerModule;

/**
 * Class m161108_150923_create_banner_item_lang_table
 */
class m161108_150923_create_banner_item_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableBanner = '{{%banner_item}}';

    /**
     * language table name
     * @var string
     */
    public $tableBannerLang = '{{%banner_item_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = BannerModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableBannerLang,
            [
                'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
                'lang' => $this->string(5)->notNull()->comment('Language'),
                'title' => $this->string(255)->notNull()->comment('Title'),
                'description' => $this->string(1024)->defaultValue(null)->comment('Description'),
                'link' => $this->string(255)->notNull()->defaultValue('')->comment('Link'),
            ]
        );

        $this->createIndex('rid', $this->tableBannerLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-banner_lang-rid-banner-id',
            $this->tableBannerLang,
            'rid',
            $this->tableBanner,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-banner_lang-rid-banner-id', $this->tableBannerLang);
        $this->dropIndex('rid', $this->tableBannerLang);
        $this->dropTable($this->tableBannerLang);
    }
}
