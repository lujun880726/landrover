<?php include ROOT_V_R . 'left.php' ?>
<!--right-->
<div class="content">
    <?php include ROOT_V_R . 'time.php' ?>
    <!--主要内容-->
    <div class="mainCon">
        <!--所在位置-->
        <div class="where"><a href="/"><span>主页</span></a> >  <span>角色管理</span> > <span>角色创建</span></div>

        <!--角色创建-->
        <div class="mainConBase">
            <h1>角色创建</h1>
            <div class="mainConBaseInner">
                <dl class="mainConInputStyle">
                    <form class="form-signin" role="form" action=""  method="post">
                        <dd>
                            <span>用户名</span>
                            <input type="text" name="uname"  value="<?php if (isset($muserInfo['uname'])) echo $muserInfo['uname'] ?>" />
                        </dd>
                        <dd>
                            <span>姓 名</span>
                            <input type="text" name="name" value="<?php if (isset($muserInfo['name'])) echo $muserInfo['name'] ?>" />
                        </dd>
                        <dd>
                            <span>城 市</span>
                            <select name="city">
                                <?php foreach ($conf['city'] as $key => $val): ?>
                                    <option  value="<?php echo $key; ?>" <?php if (isset($muserInfo['city']) && $key == $muserInfo['city']) echo "selected='true'" ?>><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </dd>
                        <dd>
                            <span>Email</span>
                            <input type="text"   name="email" value="<?php if (isset($muserInfo['uname'])) echo $muserInfo['email'] ?>" />
                        </dd>
                        <dd>
                            <span>电话号码</span>
                            <input type="text"  onblur="check_num();" id="phone" name="phone" value="<?php if (isset($muserInfo['phone'])) echo $muserInfo['phone'] ?>" />
                        </dd>
                        <dd>
                            <span>角 色</span>
                            <?php if ((isset($muserInfo['uid']) && 1 == $muserInfo['uid']) || $userInfo['role'] > 0): ?>
                                <?php echo $conf['role'][$muserInfo['role']] ?>
                            <?php else : ?>
                                <select name="role">
                                    <?php $tmpc = $conf ?>
                                    <?php unset($tmpc['role'][-1]) ?>
                                    <?php foreach ($tmpc['role'] as $key1 => $val1): ?>
                                        <option value="<?php echo $key1; ?>" <?php if (isset($muserInfo['role']) && $key1 == $muserInfo['role']) echo 'selected' ?>><?php echo $val1; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </dd>
                        <dd>
                            <span>&nbsp;</span>
                            <input type="submit" class="btnFuc" value="确定">
                        </dd>
                        <input type="hidden" name="uid" value="<?php if (isset($muserInfo['uid'])) echo $muserInfo['uid'] ?>" />
                    </form>
                </dl>
            </div>
        </div>
        <!--/角色创建-->
    </div>
    <!--/主要内容-->
</div>
<!--/right-->
</div>
<!--/wrap-->




<script>
<?php if ($err) : ?>
        var tipInfo = '<?php echo $err ?>';
<?php endif; ?>


    function check_num()
    {
        var re = /^[0-9,]*$/;
        if (!re.test($('#phone').val()))
        {
            alert("电话号码为纯数字");
            return false;
        }
        return true;
    }
</script>

