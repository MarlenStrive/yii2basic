<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $message
 * @property int $permissions
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 *
 * @property User $createdBy
 */
class Status extends \yii\db\ActiveRecord
{

    const PERMISSIONS_PRIVATE = 10;
    const PERMISSIONS_PUBLIC = 20;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    public function getPermissions()
    {
        return [
            self::PERMISSIONS_PRIVATE => 'Private',
            self::PERMISSIONS_PUBLIC => 'Public',
        ];
    }

    public function getPermissionsLabel($permissions)
    {
        if ($permissions == self::PERMISSIONS_PUBLIC) {
            return 'Public';
        } else {
            return 'Private';
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['permissions', 'created_at', 'updated_at', 'created_by'], 'default', 'value' => null],
            [['permissions', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['created_at', 'updated_at', 'created_by'], 'required'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('app', 'Message'),
            'permissions' => Yii::t('app', 'Permissions'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
