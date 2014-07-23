<?php include ROOT_V_R . 'left.php' ?>

<!--right-->
<div class="content">
    <?php include ROOT_V_R . 'time.php' ?>

    <!--主要内容-->
        <div class="mainCon mainConIndex">
            <!--所在位置-->
            <div class="where"><a href="/">首页</a></div>

            <!--体验中心-->
            <div class="areaTit">体验中心</div>
             <?php if (in_array($userInfo['role'], array(-1,1,2))): ?>
                <table class="resault" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >

                        <thead>
                            <tr>
                                <td width="16%">地区</td>
                                <td width="16%">体验券总数</td>
                                <td width="17%">未预约数量</td>
                                <td width="17%">已预约数量</td>
                                <td width="17%">已完成数量</td>
                            </tr>
                        </thead>
                        <?php if ($reArr) : ?>
                            <?php foreach ($reArr as $key => $val): ?>
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $val['coupon_all_num'] ?></td>
                                    <td><?php echo $val['no_jh'] ?></td>
                                    <td><a class="linkYellow" href="/index/index/<?php echo $val['city']?>_1_1.html"><?php echo $val['is_yy'] ?></a></td>
                                    <td><a  class="linkYellow"  href="/index/index/<?php echo $val['city']?>_3_1.html"><?php echo $val['is_user'] ?></a></td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>

                </table>
                <?php endif; ?>
                <?php if (in_array($userInfo['role'], array(-1,1,3))): ?>
                <table class="resault" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
                        <thead>
                            <tr>
                                <td width="16%">地区</td>
                                <td width="16%">酒店待预约数量</td>
                                <td width="17%">酒店已预约数量</td>
                                <td width="17%">酒店已入住数量</td>
                            </tr>
                        </thead>
                        <?php if ($reArr) : ?>
                            <?php foreach ($reArr as $key => $val): ?>
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><a    class="linkYellow"  href="/index/index/<?php echo $val['city']?>_0_2.html"><?php echo $val['hotile_is_no_yy'] ?><a></td>
                                    <td><a    class="linkYellow"  href="/index/index/<?php echo $val['city']?>_1_2.html"><?php echo $val['hotile_is_yy'] ?><a></td>
                                    <td><a   class="linkYellow"  href="/index/index/<?php echo $val['city']?>_3_2.html"><?php echo $val['hotile_is_user'] ?><a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                </table>
                <?php endif; ?>




            <?php if ($sx): ?>
                    <table class="resault" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >

                        <thead>
                            <tr>
                                <td width="16%">CouponID</td>
                                <td width="16%">姓名</td>
                                <td width="17%">手机</td>
                                <?PHP IF (1 == $type) : ?>
                                    <?php if (1 == $state): ?>
                                        <td width="17%">预约时间</td>
                                    <?php else : ?>
                                        <td width="17%">完成时间</td>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if ($state < 1): ?>
                                        <td width="17%">待预约时间</td>
                                    <?php endif; ?>
                                    <?php if (1 == $state): ?>
                                        <td width="17%">已预约时间</td>
                                    <?php endif; ?>
                                    <?php if (3 == $state): ?>
                                        <td width="17%">已入住时间</td>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <td width="17%">查看详细</td>
                            </tr>
                        </thead>
                        <?php foreach ($sx as $row) :?>
                        <tr>
                            <td><?php echo $row['coupon_id'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['mobile'] ?></td>
                            <td><?php echo date('Y-m-d',$row['utime']) ?></td>
                            <td><a   class="linkYellow"  href="/coupon/index/<?php echo $row['coupon_id'] ?>_null_null_.html">查看详情</a></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                <?php endif; ?>
                <!--/查询结果-->

        </div>
        <!--/主要内容-->
</div>
<!--/right-->
</div>
<!--/wrap-->





