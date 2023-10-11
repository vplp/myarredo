<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210521_132047_update_catalog_specification_table extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%catalog_specification}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'alias_fr',
            $this->string(255)->notNull()->after('alias_de')
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
                        'alias_fr' => $row['alias_en']
                    ],
                    'id = ' . $row['id']
                )
                ->execute();
        }

        $this->alterColumn($this->table, 'alias_fr', $this->string(255)->unique()->notNull());
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'alias_fr');
    }
}
