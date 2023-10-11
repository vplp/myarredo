<?php

use yii\db\Migration;
//
use common\modules\location\Location;

/**
 * Handles the creation of table `{{%location_region_lang}}`.
 */
class m190329_105219_create_location_region_lang_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%location_region}}';

    /**
     * @var string
     */
    public $tableLang = '{{%location_region_lang}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Location::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title')
        ]);

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-location_region_lang-rid-location_region-id',
            $this->tableLang,
            'rid',
            $this->table,
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
        $this->dropForeignKey('fk-location_region_lang-rid-location_region-id', $this->tableLang);

        $this->dropIndex('rid', $this->tableLang);

        $this->dropTable($this->tableLang);
    }
}
