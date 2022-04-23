<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class MyUser extends ActiveRecord
{

    //返回要操作的表名
    public static function tableName()
    {
        return '{{%supplier}}';
    }

    //设置规则
    //注意，如果没有给字段设置规则，GridView的筛选项是不会出现的
    public function rules()
    {
        return [
            [['id', 'name', 'code', 't_status'], 'trim'],
            ['name', 'string'],
        ];
    }

    //查询
    public function search($params)
    {
        //首先我们先获取一个ActiveQuery
        $query = self::find();
        //然后创建一个ActiveDataProvider对象
        $provider = new ActiveDataProvider([
            //为ActiveDataProvider对象提供一个查询对象
            'query' => $query,
            //设置分页参数
            'pagination' => [
                //分页大小
                'pageSize' => 3,
                //设置地址栏当前页数参数名
                'pageParam' => 'page',
                //设置地址栏分页大小参数名
                'pageSizeParam' => 'pageSize',
            ],
        ]);

        //如果验证没通过，直接返回
        if (!($this->load($params) && $this->validate())) {
            return $provider;
        }

        //增加过滤条件
        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            //->andFilterWhere(['like', 'code' => $this->code])
            ->andFilterWhere(['t_status' => $this->t_status]);
        return $provider;
    }


}