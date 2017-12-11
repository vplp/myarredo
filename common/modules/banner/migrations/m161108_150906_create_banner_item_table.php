<?php

use yii\db\Migration;
//
use common\modules\banner\Banner as BannerModule;

/**
 * Class m161108_150906_create_banner_item_table
 */
class m161108_150906_create_banner_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableBanner = '{{%banner_item}}';

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
        $this->createTable($this->tableBanner, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'factory_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'image_link' => $this->string(255)->defaultValue(null)->comment('Image link'),
            'position' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('user_id', $this->tableBanner, 'user_id');
        $this->createIndex('factory_id', $this->tableBanner, 'factory_id');

        $this->createIndex('published', $this->tableBanner, 'published');
        $this->createIndex('deleted', $this->tableBanner, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableBanner);
        $this->dropIndex('published', $this->tableBanner);
        $this->dropTable($this->tableBanner);
    }
}
