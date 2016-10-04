<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Вход</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/blue.css">
    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/index.css" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/">Goodman</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Введите свои данные</p>
        <?php if((count($errors)>0)):?>
            <?php if(isset($errors['cookie'])){?>
                <div class="callout callout-warning">
                    <p>Пожалуйста проверьте, включены ли у вас cookie</p>
                </div>
            <?php } else{ ?>
                <div class="callout callout-danger">
                    <h4>Ошибка!</h4>
                    <p>Вы ввели неверные данные, проверьте данные в форме и повторите попытку</p>
                </div>
            <?php } ?>
        <?php endif;?>
        <form class="admin__form" action="/admin" method="post">
            <div class="form-group has-feedback<?= (isset($errors['login'])) ? ' has-error': ''?>">
                <span class="input input_has-clear input_width_full">
                  <span class="input__box">
                      <input class="input__control" placeholder="Логин" name="login" value="" />
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </span>
                </span>
            </div>
            <div class="form-group has-feedback<?= (isset($errors['password'])) ? ' has-error': ''?>">
                <span class="input input_has-clear input_width_full">
                  <span class="input__box">
                      <input class="input__control" placeholder="Пароль" type="password" name="password" value="" />
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </span>
                </span>
            </div>
            <div class="row">
                <div class="col-xs-offset-8 col-xs-4">
                    <button type="submit" name="submit" class="button button_form">Войти</button>
                </div><!-- /.col -->
            </div>
        </form>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- iCheck -->
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/icheck.min.js"></script>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/jquery-2.2.1.min.js"></script>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/nmg-bem.js"></script>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/index.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
