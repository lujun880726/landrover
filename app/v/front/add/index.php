<?php include ROOT_V_R . 'left.php' ?>
<!--right-->
<div class="content">
    <?php include ROOT_V_R . 'time.php' ?>
    <!--主要内容-->
    <div class="mainCon">
        <!--所在位置-->
        <div class="where"><a href="/"><span>主页</span></a> >  <span>角色管理</span> > <span>角色查询</span></div>
        <!--角色查询-->
        <div class="mainConBase">
            <h1>上传数据</h1>
            <div class="mainConBaseInner">
                <form class="form-signin" role="form" action=""  method="post" enctype="multipart/form-data">
                    <input type="file" name="fileField" class="file" id="fileField" size="28" onchange="document.getElementById('textfield').value=this.value" />
                    <input type="submit" class="btnFuc" value="确定">
                </form>


            </div>
        </div>
        <!--/角色查询-->

        <div class="mainConBase">
            <h1>数据处理</h1>
            <div class="mainConBaseInner">
                    <input type="text" name="findName"  id="findName" size="28" />
                    <input type="button" class="btnFuc" value="确定" onclick="findd()"><span style="color: red">(只查询未处理的数据)</span>
                <div id="findList">

                </div>
            </div>
        </div>
    </div>
    <!--/主要内容-->
</div>
<!--/right-->
</div>
<!--/wrap-->

<script>
     function findd()
    {
        $("#findList").load('/add/find/' + $('#findName').val() + '.html');
    }
</script>
<script>
<?php if ($err) : ?>
        var tipInfo = '<?php echo $err ?>';
<?php endif; ?>

</script>
