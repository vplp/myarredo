<?php

use yii\db\Migration;
//
use common\modules\books\Books;

class m230315_111217_update_books_add_created_at_updated_at_columns extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%books}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Books::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'created_at',
            $this->integer(10)->notNull()->defaultValue(0)->comment('Created time')
        );
        $this->addColumn(
            $this->table,
            'updated_at',
            $this->integer(10)->notNull()->defaultValue(0)->comment('Updated time')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'updated_at');
        $this->dropColumn($this->table, 'created_at');
    }
}
