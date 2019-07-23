<?php

namespace api\models;

use Yii;
use api\models\User;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $title
 * @property string $content
 * @property int $date_of_completion
 *
 * @property User $user
 */
class Task extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['content'], 'string'],
            [['title', 'date_of_completion'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'date_of_completion' => 'Date of completion',
            'title' => 'Title',
            'content' => 'Content',
        ];
    }

    static public function search($params)
    {

        $page = Yii::$app->getRequest()->getQueryParam('page');
        $limit = Yii::$app->getRequest()->getQueryParam('limit');
        $order = Yii::$app->getRequest()->getQueryParam('order');

        //$search = Yii::$app->getRequest()->getQueryParam('search');
        $search = Yii::$app->getRequest()->getQueryParam('filter');

        if(isset($search)){
            //$params=$search;
            $params=json_decode($search, true);
        }

        $limit = isset($limit) ? $limit : 10;
        $page = isset($page) ? $page : 1;


        $offset = ($page - 1) * $limit;

        $query = Task::find()
            ->select(['id', 'user_id', 'title', 'created_at', 'updated_at', 'content'])
            ->asArray(true)
            ->limit($limit)
            ->offset($offset);


        // 15.12.2018 Реализовать просмотр только своих тасков -->
//        if(isset($params['user_id'])) {
//            $query->andFilterWhere(['user_id' => $params['user_id']]);
//        }
        $query->andFilterWhere(['user_id' => Yii::$app->user->id]);
        // <--

        if(isset($params['id'])) {
            $query->andFilterWhere(['id' => $params['id']]);
        }

        if(isset($params['created_at'])) {
            $query->andFilterWhere(['created_at' => $params['created_at']]);
        }
        if(isset($params['updated_at'])) {
            $query->andFilterWhere(['updated_at' => $params['updated_at']]);
        }

        if(isset($order)){
            $query->orderBy($order);
        }

        $additional_info = [
            'page' => $page,
            'size' => $limit,
            'totalCount' => (int)$query->count()
        ];

        return [
            'data' => $query->all(),
            'info' => $additional_info
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->user_id = Yii::$app->user->id;

//            if ($insert) {
            if ($this->isNewRecord) {
                $date = date('d-m-Y g:i A');
                $dateTimeObject = \DateTime::createFromFormat('d-m-Y g:i A', $date);
                $this->created_at = $dateTimeObject->getTimeStamp();
            }

            $date = date('d-m-Y g:i A');
            $dateTimeObject = \DateTime::createFromFormat('d-m-Y g:i A', $date);
            $this->updated_at = $dateTimeObject->getTimeStamp();

            if ($this->date_of_completion) {
                $this->date_of_completion = strtotime($this->date_of_completion);
            }

            return true;

        } else {
            return false;
        }

    }

}
