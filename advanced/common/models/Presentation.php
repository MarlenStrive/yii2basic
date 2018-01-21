<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use dosamigos\taggable\Taggable;
use voskobovich\linker\LinkerBehavior;

/**
 * This is the model class for table "presentation".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $is_public
 * @property int $image_preview
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
 * @property int $presentationPagesCount
 * @property PresentationTag[] $presentationTags
 * @property PresentationViewer[] $presentationViewers
 */
class Presentation extends ActiveRecord
{
    //public $editor_ids = array();
    //public $viewer_ids = array();
    
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
            [['user_id', 'title', 'is_public', 'category_id', 'image_preview'], 'required'],
            [['user_id', 'is_public', 'category_id', 'image_preview'], 'integer'],
            [['description'], 'string'],
            [['publication_date', 'expiration_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['tagNames'], 'safe'],
            [['editor_ids', 'viewer_ids'], 'each', 'rule' => ['integer']],
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
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'public_url',
                'immutable' => true,
                'ensureUnique'=>true,
            ],
            'tags' => [
                'class' => Taggable::className(),
            ],
            [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'editor_ids' => 'editors',
                    'viewer_ids' => 'viewers',
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
            'editor_ids' => Yii::t('app', 'Editors'),
            'viewer_ids' => Yii::t('app', 'Viewers'),
        ];
    }

    /**
     * @return array \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable(
                'presentation_tag', ['presentation_id' => 'id']);
    }

    /**
     * @return array \yii\db\ActiveQuery
     */
    public function getEditors()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable(
                'presentation_editor', ['presentation_id' => 'id']);
    }

    /**
     * @return array \yii\db\ActiveQuery
     */
    public function getViewers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable(
                'presentation_viewer', ['presentation_id' => 'id']);
    }

    public function fillDefaultValues()
    {
        $currentUserId = Yii::$app->user->identity->id;
        
        $this->user_id = $currentUserId;
        $this->rating = self::getCurrentRating($currentUserId);
        $this->is_public = 0;
    }

    public static function getCurrentRating($userId)
    {
        return Presentation::find()->where(['user_id' => $userId])->count();
    }

    public function savePreviewImage($imageData)
    {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        
        $filepath = $this->getImagePreviewPath();
        
        /*var_dump($imageData);
        var_dump(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        var_dump($data);
        exit;*/
        file_put_contents($filepath, $data);
        
        return true;
    }

    public function getImagePreviewPath()
    {
        return Yii::getAlias('@webroot/images') . '/' . $this->id . '.png';
    }

    /**
     * Fill default values for the new PresentationPage and return the object
     * @return \common\models\PresentationPage
     */
    public function getNewPage()
    {
        $page = new PresentationPage();
        
        $page->presentation_id = $this->id;
        $page->number = $this->getPagesCount() + 1;
        
        return $page;
    }

    /**
     * @param integer $number
     * @return \common\models\PresentationPage
     */
    public function getPageByNumber($number)
    {
        return PresentationPage::findOne(['presentation_id' => $this->id, 'number' => $number]);
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
     * @return integer
     */
    public function getPagesCount()
    {
        return PresentationPage::find()->where(['presentation_id' => $this->id])->count();
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
