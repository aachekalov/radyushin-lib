<?php

namespace frontend\controllers;

use Yii;
use common\models\Genre;
use common\models\Writer;
use common\models\GenreSearch;
use frontend\models\GenreVote;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * GenreController implements the CRUD actions for Genre model.
 */
class GenreController extends Controller
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
     * Lists all Genre models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GenreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Genre model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $query = (new \yii\db\Query())
            ->select(['writer_id', 'writer.name', 'writer.surname'])->distinct()
            ->from('writer')
            ->innerJoin('book_writer', 'book_writer.writer_id = writer.id')
            ->innerJoin('book_genre', 'book_genre.book_id = book_writer.book_id')
            ->where(['genre_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $model = Genre::find()
            ->select(['genre.*', 'votes' => 'SUM(genre_vote.value)'])
            ->leftJoin('genre_vote', 'genre_vote.genre_id = genre.id')
            ->where(['genre_id' => $id])
            ->one();
        $subQuery = (new \yii\db\Query())
            ->select(['writer_id', 'writer.name', 'writer.surname', 'votes' => 'SUM(book_vote.value)'])
            ->from('writer')
            ->innerJoin('book_writer', 'book_writer.writer_id = writer.id')
            ->innerJoin('book_genre', 'book_genre.book_id = book_writer.book_id')
            ->innerJoin('book_vote', 'book_vote.book_id = book_writer.book_id')
            ->where(['genre_id' => $id])
            ->groupBy(['writer.id', 'book_vote.book_id']);
        $query2 = (new \yii\db\Query())
            ->select(['writer_id', 'name', 'surname', 'avg' => 'AVG(votes)'])
            ->from(['v' => $subQuery])
            ->groupBy('writer_id')
            ->orderBy(['avg' => SORT_DESC]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => $query2,
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'canVote' => !Yii::$app->user->isGuest && GenreVote::canUserVote($model->id, Yii::$app->user->id),
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Creates a new Genre model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Genre();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Genre model.
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
     * Deletes an existing Genre model.
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
     * Finds the Genre model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Genre the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Genre::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function vote(int $id, int $value) {
        if (!GenreVote::canUserVote($id, Yii::$app->user->id)) {
            return;
        }

        $vote = new GenreVote();
        $vote->value = $value;
        $vote->user_id = Yii::$app->user->id;
        $vote->genre_id = $id;
        $vote->save();
    }

    public function actionUpvote($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->vote($id, 1);

        $model = Genre::find()
            ->select(['genre.*', 'votes' => 'SUM(genre_vote.value)'])
            ->leftJoin('genre_vote', 'genre_vote.genre_id = genre.id')
            ->where(['genre_id' => $id])
            ->one();
        return $this->renderPartial('_voting', [
            'model' => $model,
        ]);
    }

    public function actionDownvote($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->vote($id, -1);

        $model = Genre::find()
            ->select(['genre.*', 'votes' => 'SUM(genre_vote.value)'])
            ->leftJoin('genre_vote', 'genre_vote.genre_id = genre.id')
            ->where(['genre_id' => $id])
            ->one();
        return $this->renderPartial('_voting', [
            'model' => $model,
        ]);
    }
}
