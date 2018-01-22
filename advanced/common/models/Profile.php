<?php

namespace common\models;

//use paulzi\jsonBehavior\JsonBehavior;
use dektrium\user\models\Profile as BaseProfile;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string  $name
 * @property string  $public_email
 * @property string  $gravatar_email
 * @property string  $gravatar_id
 * @property string  $location
 * @property string  $website
 * @property string  $bio
 * @property string  $timezone
 * @property string  $second_name
 * @property string  $language
 * @property string  $public_fields
 * @property string  $city
 * @property string  $country
 * 
 * @property User    $user
 */
class Profile extends BaseProfile
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            'secondNameLength' => ['second_name', 'string', 'max' => 255],
            'languageLength' => ['language', 'string', 'max' => 255],
            'publicFieldsLength' => ['public_fields', 'string', 'max' => 255],
            'cityLength' => ['city', 'string', 'max' => 255],
            'countryLength' => ['country', 'string', 'max' => 255],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (is_array($this->public_fields)) {
            $this->public_fields = implode(',', $this->public_fields);
        }
        
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if (is_string($this->public_fields)) {
            $this->public_fields = explode(',', $this->public_fields);
        }
        
        return parent::afterFind();
    }

}