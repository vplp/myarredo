<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `catalog_italian_item_lang`.
 */
class m190122_144500_create_catalog_italian_item_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%catalog_italian_item_lang}}';

    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableLang,
            [
                'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
                'lang' => $this->string(5)->notNull()->comment('Language'),
                'title' => $this->string(255)->notNull()->comment('Title'),
                'description' => $this->string(1024)->defaultValue(null)->comment('Description'),
                'content' => $this->text()->defaultValue(null)->comment('Content'),
            ]
        );

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-catalog_italian_item_lang-rid--id',
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
        $this->dropForeignKey('fk-catalog_italian_item_lang-rid--id', $this->tableLang);
        $this->dropIndex('rid', $this->tableLang);
        $this->dropTable($this->tableLang);
    }
}
