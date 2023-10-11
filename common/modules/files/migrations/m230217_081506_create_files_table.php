<?php

use yii\db\Migration;
use common\modules\files\FilesModule;

/**
 * Handles the creation of table `{{%files}}`.
 */
class m230217_081506_create_files_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%files}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = FilesModule::getDb();
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'name' => $this->string(255)->notNull()->comment('Name'),
            'url' => $this->string(255)->notNull()->comment('URL'),
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Created time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Updated time'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
