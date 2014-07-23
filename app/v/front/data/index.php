<?php include ROOT_V_R . 'left.php' ?>
<script src="/js/DatePicker/WdatePicker.js" type="text/javascript"></script>
<!--right-->
<div class="content">
    <?php include ROOT_V_R . 'time.php' ?>
    <!--主要内容-->
    <div class="mainCon">
        <!--所在位置-->
        <div class="where"><a href="/"><span>主页</span></a> >  <span>其他管理</span> > <span>统计查询</span></div>

        <!--统计查询-->
        <div class="mainConBase">
            <h1>统计查询</h1>
            <div class="mainConBaseInner">
                <p>截止<?php echo date('Y-m-d'); ?>统计结果如下</p>
                <!--查询结果-->
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
                                    <td><a   class="linkYellow" href="/data/index/<?php echo $val['city']?>_1_1.html"><?php echo $val['is_yy'] ?></a></td>
                                    <td><a  class="linkYellow"  href="/data/index/<?php echo $val['city']?>_3_1.html"><?php echo $val['is_user'] ?></a></td>
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
                                    <td><a    class="linkYellow" href="/data/index/<?php echo $val['city']?>_0_2.html"><?php echo $val['hotile_is_no_yy'] ?></a></td>
                                    <td><a    class="linkYellow" href="/data/index/<?php echo $val['city']?>_1_2.html"><?php echo $val['hotile_is_yy'] ?></a></td>
                                    <td><a    class="linkYellow" href="/data/index/<?php echo $val['city']?>_3_2.html"><?php echo $val['hotile_is_user'] ?></a></td>
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
                            <td><a    class="linkYellow" href="/coupon/index/<?php echo $row['coupon_id'] ?>_null_null_.html">查看详情</a></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                <?php endif; ?>

                <!--/查询结果-->
            </div>
        </div>
        <!--/统计查询-->

        <!--数据导出-->
        <?php if (in_array($userInfo['role'], array(-1, 1, 3))): ?>
            <div class="mainConBase">
                <h1>数据导出</h1>
                <div class="mainConBaseInner">
                    <dl class="mainConInputStyle">
                        <?php if (3 != $userInfo['role']): ?>
                            <form class="form-signin" role="form" action="/data/export.html"  method="post">
                                <dd>
                                    <span>原始数据导出</span>
                                    <select name="city">
                                        <?php if (2 == $userInfo['role']): ?>
                                            <option  value="<?php echo $userInfo['city']; ?>" ><?php echo $conf['city'][$userInfo['city']]; ?></option>
                                        <?php else : ?>
                                            <?php foreach ($conf['city'] as $key => $val): ?>
                                                <option  value="<?php echo $key; ?>" <?php if (isset($muserInfo['city']) && $key == $muserInfo['city']) echo "selected='true'" ?>><?php echo $val; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </select>
                                    <input type="submit" class="btnFuc" value="导出数据">
                                    <input type="hidden" name="data_type" value="1" />
                                </dd>
                            </form>
                        <?php endif; ?>
                        <div class="line subLine"></div>
                        <form class="form-signin" role="form" action="/data/export.html"  method="post">
                            <dd>
                                <span>数 据</span>
                                <?php if (3 == $userInfo['role']): ?>
                                    <select name="data_type">
                                        <option value="3">酒店信息导出</option>
                                    </select>
                                <?php else : ?>
                                    <select name="data_type">
                                        <option value="2">更新数据导出</option>
                                        <option value="3">酒店信息导出</option>
                                    </select>
                                <?php endif; ?>
                            </dd>

                            <dd><span>登记时间</span>
                                <input class="Wdate " type="text" name="btime" onFocus="WdatePicker({dateFmt: 'yyyy-MM-dd'})" placeholder="开始时间" value="<?php echo isset($temp['btime']) && $temp['btime'] ? date('Y-m-d', $temp['btime']) : date('Y-m-d') ?>">
                                至
                                <input class="Wdate " type="text" name="etime" onFocus="WdatePicker({dateFmt: 'yyyy-MM-dd'})" placeholder="结束时间" value="<?php echo isset($temp['etime']) && $temp['etime'] ? date('Y-m-d', $temp['etime']) : date('Y-m-d') ?>">
                            </dd>
                            <dd>
                                <span>城 市</span>

                                <select name="city">
                                    <?php $conf['city'][0] = '全部'; asort($conf['city']); ?>
                                    <?php if (2 == $userInfo['role']): ?>
                                        <option  value="<?php echo $userInfo['city']; ?>" ><?php echo $conf['city'][$userInfo['city']]; ?></option>
                                    <?php else : ?>
                                        <?php foreach ($conf['city'] as $key => $val): ?>
                                            <option  value="<?php echo $key; ?>" <?php if (isset($muserInfo['city']) && $key == $muserInfo['city']) echo "selected='true'" ?>><?php echo $val; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </select>
                            </dd>
                            <dd>
                                <span>coupon状态</span>
                                <select name="state">
                                    <?php $conf['state'][0] = '全部' ?>
                                    <?php foreach ($conf['state'] as $keySt => $vSt) : ?>
                                        <option value="<?php echo $keySt ?>" ><?php echo $vSt ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </dd>
                            <dd>
                                <span>&nbsp;</span>
                                <input type="submit" class="btnFuc" value="导出数据">
                            </dd>
                        </form>
                    </dl>
                </div>
            </div>
        <?php endif; ?>

        <!--/数据导出-->
    </div>
    <!--/主要内容-->
</div>
<!--/right-->
</div>
<!--/wrap-->
