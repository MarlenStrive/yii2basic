<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "presentation".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $is_public
 * @property string $image_preview
 * @property int $created_at
 * @property int $updated_at
 * @property string $publication_date
 * @property string $expiration_date
 * @property string $public_url
 * @property int $rating
 * @property int $category_id
 *
 * @property Category $category
 * @property User $user
 * @property PresentationEditor[] $presentationEditors
 * @property PresentationPage[] $presentationPages
 * @property PresentationTag[] $presentationTags
 * @property PresentationViewer[] $presentationViewers
 */
class Presentation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'presentation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'is_public', 'category_id'], 'required'],
            [['user_id', 'is_public', 'category_id'], 'integer'],
            [['description'], 'string'],
            [['publication_date', 'expiration_date'], 'safe'],
            [['title', 'image_preview'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'is_public' => Yii::t('app', 'Is Public'),
            'image_preview' => Yii::t('app', 'Image Preview'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'publication_date' => Yii::t('app', 'Publication Date'),
            'expiration_date' => Yii::t('app', 'Expiration Date'),
            'public_url' => Yii::t('app', 'Public Url'),
            'rating' => Yii::t('app', 'Rating'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentationEditors()
    {
        return $this->hasMany(PresentationEditor::className(), ['presentation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentationPages()
    {
        return $this->hasMany(PresentationPage::className(), ['presentation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentationTags()
    {
        return $this->hasMany(PresentationTag::className(), ['presentation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentationViewers()
    {
        return $this->hasMany(PresentationViewer::className(), ['presentation_id' => 'id']);
    }
}
