<?php

namespace frontend\controllers;

use Yii;
use common\models\Writer;
use common\models\WriterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * WriterController implements the CRUD actions for Writer model.
 */
class WriterController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Writer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WriterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Writer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $subQuery = (new \yii\db\Query())
            ->select('genre_id')->distinct()
            ->from('book_writer')
            ->innerJoin('book_genre', 'book_genre.book_id = book_writer.book_id')
            ->where(['writer_id' => $id]);
        $query = (new \yii\db\Query())
            ->select(['writer_id', 'writer.name', 'writer.surname'])->distinct()
            ->from('writer')
            ->innerJoin('book_writer', 'book_writer.writer_id = writer.id')
            ->innerJoin('book_genre', 'book_genre.book_id = book_writer.book_id')
            ->where([
                'genre_id' => $subQuery,
            ])
            ->andWhere([
                '!=', 'writer_id', $id]
            );
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Writer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Writer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Writer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Writer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Writer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Writer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Writer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
