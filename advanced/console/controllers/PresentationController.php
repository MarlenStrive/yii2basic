<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
//use common\models\Presentation;


/**
 * Console commands to work with presentations.
 */
class PresentationController extends Controller
{
    /**
     * Deletes presentations.
     *
     * @param array $ids
     */
    public function actionDelete(array $ids)
    {
        if ($this->confirm(Yii::t('app', 'Are you sure? Deleted presentations can not be restored'))) {
            
            $deletedRowsCount = Yii::$app->db->createCommand()
                ->delete('presentation', ['id' => $ids])
                ->execute();
            
            if ($deletedRowsCount > 0) {
                $this->stdout(Yii::t('app', 'Presentations have been deleted') . "\n", Console::FG_GREEN);
            } else {
                $this->stdout(Yii::t('app', 'Presentations are not found') . "\n", Console::FG_RED);
            }
        }
    }

    /**
     * Clears the counters of presentations.
     *
     * @param array $ids
     */
    public function actionClearCounter(array $ids = [])
    {
        if (count($ids) == 0) {
            if ($this->confirm(Yii::t('app', 'Are you sure want to clear counters for ALL presentations?'))) {
                
                $updatedRowsCount = Yii::$app->db->createCommand()
                    ->update('presentation', ['rating' => 0])
                    ->execute();
                
                $this->stdout(Yii::t('app', 'Counters have been cleaned') . "\n", Console::FG_GREEN);
            }
        } else {
            if ($this->confirm(Yii::t('app', 'Are you sure want to clear counters for these presentations?'))) {
                
                $updatedRowsCount = Yii::$app->db->createCommand()
                    ->update('presentation', ['rating' => 0], ['id' => $ids])
                    ->execute();
                
                $this->stdout(Yii::t('app', 'Counters have been cleaned') . "\n", Console::FG_GREEN);
            }
        }
    }

}
