<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191203_143317_create_catalog_factory_file_click_stats extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_file_click_stats}}';

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
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'factory_file_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'views' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-user_id', $this->table, 'user_id');
        $this->createIndex('idx-factory_file_id', $this->table, 'factory_file_id');
        $this->createIndex('idx-views', $this->table, 'views');
        $this->createIndex('idx-created_at', $this->table, 'created_at');
        $this->createIndex('idx-updated_at', $this->table, 'updated_at');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user_id', $this->table);
        $this->dropIndex('idx-factory_file_id', $this->table);
        $this->dropIndex('idx-views', $this->table);
        $this->dropIndex('idx-created_at', $this->table);
        $this->dropIndex('idx-updated_at', $this->table);

        $this->dropTable($this->table);
    }
}
