<?php

use yii\db\Migration;
use common\modules\books\Books;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m230315_105027_create_books_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%books}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Books::getDb();
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'book_id' => $this->integer(11)->notNull()->defaultValue(0)->comment('Campaign'),
            'email' => $this->string(255)->notNull()->comment('Email'),
            'name' => $this->string(255)->notNull()->comment('Name'),
            'active' => "enum('0','1') NOT NULL DEFAULT '0'",
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
