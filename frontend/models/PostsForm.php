<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

//数据模型 继承自 ActiveRecord
//表单模型 继承自 Model
//ActiveRecord ---->Model
class PostsForm extends Model {

    //put your code here
    //1.声明属性
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;
    public $_lastError = "";

    //声明2个常量,表示添加和更新操作
    const SCENARTOS_CREATE = "create";
    const SCENARTOS_UPDATE = "update";
    //声明两个常量,表示
    const EVENT_AFTER_CREATE = 'create';
    const EVENT_AFTER_UPDATE = 'update';

    public function rules() {
        return [
            [["id", 'title', 'content', 'cat_id'], 'required'],
            [['id', 'cat_id'], 'integer'],
            ['title', 'string', 'min' => 4, 'max' => 50]
        ];
    }

    public function scenarios() {
        $scenarios = [
            self::SCENARTOS_CREATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
            self::SCENARTOS_UPDATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
        ];
        return array_merge(parent::scenarios(), $scenarios);
    }

    public function attributeLabels() {
        return [
            'tags' => \Yii::t("common", "article tags"),
            'title' => \Yii::t("common", "article title"),
            'cat_id' => \Yii::t("common", "article cat_id"),
            'content' => \Yii::t("common", "article content"),
            'label_img' => \Yii::t("common", "article label_img"),
        ];
    }

    //保存数据到数据库
    //4.1 添加文章基本信息
    //4.2 添加文章的标签
    //注意:如果文章加成功,标签没成功,把数据回滚,类似与撤销上一部
    //数据库自带的功能 事务
    //1)开启事务
    //2)执行相关操作
    //3)如果没问题 执行事务(提交后sql语句才会生效)
    //4) 如果有问题,回滚
    public function createArticle() {
        //捕获异常信息
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            //正常执行
            $article = new Posts();
            //保存表单数据
            $article->setAttributes($this->attributes);
            //手动存储其他数据:创建时间,更新时间,作者,作者id
            $article->created_at = time();
            $article->updated_at = time();
            $article->summary = "文章简介,从文章中截取前50个字节";
            $article->user_id = \Yii::$app->user->identity->id;
            $article->user_name = \Yii::$app->user->identity->username;
            //1表示可见 0表示不可见
            $article->is_valid = Posts::IS_VALID;
            if (!$article->save()) {
                throw new Exception("存储失败了");
            }
            $transaction->commit();
            $this->id = $article->id;
            $data = array_merge($this->getAttributes(), $article->getAttributes());
            //说明:一个合格的函数,长度不应该超过120行
            $this->_eventAfterToDo($data);
            return true;
        } catch (Exception $ex) {
            //一旦代码出错/抛出异常/......
            $transaction->rollBack();
            $this->_lastError = $ex->getMessage();
            return false;
        }
    }

    //私有函数前加_是默认规则
    //私有函数/私有属性 一般是private,不一定非要用private
    public function _eventAfterToDo($data) {
        //on 绑定时间 off则是解除事件
        //说明:可以绑定多个事件
        //注意:一般来说,绑定事件要在init中实现
        $this->on(self::EVENT_AFTER_CREATE, [$this, '_saveTags'], $data);
        //事件执行:执行该字符串上的所有绑定事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    public function _saveTags($event) {
        $tags = new TagsForm();
        $tags->tags = $event->data['tags'];
        $tagids = $tags->saveTags();
        RelationPostTags::deleteAll(['post_id' => $event->data['id']]);
        if (!empty($tagids)) {
            foreach ($tagids as $k => $v) {
                $row[$k]['post_id'] = $this->id;
                $row[$k]['tag_id'] = $v;
            }
            $res = (new \yii\db\Query())->createCommand()->batchInsert(RelationPostTags::tableName(), ['post_id', 'tag_id'], $row)->execute();
            if (!$res) {
                throw new Exception("关联关系保存失败");
            }
        }
    }
    public function getArticleById($id){
        $data = Posts::find()->with('relate.tag',"extend")->where(['id'=>$id])->asArray()->one();
        if(!$data){
            throw new \yii\web\NotFoundHttpException("文章不存在");
        }
        $data['tags']=[];
        if(isset($data['relate']) && !empty($data["relate"])){
            foreach ($data['relate'] as $k=> $v){
                $data['tags'][] = $v['tag']['tag_name'];
            }
        }
        unset($data['relate']);
        return $data;
    }
    public function getArticleList($condition,$currentPage=1,$pageSize=5,$page=1,$limit=10,$orderBy=['id'=>SORT_DESC]){
        $model =new Posts();
        $query =$model->find()->where($condition)->with('relate.tag','extend')->orderBy($orderBy);
        $res= $model->getPages($query,$currentPage,$pageSize);
        $res['data']=  self::_formatList($res['data']);
        return $res;
    }
      private static function _formatList($data) {
        foreach ($data as &$list) {
            $list['tag'] = [];
            if (isset($list['relate']) && !empty($list['relate'])) {
                foreach ($list['relate'] as $lt) {
                    $list['tags'][] = $lt['tag']['tag_name'];
                }
            }
            unset($list['relate']);
        }

        return $data;
    }

}
