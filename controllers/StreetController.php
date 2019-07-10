<?php

namespace app\controllers;

use Yii;
use app\models\StreetSearch;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * StreetController implements the CRUD actions for Street model.
 */
class StreetController extends Controller
{
    /**
     * Lists all Street models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StreetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
