<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\base\models\ActiveRecordLang;
use common\modules\catalog\Catalog;

/**
 * Class FactoryLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $description
 * @property string $content
 * @property string $contacts
 * @property string $h1
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $wc_provider
 * @property string $wc_phone_supplier
 * @property string $wc_email_supplier
 * @property string $wc_phone_factory
 * @property string $wc_email_factory
 * @property string $wc_contact_person_supplier
 * @property string $wc_contact_person_factory
 * @property string $wc_expiration_date
 * @property string $wc_terms_of_payment
 * @property string $wc_prepayment
 * @property string $wc_balance
 * @property string $wc_additional_terms
 * @property string $wc_additional_discount_info
 * @property string $wc_additional_cost_calculations_info
 * @property string $subdivision
 *
 * @package common\modules\catalog\models
 */
class FactoryLang extends ActiveRecordLang
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_factory_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['rid', 'exist', 'targetClass' => Factory::class, 'targetAttribute' => 'id'],
            [['h1', 'meta_title', 'meta_desc'], 'string', 'max' => 255],
            [[
                'description',
                'content',
                'contacts',
                'wc_provider',
                'wc_phone_supplier',
                'wc_email_supplier',
                'wc_phone_factory',
                'wc_email_factory',
                'wc_contact_person_supplier',
                'wc_contact_person_factory',
                'wc_expiration_date',
                'wc_terms_of_payment',
                'wc_prepayment',
                'wc_balance',
                'wc_additional_terms',
                'wc_additional_discount_info',
                'wc_additional_cost_calculations_info',
                'subdivision'
            ], 'string'],
            [['h1', 'meta_title', 'meta_desc', 'description', 'content', 'contacts'], 'default', 'value' => ''],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'h1',
                'meta_title',
                'meta_desc',
                'description',
                'content',
                'contacts',
                'subdivision',
                'wc_provider',
                'wc_phone_supplier',
                'wc_email_supplier',
                'wc_phone_factory',
                'wc_email_factory',
                'wc_contact_person_supplier',
                'wc_contact_person_factory',
                'wc_expiration_date',
                'wc_terms_of_payment',
                'wc_prepayment',
                'wc_balance',
                'wc_additional_terms',
                'wc_additional_discount_info',
                'wc_additional_cost_calculations_info',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'contacts' => 'Контакты',
            'h1' => 'H1',
            'meta_title' => 'Meta title',
            'meta_desc' => 'Meta desc',
            'subdivision' => Yii::t('app', 'Представительство'),
            'wc_provider' => Yii::t('app', 'Поставщик'),
            'wc_expiration_date' => Yii::t('app', 'Срок производства'),
            'wc_terms_of_payment' => Yii::t('app', 'Условия оплаты'),
            'wc_phone_supplier' => Yii::t('app', 'Телефон поставщика'),
            'wc_email_supplier' => Yii::t('app', 'Почта поставщика'),
            'wc_contact_person_supplier' => Yii::t('app', 'Контактное лицо поставщика'),
            'wc_phone_factory' => Yii::t('app', 'Телефон фабрики'),
            'wc_email_factory' => Yii::t('app', 'Почта фабрики'),
            'wc_contact_person_factory' => Yii::t('app', 'Контактное лицо фабрики'),
            'wc_prepayment' => Yii::t('app', 'Предоплата'),
            'wc_balance' => Yii::t('app', 'Остаток'),
            'wc_additional_terms' => Yii::t('app', 'Дополнительные условия'),
            'wc_additional_discount_info' => Yii::t('app', 'Дополнительная информация по скидке'),
            'wc_additional_cost_calculations_info' => Yii::t('app', 'Дополнительная информация по расчетам стоимости')
        ];
    }
}
