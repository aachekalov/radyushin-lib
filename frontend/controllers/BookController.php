<?php

namespace frontend\controllers;

use Yii;
use common\models\Book;
use common\models\BookSearch;
use common\models\Writer;
use common\models\Genre;
use frontend\models\BookVote;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Book::find()
            ->select(['book.*', 'votes' => 'SUM(book_vote.value)'])
            ->leftJoin('book_vote', 'book_vote.book_id = book.id')
            ->where(['book_id' => $id])
            ->one();
        return $this->render('view', [
            'model' => $model,
            'canVote' => !Yii::$app->user->isGuest && BookVote::canUserVote($model->id, Yii::$app->user->id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return Yii::$app->db->transaction(function($db) use ($model) {
                $writers = Writer::findByIds($model->writers);
                $genres = Genre::findByIds($model->genres);
                $model->save();
                foreach ($writers as $writer) {
                    $model->link('writers', $writer);
                }
                foreach ($genres as $genre) {
                    $model->link('genres', $genre);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            });
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return Yii::$app->db->transaction(function($db) use ($model) {
                $writers = Writer::findByIds($model->writers);
                $genres = Genre::findByIds($model->genres);
                $model->save();

                $oldWriters = $model->getWriters()->all();
                $oldGenres = $model->getGenres()->all();
                foreach ($writers as $writer) {
                    if (!in_array($writer, $oldWriters)) {
                        $model->link('writers', $writer);
                    }
                }
                foreach ($genres as $genre) {
                    if (!in_array($genre, $oldGenres)) {
                        $model->link('genres', $genre);
                    }
                }
                foreach ($oldWriters as $writer) {
                    if (!in_array($writer, $writers)) {
                        $model->unlink('writers', $writer, true);
                    }
                }
                foreach ($oldGenres as $genre) {
                    if (!in_array($genre, $genres)) {
                        $model->unlink('genres', $genre, true);
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            });
        } else {
            $model->writers = array_map(function($item) { return $item->id; }, $model->getWriters()->all());
            $model->genres = array_map(function($item) { return $item->id; }, $model->getGenres()->all());
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
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
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function vote(int $id, int $value) {
        if (!BookVote::canUserVote($id, Yii::$app->user->id)) {
            return;
        }

        $vote = new BookVote();
        $vote->value = $value;
        $vote->user_id = Yii::$app->user->id;
        //$model = $this->findModel($id);
        //$vote->link('book', $model);
        $vote->book_id = $id;
        $vote->save();
    }

    public function actionUpvote($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->vote($id, 1);

        $model = Book::find()
            ->select(['book.*', 'votes' => 'SUM(book_vote.value)'])
            ->leftJoin('book_vote', 'book_vote.book_id = book.id')
            ->where(['book_id' => $id])
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

        $model = Book::find()
            ->select(['book.*', 'votes' => 'SUM(book_vote.value)'])
            ->leftJoin('book_vote', 'book_vote.book_id = book.id')
            ->where(['book_id' => $id])
            ->one();
        return $this->renderPartial('_voting', [
            'model' => $model,
        ]);
    }
}
