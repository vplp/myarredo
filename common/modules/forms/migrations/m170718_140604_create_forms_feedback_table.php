<?php

use yii\db\Migration;
use common\modules\forms\FormsModule;

class m170718_140604_create_forms_feedback_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%forms_feedback}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = FormsModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->table, [

            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'name' => $this->string(255)->notNull()->comment('Name'),
            'email' => $this->string(255)->notNull()->comment('Email'),
            'phone' => $this->string(255)->notNull()->comment('Phone'),
            'comment' => $this->string(2048)->notNull()->comment('Comment'),
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Created time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Updated time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
        ]);

        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);

        $this->dropTable($this->table);
    }
}
