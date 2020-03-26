<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200326_075809_update_catalog_factory_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory}}';

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
        $this->addColumn(
            $this->table,
            'producing_country_id',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('user_id')
        );
        $this->createIndex('producing_country_id', $this->table, 'producing_country_id');

        $rows = (new \yii\db\Query())
            ->from($this->table)
            ->all();

        foreach ($rows as $row) {
            $connection = Yii::$app->db;
            $connection->createCommand()
                ->update(
                    $this->table,
                    [
                        'producing_country_id' => 4
                    ],
                    'id = ' . $row['id']
                )
                ->execute();
        }
    }

    public function safeDown()
    {
        $this->dropIndex('producing_country_id', $this->table);
        $this->dropColumn($this->table, 'producing_country_id');
    }
}
