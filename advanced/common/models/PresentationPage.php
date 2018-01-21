<?php

namespace common\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "presentation_page".
 *
 * @property int $id
 * @property int $presentation_id
 * @property int $number
 * @property string $content
 * @property string $note
 *
 * @property Presentation $presentation
 */
class PresentationPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'presentation_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content', 'note'], 'string'],
            [['presentation_id', 'number'], 'unique', 'targetAttribute' => ['presentation_id', 'number']],
            [['presentation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Presentation::className(), 'targetAttribute' => ['presentation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'presentation_id' => Yii::t('app', 'Presentation ID'),
            'number' => Yii::t('app', 'Number'),
            'content' => Yii::t('app', 'Content'),
            'note' => Yii::t('app', 'Note'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentation()
    {
        return $this->hasOne(Presentation::className(), ['id' => 'presentation_id']);
    }

    /**
     * Finds the PresentationPage model based on its presentation id and number.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $presentationId
     * @param integer $number
     * @return PresentationPage the loaded model
     * @throws yii\web\NotFoundHttpException if the model cannot be founds
     */
    public function findPage($presentationId, $number)
    {
        if (($model = self::findOne(['presentation_id' => $presentationId, 'number' => $number])) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
