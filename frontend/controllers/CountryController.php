<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Country;
use yii\data\Pagination;

/**
 * Description of CountryController
 *
 * @author Administrator
 */
class CountryController extends Controller{
    //put your code here
    public function actionIndex(){
        $query=  Country::find();
        //分页
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        //查询所有城市
//        $countrys =$query->all();
 //       $countrys =$query->where([">","population","100000000"])->all();
        
        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
    Country::findBySql("select * from country")->all();
        $countrys =$query->asArray()->all();
        //分段查询 分页
        foreach($query->batch(10) as $countrys) {
	// 内存中只保留10条数据的大小

        }

        
        return $this->render("index",["countries"=>$countries, 'pagination' => $pagination,
]);
    }
}

