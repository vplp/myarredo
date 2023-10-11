<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191029_090628_update_catalog_types_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_type}}';

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
        $this->addColumn(
            $this->table,
            'alias2',
            $this->string(255)->notNull()->after('alias')
        );

        $rows = (new \yii\db\Query())
            ->from($this->table)
            ->all();

        foreach ($rows as $row) {
            $connection = Yii::$app->db;
            $connection->createCommand()
                ->update(
                    $this->table,
                    [
                        'alias2' => $row['alias']
                    ],
                    'id = ' . $row['id']
                )
                ->execute();
        }

        $this->alterColumn($this->table, 'alias2', $this->string(255)->unique()->notNull());
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'alias2');
    }
}
