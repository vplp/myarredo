<?php

use yii\db\Migration;

class m160726_152658_update_phone_field extends Migration
{


    /**
     * @var string
     */
    public $tableFeedbacks = '{{%feedbacks}}';

    public function safeUp()
    {
        $this->dropColumn($this->tableFeedbacks, 'phone');
        $this->addColumn($this->tableFeedbacks, 'phone', $this->string(20)->defaultValue(null)->comment('phone'));
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableFeedbacks, 'phone');
        $this->addColumn($this->tableFeedbacks, 'phone', $this->integer(10)->defaultValue(null)->defaultValue(0)->comment('Phone'));

    }
}
