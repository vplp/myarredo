<?php

use yii\db\Migration;

/**
 * Class m160706_074713_insert_auth_assign
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160706_074713_insert_auth_assign extends Migration
{
    /**
     * Assignment table name
     * @var string
     */
    public $tableAuthAssignment = '{{%auth_assignment}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->batchInsert(
            $this->tableAuthAssignment,
            [
                'item_name',
                'user_id',
                'created_at'
            ],
            [
                [
                    'item_name' => 'admin',
                    'user_id' => 1,
                    'created_at' => time()
                ],
                [
                    'item_name' => 'user',
                    'user_id' => 2,
                    'created_at' => time()
                ],
            ]
        );
    }

    /**
     * Revert
     */
    public function safeDown()
    {
        $this->truncateTable($this->tableAuthAssignment);
    }
}
