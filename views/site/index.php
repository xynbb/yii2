<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary" id="showSelBtn">搜索</button>
            <?php
                echo Html::a('导出', ['create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#ajax'])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php echo GridView::widget([
                //设置GridView的ID
                'id' => 'myUserGridView',
                //设置数据提供器
                'dataProvider' => $provider,
                //设置筛选模型
                'filterModel' => $model,
                'columns' => [
                    //复选框列
                    ['class' => 'yii\grid\CheckboxColumn'],
                    //显示序号列
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        //设置字段显示标题
                        'label' => 'ID',
                        //字段名
                        'attribute' => 'id',
                        //格式化
                        'format' => 'raw',
                        //设置单元格样式
                        'headerOptions' => [
                            'style' => 'width:120px;',
                        ],
                    ],
                    [
                        'label' => '姓名',
                        'attribute' => 'name',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Code',
                        'attribute' => 'code',
                        'format' => 'raw',
                    ],
                    [
                        'label' => '状态',
                        //设置筛选选项
                        'filter' => ['ok' => 'ok', 'hold' => 'hold'],
                        'attribute' => 't_status',
                        'format' => 'raw',
                    ]
                ],
            ]); ?>
        </div>
    </div>

    <div class="modal bs-example-modal-lg" id="ajax">
        <div class="modal-dialog">
            <div class="modal-content width_reset" id="tmpl-modal-output-render" style="min-height: 200px;">

                <div class="showDiv_edit">
                    <div class="showDiv_con">
                        <?php $form = ActiveForm::begin(['action'=>['site/export'], 'method'=>'post',]); ?>
                        <?= $form->field($model, 'id')->checkboxList(['1'=>'ID','2'=>'姓名','3'=>'code','4'=>'状态']);?>
                        <div class="btn_bar">
                            <?php echo Html::submitButton('确认', ['class' => 'btn btn-success']) ?>
                            <a href="javascript:void(0);" class="btn btn_default">取消</a>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php echo Html::jsFile('@web/js/jquery-3.5.1.min.js'); ?>
<script type="text/javascript">
    $("#showSelBtn").on("click", function () {
        var keys = $("#myUserGridView").yiiGridView('getSelectedRows');
        alert(keys);
    });
</script>