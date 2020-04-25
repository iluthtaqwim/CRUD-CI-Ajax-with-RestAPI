<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js">
    </script>

    <title>AdminLTE 3 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url('assets/dist/css/adminlte.min.css') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo site_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo site_url('assets/dist/js/adminlte.min.js') ?>"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Admin</b>Sekolah</a>
        </div>
        <p id="infolog"></p>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="" id="login" method="post">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" name="nis" id="nis" aria-describedby="helpId" placeholder="NIS">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <span id="error_nis" class="form-text text-muted"></span>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span id="error_password" class="form-text text-muted"></span>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="masuk" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</body>



<script>
    $(document).ready(function() {

        $('#login').on('submit', function(event) {
            event.preventDefault();
            var error_nis = '';
            var error_pass = ''

            if ($('#nis').val() == '') {
                error_nis = "NIS tidak boleh kosong";
                $('#error_nis').text(error_nis);
                $('#nis').css('border-color', '#cc0000');
            } else {
                error_nis = '';
                $('#error_nis').text(error_nis);
                $('#nis').css('border-color', '');
            }

            if ($('#password').val() == '') {
                err_pass = 'Password tidak boleh kosong';
                $('#error_password').text(err_pass);
                $('#password').css('border-color', '#cc0000');
            } else {
                err_pass = '';
                $('#error_password').text(err_pass);
                $('#password').css('border-color', '');
            }

            if (error_nis == '' && error_pass == '') {
                var input_nis = $('[name="nis"]').val();
                var input_pass = $('[name="password"]').val();

                $.ajax({
                    url: '<?php echo base_url('index.php/auth/login') ?>',
                    type: "post",
                    dataType: "JSON",
                    data: {
                        nis: input_nis,
                        password: input_pass
                    },
                    success: function(data) {
                        if (data.status == true) {
                            window.location.assign(data.lokasi);
                        } else {
                            $("#infolog").html(data.msg);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('controller Error');
                    }
                });


            } else {
                console.log('ada yang salah');
            }

        });


    })
</script>

</html>