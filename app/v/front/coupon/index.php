<?php include ROOT_V_R . 'left.php' ?>
<script src="/js/DatePicker/WdatePicker.js" type="text/javascript"></script>

<!--right-->
<div class="content">
    <?php include ROOT_V_R . 'time.php' ?>

    <!--主要内容-->
    <div class="mainCon">
        <!--所在位置-->
        <div class="where"><a href="/"><span>主页</span></a> >  <span>前台登记</span> > <span>登记查询</span></div>

        <?php if ($nArr) : ?>

            <div class="mainConBase">
                <div class="mainConBaseInner">
                    <div class="supplierReginfro">
                        <p class="supplierReginfro_num">共<b><span class="colorYellow"><?php echo count($nArr) ?></span></b>条coupon<span class="colorYellow">未登记</span>酒店信息</p>
                        <?php $i = 1; ?>
                        <?php foreach ($nArr as $val) : ?>
                            <?php echo $i % 2 > 0 ? '<dl>' : '' ?>
                            <dd><b>CouponID</b><b><?php echo $val['coupon_id'] ?></b><a href="/coupon/index/<?php echo $val['coupon_id'] ?>.html">立即登记</a></dd>
                            <?php echo $i % 2 < 1 ? '</dl>' : '' ?>
                            <?php $i ++; ?>
                        <?php endforeach; ?>

                        <?php echo $i % 2 < 1 ? '</dl>' : '' ?>

                        <div class="clearboth"></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!--登记查询-->
        <div class="mainConBase">
            <h1>登记查询</h1>
            <div class="mainConBaseInner">
                <div class="search taste">
                    <dl class="mainConInputStyle">
                        <dd>
                            <span class="w80">CouponID</span><input type="text" id="coupon_id" value="<?php echo $couponId; ?>" />
                            <span>姓名</span><input type="text" name="name_"  id="name_" value="<?php echo $name_; ?>"/>
                            <span>手机</span><input type="text" name="mobile" id="mobile" value="<?php echo $mobile; ?>"/>
                            <input type="button" onclick="sub();" class="btnFuc" value="查找">
                        </dd>
                    </dl>
                </div>
                <?php $hotileInfoTmpArr = array(); ?>
                <?php $city             = ''; ?>
                <?php if ($list) : ?>
                    <!--查询结果-->
                    <table class="resault" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
                        <thead>
                            <tr>
                                <td width="15%">CouponID</td>
                                <td width="15%">姓名</td>
                                <td width="16%">手机</td>
                                <td width="16%">Email</td>
                                <td width="18%">车型</td>
                                <td width="20%">体验中心</td>
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
                            </tr>
                            <?php $city               = $val['city']; ?>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
                <!--/查询结果-->
            </div>
        </div>
        <!--/登记查询-->

        <?php if ($list) : ?>

            <!--到场登记-->
            <div class="mainConBase">
                <h1>到场登记</h1>
                <div class="mainConBaseInner">
                    <?php if (in_array($userInfo['role'], array(-1, 2))): ?>
                        <form class="form-signin" role="form" action=""  method="post" id="form1">
                            <div class="useFuc">
                                使用方式：<input type="radio"  name="user_type" value="1" <?php if (isset($list[0]['user_type']) && 1 == $list[0]['user_type']) echo 'checked="checked"'; ?>/>同行使用
                                <input type="radio" name="user_type" value="2" <?php if (isset($list[0]['user_type']) && 2 == $list[0]['user_type']) echo 'checked="checked"'; ?>/>拆分使用
                            </div>
                            <div class="useFuc" id='idInfo' style=" display: <?php echo (isset($list[0]['user_type']) && 1 == $list[0]['user_type']) ? 'none' : 'block' ?>">
                                选择使用酒店的券号:
                                <?php foreach ($list as $val) : ?>
                                    <?php $tmpsjq = $obj->db->getRow('coupon_base_u', array(array('coupon_id', $val['coupon_id'])));
                                    ?>
                                    <input type="radio" name="cp_ids" value="<?php echo $val['coupon_id'] ?>" <?php if (isset($tmpsjq['who_hotel']) && $tmpsjq['who_hotel'] > 0) echo 'checked="checked"'; ?> /><?php echo $val['coupon_id'] ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <div class="useFuc">使用方式：<?php echo 1 == $list[0]['user_type'] ? '同行使用' : '拆分使用'; ?></div>
                        <?php endif; ?>
                        <script>
                            $(function() {
                                $("input[name='user_type']").change(function() {
                                    if (1 == $(this).val()) {
                                        $('#idInfo').hide();
                                    } else {
                                        $('#idInfo').show();
                                    }
                                });
                            })
                        </script>
                        <div class="line subLine"></div>
                        <!--20140708修改部分-->
                        <div class="tasteDei">
                            <ul>

                                <?php foreach ($list as $val) : ?>
                                    <?php $temp = $obj->db->getRow('coupon_base_u', array(array('coupon_id', $val['coupon_id']))); ?>
                                    <?php if (in_array($userInfo['role'], array(-1, 2)) && @$temp['state'] < 3): ?>

                                        <li>
                                            <div class="useFuc"><b>CouponID：<?php echo $val['coupon_id'] ?></b>车型：<?PHP ECHO $val['cx']; ?></div>
                                            <div class="taste_reg">
                                                <dl class="mainConInputStyle">
                                                    <dd><span><em>*</em>姓名</span><input type="text" tmpval="name" id="c_<?php echo $val['coupon_id'] ?>_name" name="c[<?php echo $val['coupon_id'] ?>][name]" value="<?php echo isset($temp['name']) ? ($temp['name']) : $val['name'] ?>"/>
            <!--                                                  <span >
                                                            <em>*</em>称谓

                                                        </span>
                                                        -->
                                                        <?php $title = isset($temp['title']) ? ($temp['title']) : $val['title'] ?>
                                                        <?php foreach ($conf['sex'] as $vSex) : ?>
                                                            <input style="width:15px;height:15px;border:0 none;" type="radio" name="c[<?php echo $val['coupon_id'] ?>][title]" id="c_<?php echo $val['coupon_id'] ?>_title" value="<?php echo $vSex ?>" <?php if ($title == $vSex) echo 'checked="checked"'; ?> /><?php echo $vSex ?>
                                                        <?php endforeach; ?>
                                                    </dd>
                                                    <dd><span><em>*</em>手机</span><input type="text" tmpval="mobile" onBlur="" id="c_<?php echo $val['coupon_id'] ?>_mobile" name="c[<?php echo $val['coupon_id'] ?>][mobile]" value="<?php echo isset($temp['mobile']) ? ($temp['mobile']) : $val['mobile'] ?>"/></dd>
                                                    <dd><span><em></em>Email</span><input type="text" tmpval="email" onblur="" id="c_<?php echo $val['coupon_id'] ?>_email" name="c[<?php echo $val['coupon_id'] ?>][email]" value="<?php echo isset($temp['email']) ? ($temp['email']) : $val['email'] ?>"/></dd>
                                                    <dd><span><em>*</em>身份证</span><input type="text" tmpval="identity_card" onblur="" id="c_<?php echo $val['coupon_id'] ?>_identity_card" name="c[<?php echo $val['coupon_id'] ?>][identity_card]" value="<?php echo isset($temp['identity_card']) && $temp['identity_card'] ? ($temp['identity_card']) : '' ?>"/></dd>
                                                    <dd><span><em>*</em>体验预约时间</span><input onchange="xytoday($(this).val());"  tmpvalrq="rq" class="Wdate " type="text" id="c_<?php echo $val['coupon_id'] ?>_yy_time" name="c[<?php echo $val['coupon_id'] ?>][yy_time]" onFocus="WdatePicker({dateFmt: 'yyyy-MM-dd'})" placeholder="结束时间" value="<?php echo isset($temp['yy_time']) && $temp['yy_time'] ? date('Y-m-d', $temp['yy_time']) : date('Y-m-d') ?>"></dd>
                                                    <dd><span><em>*</em>状态</span>
                                                        <select name="c[<?php echo $val['coupon_id'] ?>][state]" id="c_<?php echo $val['coupon_id'] ?>_state" >
                                                            <?php $state = isset($temp['state']) ? ($temp['state']) : 0 ?>
                                                            <?php foreach ($conf['state'] as $keySt => $vSt) : ?>
                                                                <option value="<?php echo $keySt ?>" <?php if ($state == $keySt) echo 'selected'; ?>><?php echo $vSt ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <input type="hidden" name="c[<?php echo $val['coupon_id'] ?>][city]" value="<?php echo isset($temp['city']) ? ($temp['city']) : $val['city'] ?>"/>
                                                    </dd>

                                                </dl>
                                            </div>
                                        </li>

                                    <?php else : ?>

                                        <li>
                                            <div class="useFuc"><b>CouponID：<?php echo $val['coupon_id'] ?></b>车型：<?PHP ECHO $val['cx']; ?></div>
                                            <div class="taste_reg">
                                                <dl class="mainConInputStyle">
                                                    <dd><span>姓名</span><i><?php echo isset($temp['name']) ? ($temp['name']) : $val['name'] ?></i><span class="spe">称谓</span><i><?php echo isset($temp['title']) ? ($temp['title']) : $val['title'] ?></i></dd>
                                                    <dd><span>手机</span><i><?php echo isset($temp['mobile']) ? ($temp['mobile']) : $val['mobile'] ?></i></dd>
                                                    <dd><span>Email</span><i><?php echo isset($temp['email']) ? ($temp['email']) : $val['email'] ?></i></dd>

                                                    <dd>
                                                        <span>身份证</span>
                                                        <i  id="edit_<?php echo $val['coupon_id'] ?>"><?php echo isset($temp['identity_card']) ? ($temp['identity_card']) : '' ?>
                                                            <?php if (3 == $userInfo['role']) : ?>
                                                                <input class="btnFucsfx" type="button" value="修改" onclick="edit_id_care('<?php echo $val['coupon_id'] ?>', '<?php echo isset($temp['identity_card']) ? ($temp['identity_card']) : '' ?>');"/>
                                                            <?php endif; ?>
                                                        </i>
                                                    </dd>

                                                    <dd><span>体验预约时间</span><i><?php echo isset($temp['yy_time']) && $temp['yy_time'] ? date('Y-m-d', @$temp['yy_time']) : ''; ?></i></dd>
                                                    <dd><span>状态</span><i class="colorYellow"><?php echo isset($temp['state']) ? $conf['state'][$temp['state']] : ''; ?></i></dd>
                                                </dl>
                                                <?php if ($temp['state'] == 3) : ?>
                                                    <input type="hidden" tmpval="name"  name="c[<?php echo $temp['coupon_id'] ?>][name]"   value="<?php echo $temp['name']; ?>" />
                                                    <input type="hidden" tmpval="identity_card"  name="c[<?php echo $temp['coupon_id'] ?>][identity_card]"   value="<?php echo $temp['identity_card']; ?>" />
                                                    <input type="hidden"  name="c[<?php echo $temp['coupon_id'] ?>][city]"   value="<?php echo $temp['city']; ?>" />
                                                    <input type="hidden"   name="c[<?php echo $temp['coupon_id'] ?>][coupon_id]"   value="<?php echo $temp['coupon_id']; ?>" />
                                                    <input type="hidden"   name="c[<?php echo $temp['coupon_id'] ?>][title]"   value="<?php echo $temp['title']; ?>" />
                                                    <input type="hidden" tmpval="mobile"  name="c[<?php echo $temp['coupon_id'] ?>][mobile]"   value="<?php echo $temp['mobile']; ?>" />
                                                    <input type="hidden" tmpval="email"  name="c[<?php echo $temp['coupon_id'] ?>][email]"   value="<?php echo $temp['email']; ?>" />
                                                    <input type="hidden"  tmpvalrq="rq" name="c[<?php echo $temp['coupon_id'] ?>][yy_time]"   value="<?php echo date('Y-m-d', $temp['yy_time']); ?>" />
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                            <div class="clearboth"></div>
                        </div>
                        <!--/20140708修改部分-->
                </div>
            </div>
            <?php if (in_array($userInfo['role'], array(-1, 2))): ?>
                <dl class="mainConInputStyle">
                    <dd class="txtC">
                        <input class="btnFuc" type="button" value="确认登记" onclick="dq()">
                    </dd>
                </dl>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <!--/到场登记-->
        <script>
<?php
$rqArr = array(
    1 => '2014-12-31',
    2 => '2015-03-31',
    3 => '2015-02-28',
);
//
// 'city'  => array(
//        1 => '北京',
//        2 => '广州',
//        3 => '湖州',
//        4 => '成都',
//    ),
?>

            function edit_id_care(id_card, yval)
            {
                var hstr = " <input type='text'  id='sfz" + id_card + "' value='" + yval + "' width='650px;'/>  ";
                hstr += "<input type='button' class='btnFucsfx' value='确定' onclick='sfzsub(\"" + id_card + "\");'      />                     ";

                $('#edit_' + id_card).html(hstr);
            }

            function sfzsub(id_card)
            {
                sfz_ = $('#sfz' + id_card).val();

                if (false == sfzLen(sfz_)) {
                    return false;
                }
                $.post("/coupon/sfzedit.html",
                        {sfz: sfz_, cp_id: id_card},
                function(result) {
                    alert(result.msg);
                    location.reload();
                });
            }
            function dq()
            {
                str = '<?php echo json_encode($ids) ?>';
                var ids = JSON.parse(str);

                tmp = $('input[name="user_type"]:checked').val();
                if (!tmp) {
                    alert('请选择使用方式');
                    return false;
                }
                if (1 == tmp)
                {
                    tmp1 = true;
                    $('#form1 input[type=text]').each(function() {
                        tmpval = $(this).attr('tmpval');
                        tmpvalrq = $(this).attr('tmpvalrq')
                        if (tmpval == 'name') {
                            if (!$(this).val()) {
                                $(this).focus();
                                alert('姓名不能为空');
                                tmp1 = false;
                                return false;
                            }
                        }
                        if (tmpval == 'mobile') {
                            if (false == checkMobile($(this).val())) {
                                $(this).focus();
                                tmp1 = false;
                                return false;
                            }
                        }
                        if (tmpval == 'email') {
                            if ($(this).val() && false == checkEmail($(this).val())) {
                                $(this).focus();
                                tmp1 = false;
                                return false;
                            }
                        }
                        if (tmpval == 'identity_card') {
                            if (false == sfzLen($(this).val())) {
                                $(this).focus();
                                tmp1 = false;
                                return false;
                            }
                        }
<?php if (isset($list[0]['city']) && $list[0]['city'] < 4) : ?>
                            if (tmpvalrq == 'rq') {
                                if (false == checkdate($(this).val(), '<?php echo $rqArr[$list[0]['city']] ?>')) {
                                    tmp1 = false;
                                    return false;
                                }
                                //
                            }
<?php endif; ?>
                    });
                    tmpDate = '';
                    if (false == tmp1) {
                        return false;
                    }
                    for (var key = 0; key < ids.length; key++) {
                        tmpkey = '#c_' + ids[key] + '_yy_time';
                        if (key < 1) {
                            tmpDate = $(tmpkey).val();
                            continue;
                        } else {
                            if (tmpDate != $(tmpkey).val()) {
                                alert('同行使用预约时间必须一样');
                                tmp1 = false;
                                return false;
                            }
                        }
                        if ($('#c_' + ids[key] + '_state') > 0) {
                            if (false == xytoday($(tmpkey).val())) {
                                tmp1 = false;
                                return false;
                            }
                        }
                    }
                    if (false == tmp1) {
                        return false;
                    }
                    for (var key = 0; key < ids.length; key++) {
                        tmpkey = '#c_' + ids[key] + '_state';
                        if ($(tmpkey).val() < 1) {
                            alert('体验券状态选项错误，请检查后重新选择');
                            tmp1 = false;
                            return false;
                        }
                    }
                    if (false == tmp1) {
                        return false;
                    }
                    if (true == tmp1) {
                        $('#form1').submit();
                    }

                } else {

                    oneYy = false;
                    seJdCo = $("input[name='cp_ids']:checked").val();
                    if (!seJdCo) {
                        alert('拆分使用必须选择酒店使用券');
                        return false;
                    }

                    if ($('#c_' + seJdCo + '_state').val() > 0) {
                        if ($('#c_' + seJdCo + '_name').val() && checkMobile($('#c_' + seJdCo + '_mobile').val()) && ($('#c_' + seJdCo + '_email').val() && checkEmail($('#c_' + seJdCo + '_email').val())) && sfzLen($('#c_' + seJdCo + '_identity_card').val())) {
                            oneYy = true;
                        } else {
                            return false;
                        }
<?php if (isset($list[0]['city']) && $list[0]['city'] < 4) : ?>
                            if (false == checkdate($('#c_' + seJdCo + '_yy_time').val(), '<?php echo $rqArr[$list[0]['city']] ?>')) {
                                tmp1 = false;
                                return false;
                            }
                            //
<?php endif; ?>
                    } else {
                        alert('体验券状态选项错误，请检查后重新选择');
                        tmp1 = false;
                        return false;
                    }

                    for (var key = 0; key <= ids.length; key++) {
                        if ($('#c_' + ids[key] + '_state').val() > 0) {
                            if (xytoday($('#c_' + ids[key] + '_yy_time').val()) && $('#c_' + ids[key] + '_name').val() && checkMobile($('#c_' + ids[key] + '_mobile').val()) && ($('#c_' + ids[key] + '_email').val() && checkEmail($('#c_' + ids[key] + '_email').val())) && sfzLen($('#c_' + ids[key] + '_identity_card').val())) {
                                oneYy = true;
                            } else {
                                return false;
                            }
<?php if (isset($list[0]['city']) && $list[0]['city'] < 4) : ?>
                                if (false == checkdate($('#c_' + ids[key] + '_yy_time').val(), '<?php echo $rqArr[$list[0]['city']] ?>')) {
                                    tmp1 = false;
                                    return false;
                                }
                                //
<?php endif; ?>
                        }
                    }
                    if (true == oneYy) {
                        $('#form1').submit();
                    } else {
                        alert('拆分使用时已预约数据必须填写完整');
                    }

                }
            }
        </script>




        <!--酒店登记-->
        <?php if ($list) : ?>
            <?php
            rsort($hotileInfoTmpArr);
            $hotileInfoKey = implode('-', $hotileInfoTmpArr);
            $hotileInfo    = $obj->db->getRow('hotel_info', array(array('hotel_key', $hotileInfoKey)));
            ?>
            <?php if (in_array($userInfo['role'], array(3)) && $hotileInfo['state'] < 3): ?>
                <form class="form-signin" role="form" action=""  method="post" id="formjd">
                    <div class="mainConBase">
                        <h1>酒店登记</h1>
                        <div class="mainConBaseInner">
                            <dl class="mainConInputStyle">
                                <dd>
                                    <p style="color: red;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请预订前和客户联系核实个人信息，确认入住时间，谢谢!</p>
                                </dd>
                                <dd>
                                    <span>使用酒店券号</span>
                                    <?php
                                    $sql      = "select *   from coupon_base_u where coupon_id in ('" . implode("','", $hotileInfoTmpArr) . "')";
                                    $num      = $obj->db->query($sql);
                                    $qdqhList = array();
                                    while ($row      = mysql_fetch_array($num, MYSQL_ASSOC)) {
                                        $qdqhList[] = $row;
                                    }
                                    foreach ($qdqhList as $sdqh) {
                                        if (1 == $sdqh['who_hotel']) {
                                            echo $sdqh['coupon_id'] . ' ';
                                        }
                                    }
                                    ?>
                                </dd>
                                <dd>
                                    <span>酒店名称</span>
                                    <input id="hotelNmae" name="hotel[<?php echo $hotileInfoKey; ?>][hotel_id]" type="text" value="<?php echo isset($hotileInfo['hotel_id']) ? @$hotileInfo['hotel_id'] : ''; ?>" />

                                </dd>
                                <!--                                <dd>
                                                                    <span>预定代码</span>
                                                                    <input type="text" name="hotel[<?php echo $hotileInfoKey; ?>][reserve_code]" value="<?php echo isset($hotileInfo['reserve_code']) ? $hotileInfo['reserve_code'] : ''; ?>"/>
                                                                </dd>-->
                                <dd><span>入住时间</span>
                                    <input class="Wdate " type="text" name="hotel[<?php echo $hotileInfoKey; ?>][check_in_time]" onFocus="WdatePicker({dateFmt: 'yyyy-MM-dd'})" placeholder="结束时间" value="<?php echo isset($hotileInfo['check_in_time']) && $hotileInfo['check_in_time'] ? date('Y-m-d', $hotileInfo['check_in_time']) : date('Y-m-d'); ?>"><BR>
                                </dd>
                                <dd>
                                    <span>使用状态</span>
                                    <select name="hotel[<?php echo $hotileInfoKey; ?>][state]"><BR>
                                        <?php $state = isset($temp['state']) ? ($temp['state']) : 0 ?>
                                        <?php foreach ($conf['state'] as $keyhSt => $vhSt) : ?>
                                            <option value="<?php echo $keyhSt ?>" <?php if (isset($hotileInfo['state']) && $hotileInfo['state'] == $keyhSt) echo 'selected'; ?>><?php echo $vhSt ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </dd>
                            </dl>
                            <input type="hidden" name="hotel[<?php echo $hotileInfoKey; ?>][city]" value="<?php echo $city; ?>" />
                        </div>
                    </div>
                    <!--/酒店登记-->
                    <dl class="mainConInputStyle">
                        <dd class="txtC"><input type="button" onclick="sub_jd()" class="btnFuc" value="确认登记"></dd>
                    </dl>
                </form>
            <?php else : ?>
                <div class="mainConBase">
                    <h1>酒店登记</h1>
                    <div class="mainConBaseInner">
                        <dl class="mainConInputStyle">
                            <dd>
                                <span>使用酒店券号</span>
                                <?php
                                $sql      = "select *   from coupon_base_u where coupon_id in ('" . implode("','", $hotileInfoTmpArr) . "')";
                                $num      = $obj->db->query($sql);
                                $qdqhList = array();
                                while ($row      = mysql_fetch_array($num, MYSQL_ASSOC)) {
                                    $qdqhList[] = $row;
                                }
                                foreach ($qdqhList as $sdqh) {
                                    if (1 == $sdqh['who_hotel']) {
                                        echo $sdqh['coupon_id'] . ' ';
                                    }
                                }
                                ?>
                            </dd>
                            <dd>

                                <span>酒店名称</span><i><?php echo isset($hotileInfo['hotel_id']) ? @$hotileInfo['hotel_id'] : ''; ?></i></dd>
                            <dd><span>入住时间</span><i><?php echo isset($hotileInfo['check_in_time']) && $hotileInfo['check_in_time'] ? date('Y-m-d', $hotileInfo['check_in_time']) : ''; ?></i></dd>
                            <dd><span>使用状态</span><i class="colorYellow"><?php echo isset($hotileInfo['state']) ? $conf['state'][$hotileInfo['state']] : ''; ?></i></dd>
                        </dl>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <!--/酒店登记-->
        <script>
            function sub_jd()
            {
                if (!$('#hotelNmae').val()) {
                    alert('请选择酒店');
                    return false;
                } else {
                    $('#formjd').submit();
                }
            }
        </script>
    </div>
    <!--/主要内容-->
</div>
<!--/right-->
</div>
<!--/wrap-->

<script>

<?php if ($err) : ?>
        var tipInfo = '<?php echo $err; ?>';


<?php endif; ?>

    function sub()
    {
        coupon_id = $('#coupon_id').val();
        name_ = $('#name_').val();
        mobile = $('#mobile').val();
        if (!coupon_id) {
            coupon_id = 0;
        }
        if (!name_) {
            name_ = null;
        }
        if (!mobile) {
            mobile = null;
        }
        location.href = "/coupon/index/" + coupon_id + "_" + encodeURI(name_) + "_" + mobile + "_.html";
    }

    function checkMobile(s) {
        var regu = /^[1][3][0-9]{9}$/;
        var re = new RegExp(regu);
        if (re.test(s)) {
            return true;
        } else {
            alert('请正确填写手机号');
            return false;
        }
    }

    function checkEmail(str) {
        var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if (reg.test(str)) {
            return true;
        } else {
            alert('请正确填写邮箱');
            return false;
        }
    }

    function sfzLen(str)
    {
        if (str.length != 18) {
            alert('身份证号码必须18位');
            return false;
        }
        return true;
    }

    function checkdate(nt, jzt)
    {
        //得到日期值并转化成日期格式，replace(/\-/g, "\/")是根据验证表达式把日期转化成长日期格式，这样
//再进行判断就好判断了
        var sDate = new Date(nt.replace(/\-/g, "\/"));
        var eDate = new Date(jzt.replace(/\-/g, "\/"));
        if (nt > jzt)
        {
            alert("预约时间不能超过" + jzt);
            return false;
        }
        return true;
    }

    function xytoday(seDate)
    {
        nDay = '<?php echo date('Y-m-d'); ?>';
        var seDate = new Date(seDate.replace(/\-/g, "\/"));
        var nDay = new Date(nDay.replace(/\-/g, "\/"));
        if (seDate <= nDay)
        {
            alert("预约时间必须大于当前时间");
            return false;
        }
        return true;
    }
</script>