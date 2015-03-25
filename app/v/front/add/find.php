<?php
if (!isset($conf)){
    $conf = getCon('fieldVal');
}

?>
<?php if ($list) : ?>
    <table class="resault" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
        <thead>
            <tr>
                <td width="15%">CouponID</td>
                <td width="15%">姓名</td>
                <td width="16%">手机</td>
                <td width="16%">Email</td>
                <td width="18%">车型</td>
                <td width="20%">体验中心</td>
                <td width="20%">操作</td>
            </tr>
        </thead>

        <?php foreach ($list as $val) : ?>
            <?php $hotileInfoTmpArr[] = $val['coupon_id'] ?>
            <tr>
                <td><b><?php echo $val['coupon_id'] ?></b></td>
                <td><?php echo $val['name'] ?></td>
                <td><?php echo $val['mobile'] ?></td>
                <td><?php echo $val['email'] ?></td>
                <td width="20%"><?php echo $val['cx'] ?></td>
                <td><?php echo $conf['city'][$val['city']] ?></td>
                <td><input type="button" class="btnFuc" value="删除" onclick="delOne('<?php echo $val['coupon_id'] ?>')"></td>
            </tr>
            <?php $city               = $val['city']; ?>
        <?php endforeach; ?>
    </table>
<?php  else :?>
没有相关数据;
<?php endif; ?>
<script>
    function delOne(id)
    {

        $.post("/add/delone.html",
                {id: id},
        function(result) {
            alert(result);
            findd();
        });

    }
</script>