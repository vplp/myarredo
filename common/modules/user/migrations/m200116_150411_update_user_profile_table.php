<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m200116_150411_update_user_profile_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%user_profile}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = UserModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->dropIndex('answers_per_month', $this->table);

        $this->renameColumn($this->table, 'answers_per_month', 'three_answers_per_month');
        $this->addColumn($this->table, 'one_answer_per_month', "enum('0','1') NOT NULL DEFAULT '0'");

        $this->createIndex('three_answers_per_month', $this->table, 'three_answers_per_month');
        $this->createIndex('one_answer_per_month', $this->table, 'one_answer_per_month');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('one_answer_per_month', $this->table);
        $this->dropIndex('three_answers_per_month', $this->table);

        $this->dropColumn($this->table, 'one_answer_per_month');
        $this->renameColumn($this->table, 'three_answers_per_month', 'answers_per_month');

        $this->createIndex('answers_per_month', $this->table, 'answers_per_month');
    }
}
