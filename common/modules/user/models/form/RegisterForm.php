<?php

namespace common\modules\user\models\form;

use Yii;
use Exception;
use DomainException;
use yii\db\mssql\PDO;
use yii\helpers\ArrayHelper;
use common\modules\user\models\{
    Group, Profile, ProfileLang, User
};
use common\modules\location\models\{
    City, Country
};
use thread\app\base\models\ActiveRecord;

/**
 * Class RegisterForm
 *
 * @property City $city
 *
 * @package common\modules\user\models\form
 */
class RegisterForm extends CommonForm
{
    public $reCaptcha;

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [
                [
                    'password',
                    'password_confirmation',
                ],
                'required'
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'phone'
                ],
                'required',
                'on' => 'register'
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'phone',
                    'name_company',
                    'address',
                    'country_id',
                    'user_agreement',
                    'confirm_processing_data',
                    'reCaptcha'
                ],
                'required',
                'on' => 'registerPartner'
            ],
            [
                [
                    'last_name',
                    'phone',
                    'name_company',
                    'address',
                    'country_id',
                    'city_id',
                    'user_agreement',
                    'factory_confirm_offers',
                    'reCaptcha'
                ],
                'required',
                'on' => ['registerFactory']
            ],
            [
                [
                    'last_name',
                    'phone',
                    'name_company',
                    'address',
                    'country_id',
                    'city_id',
                    'user_agreement',
                    'factory_confirm_offers',
                    'user_confirm_offers',
                    'reCaptcha'
                ],
                'required',
                'on' => ['registerLogistician']
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'phone',
                    'address',
                    'name_company',
                    'website',
                    'exp_with_italian',
                    'cape_index'
                ],
                'string',
                'max' => 255
            ],
            [
                ['city_id'],
                'required',
                'on' => ['registerPartner'],
                'when' => function ($model) {
                    return in_array($model->country_id, [1, 2, 3]);
                },
                'whenClient' => "function (attribute, value) {
                    const countries = [1, 2, 3];
                    const country_id = $('select[name=\"RegisterForm[country_id]\"]').val();
                    return countries.includes(country_id);
                }"
            ],
            [
                ['user_agreement'],
                'required',
                'on' => ['registerPartner', 'registerFactory', 'registerLogistician'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [
                ['user_confirm_offers'],
                'required',
                'on' => ['registerLogistician'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [
                ['factory_confirm_offers'],
                'required',
                'on' => ['registerFactory'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [
                ['confirm_processing_data'],
                'required',
                'on' => ['registerPartner'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [
                [
                    'delivery_to_other_cities',
                    'user_agreement',
                    'confirm_processing_data',
                    'user_confirm_offers',
                    'factory_confirm_offers'
                ],
                'in',
                'range' => [0, 1]
            ],
            [['country_id', 'city_id'], 'integer'],
            [['country_id', 'city_id', 'delivery_to_other_cities'], 'default', 'value' => 0],
            [
                ['password_confirmation'],
                'compare',
                'compareAttribute' => 'password',
                'on' => [
                    'adminPasswordChange',
                    'register',
                    'registerPartner',
                    'registerFactory',
                    'registerLogistician'
                ]
            ],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::class],
            [
                ['cape_index'],
                'required',
                'on' => 'registerPartner',
                'when' => function ($model) {
                    return $model->country_id === 4;
                },
                'whenClient' => "function (attribute, value) {
                    return $('select[name=\"RegisterForm[country_id]\"]').val() == 4;
                }"
            ],
        ];

        if ($this->_username_attribute === 'email') {
            $rules[] = [['email'], 'required'];
        } elseif ($this->_username_attribute === 'username') {
            $rules[] = [['username'], 'required'];
        }

        return ArrayHelper::merge($rules, parent::rules());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'register' => [
                'username',
                'email',
                'password',
                'password_confirmation',
                'first_name',
                'last_name',
                'phone',
                'country_id',
                'city_id',
            ],
            'registerPartner' => [
                'username',
                'email',
                'password',
                'password_confirmation',
                'first_name',
                'last_name',
                'phone',
                'address',
                'name_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'delivery_to_other_cities',
                'user_agreement',
                'confirm_processing_data',
                'reCaptcha',
                'cape_index'
            ],
            'registerFactory' => [
                'username',
                'email',
                'password',
                'password_confirmation',
                'first_name',
                'last_name',
                'phone',
                'address',
                'name_company',
                'website',
                'country_id',
                'city_id',
                'user_agreement',
                'factory_confirm_offers',
                'reCaptcha'
            ],
            'registerLogistician' => [
                'username',
                'email',
                'password',
                'password_confirmation',
                'first_name',
                'last_name',
                'phone',
                'address',
                'name_company',
                'website',
                'country_id',
                'city_id',
                'user_agreement',
                'user_confirm_offers',
                'reCaptcha'
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Add new user to base
     */
    public function addUser()
    {
        $model = new User([
            'scenario' => 'userCreate',
            'username' => $this->email,
            'email' => $this->email,
            'published' => ActiveRecord::STATUS_KEY_OFF,
            'group_id' => Group::USER,
        ]);

        $model->setPassword($this->password)->generateAuthKey();

        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();
                    return $this->addUserProfile($model->id);
                } else {
                    $transaction->rollBack();
                    return false;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * Create new empty profile for a new user
     *
     * @param $userId
     * @return bool
     * @throws Exception
     */
    private function addUserProfile($userId)
    {
        $model = new Profile([
            'scenario' => 'basicCreate',
            'user_id' => $userId,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'preferred_language' => Yii::$app->language,
        ]);
        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                ($save) ? $transaction->commit() : $transaction->rollBack();
                return $save;
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * Add new partner to base
     */
    public function addPartner()
    {
        $model = new User([
            'scenario' => 'userCreate',
            'username' => $this->email,
            'email' => $this->email,
            'published' => ActiveRecord::STATUS_KEY_OFF,
            'group_id' => Group::PARTNER,
        ]);

        $model->setPassword($this->password)->generateAuthKey();

        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();
                    return $this->addPartnerProfile($model->id);
                } else {
                    $transaction->rollBack();
                    return false;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * Create new empty profile for a new partner
     *
     * @param $userId
     * @return bool
     * @throws Exception
     */
    private function addPartnerProfile($userId)
    {
        $model = new Profile([
            'scenario' => 'basicCreate',
            'user_id' => $userId,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'website' => $this->website,
            'exp_with_italian' => $this->exp_with_italian,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'preferred_language' => Yii::$app->language,
            'delivery_to_other_cities' => $this->delivery_to_other_cities,
            'cape_index' => $this->cape_index,
        ]);

        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();

                $modelLang = new ProfileLang([
                    'scenario' => 'basicCreate',
                    'rid' => $model->id,
                    'lang' => Yii::$app->language,
                    'address' => $this->address,
                    'name_company' => $this->name_company,
                ]);

                $saveLang = $modelLang->save();

                if (Yii::$app->language != 'ru-RU') {
                    $modelLangRu = new ProfileLang([
                        'scenario' => 'basicCreate',
                        'rid' => $model->id,
                        'lang' => 'ru-RU',
                        'address' => $this->address,
                        'name_company' => $this->name_company,
                    ]);

                    $saveLangRu = $modelLangRu->save();
                }

                

                ($save && $saveLang) ? $transaction->commit() : $transaction->rollBack();

                return $save;
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * Add new Factory to base
     */
    public function addFactory()
    {
        $model = new User([
            'scenario' => 'userCreate',
            'username' => $this->email,
            'email' => $this->email,
            'published' => ActiveRecord::STATUS_KEY_OFF,
            'group_id' => Group::FACTORY,
        ]);

        $model->setPassword($this->password)->generateAuthKey();

        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();
                    return $this->addFactoryProfile($model->id);
                } else {
                    $transaction->rollBack();
                    return false;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * Create new empty profile for a new Factory
     *
     * @param $userId
     * @return bool
     * @throws Exception
     */
    private function addFactoryProfile($userId)
    {
        $model = new Profile([
            'scenario' => 'basicCreate',
            'user_id' => $userId,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'website' => $this->website,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'preferred_language' => Yii::$app->language,
        ]);
        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();

                $modelLang = new ProfileLang([
                    'scenario' => 'basicCreate',
                    'rid' => $model->id,
                    'lang' => Yii::$app->language,
                    'address' => $this->address,
                    'name_company' => $this->name_company,
                ]);

                $saveLang = $modelLang->save();

                ($save && $saveLang) ? $transaction->commit() : $transaction->rollBack();

                return $save;
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * Add new Logistician to base
     */
    public function addLogistician()
    {
        $model = new User([
            'scenario' => 'userCreate',
            'username' => $this->email,
            'email' => $this->email,
            'published' => ActiveRecord::STATUS_KEY_OFF,
            'group_id' => Group::LOQISTICIAN,
        ]);

        $model->setPassword($this->password)->generateAuthKey();

        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();
                    return $this->addLogisticianProfile($model->id);
                } else {
                    $transaction->rollBack();
                    return false;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * Create new empty profile for a new Logistician
     *
     * @param $userId
     * @return bool
     * @throws Exception
     */
    private function addLogisticianProfile($userId)
    {
        $model = new Profile([
            'scenario' => 'basicCreate',
            'user_id' => $userId,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'website' => $this->website,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'preferred_language' => Yii::$app->language,
        ]);

        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();

                $modelLang = new ProfileLang([
                    'scenario' => 'basicCreate',
                    'rid' => $model->id,
                    'lang' => Yii::$app->language,
                    'address' => $this->address,
                    'name_company' => $this->name_company,
                ]);

                $saveLang = $modelLang->save();

                ($save && $saveLang) ? $transaction->commit() : $transaction->rollBack();

                return $save;
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * @param $token
     * @return User|null
     * @throws Exception
     */
    public function confirmation($token)
    {
        if (empty($token)) {
            throw new DomainException('Empty confirm token.');
        }

        $user = User::findOne(['auth_key' => $token]);

        if (!$user) {
            throw new DomainException('User is not found.');
        }

        $user->setScenario('published');
        $user->published = ActiveRecord::STATUS_KEY_ON;

        /** @var PDO $transaction */
        $transaction = self::getDb()->beginTransaction();
        try {
            if ($user->save()) {
                $transaction->commit();
                return $user;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new Exception($e);
        }
    }
}
