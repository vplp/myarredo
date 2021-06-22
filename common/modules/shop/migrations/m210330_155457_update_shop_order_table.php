<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m210330_155457_update_shop_order_table extends Migration
{
    /**
    * @var string
    */
    public $table = '{{%shop_order}}';
    public $tableOrderAnswers = '{{%shop_order_answer}}';

    /**
    *
    */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn($this->table, 'send_answer', "enum('0','1') NOT NULL DEFAULT '0'");
        $this->createIndex('send_answer', $this->table, 'send_answer');

//        $rows = (new \yii\db\Query())
//            ->from($this->table)
//            ->all();
//
//        foreach ($rows as $row) {
//            $date1 = new \DateTime();
//            $date2 = new \DateTime(date(DATE_ATOM, $row['created_at']));
//
//            $diff = $date2->diff($date1);
//            $hours = $diff->h;
//            $hours = $hours + ($diff->days * 24);
//
//            $countOrderAnswers = (new \yii\db\Query())
//                ->from($this->tableOrderAnswers)
//                ->where(['order_id' => $row['id']])
//                ->count();
//
//            $send_answer = '0';
//
//            if ($hours >= 3/* && $countOrderAnswers >= 1*/) {
//                $send_answer = '1';
//            } elseif ($countOrderAnswers >= 3) {
//                $send_answer = '1';
//            }
//
//            $connection = Yii::$app->db;
//            $connection->createCommand()
//                ->update(
//                    $this->table,
//                    [
//                        'send_answer' => $send_answer
//                    ],
//                    'id = ' . $row['id']
//                )
//                ->execute();
//        }
    }

    public function safeDown()
    {
        $this->dropIndex('send_answer', $this->table);
        $this->dropColumn($this->table, 'send_answer');
    }
}
