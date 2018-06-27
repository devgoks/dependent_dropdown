<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agentname".
 *
 * @property integer $name_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property integer $pollingunit_uniqueid
 */
class Agentname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agentname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'phone', 'pollingunit_uniqueid'], 'required'],
            [['pollingunit_uniqueid'], 'integer'],
            [['firstname', 'lastname', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name_id' => 'Name ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'phone' => 'Phone',
            'pollingunit_uniqueid' => 'Pollingunit Uniqueid',
        ];
    }
}
