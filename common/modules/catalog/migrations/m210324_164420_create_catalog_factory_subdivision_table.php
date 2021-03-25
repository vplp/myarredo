<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

/**
 * Handles the creation of table `{{%catalog_factory_subdivision}}`.
 */
class m210324_164420_create_catalog_factory_subdivision_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_factory_subdivision}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'region' => "enum('0','1','2') NOT NULL DEFAULT '0' COMMENT 'Region'",
            'factory_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'company_name' => $this->string(255)->notNull(),
            'contact_person' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'phone' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('region', $this->table, 'region');
        $this->createIndex('factory_id', $this->table, 'factory_id');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('factory_id', $this->table);
        $this->dropIndex('region', $this->table);

        $this->dropTable($this->table);
    }
}
