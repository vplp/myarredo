<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_colors}}`.
 */
class m190225_143844_create_catalog_colors_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_colors}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(32)->notNull()->unique(),
            'default_title' => $this->string(255)->defaultValue('')->comment('Default title'),
            'color_code' => $this->string(32)->notNull()->unique(),
            'position' => $this->integer(11)->unsigned()->defaultValue(0),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('position', $this->table, 'position');
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
        $this->dropIndex('position', $this->table);

        $this->dropTable($this->table);
    }
}
