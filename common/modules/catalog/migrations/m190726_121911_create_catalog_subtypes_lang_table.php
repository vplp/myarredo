<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_subtypes_lang}}`.
 */
class m190726_121911_create_catalog_subtypes_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_subtypes}}';

    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%catalog_subtypes_lang}}';


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
                'rid' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID'),
                'lang' => $this->string(5)->notNull()->comment('Language'),
                'title' => $this->string(255)->notNull()->comment('Title'),
                'plural_name' => $this->string(255)->notNull(),
            ]
        );

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-catalog_subtypes_lang-rid-catalog_subtypes-id',
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
        $this->dropForeignKey('fk-catalog_subtypes_lang-rid-catalog_subtypes-id', $this->tableLang);

        $this->dropIndex('rid', $this->tableLang);

        $this->dropTable($this->tableLang);
    }
}
