<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>IRAMADIBATU - Login</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=site_url('assets/css/login.css')?>">
    <style>
    .login-loading {
        display: inline-block;
        width: 40px;
        height: 40px;
    }
    .login-loading:after {
        content: " ";
        display: block;
        width: 32px;
        height: 32px;
        margin: 4px;
        border-radius: 50%;
        border: 3px solid #fff;
        border-color: #3385ff transparent #fff transparent;
        animation: login-loading 1.2s linear infinite;
    }
    @keyframes login-loading {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    </style>
    <!-- JS Header Constants -->
    <script src="<?=site_url('assets/js/constants.js')?>"></script>
    <!-- JS Header Global Helper -->
    <script src="<?=site_url('assets/js/global_helpers.js')?>"></script>
    <script>
    const accessToken = localStorage.getItem(ACCESS_TOKEN_KEY);
    if (accessToken && !isTokenExpired(accessToken)) {
        window.location.href = '<?=site_url('/dashboard')?>';
    } else {
        localStorage.removeItem(ACCESS_TOKEN_KEY);
        localStorage.removeItem(REFRESH_TOKEN_KEY);
    }
    </script>
</head>
<body>
    <section id="login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="container">
                        <div class="d-flex flex-row mb-5 mt-5">
                            <img class="img-fluid mr-3" src="<?=site_url('assets/images/logo3.png')?>" alt="Logo">
                            <h3 class="align-self-center">
                                IRAMADIBATU 
                                <br />
                                <span>Inventarisasi Sarana Keamanan Digital Terpadu</span>
                            </h3>
                        </div>
                        <h3>Selamat Datang!</h3>
                        <p style="color:#ddd;" class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad unde nesciunt vitae, excepturi nihil voluptate libero neque cum, beatae suscipit quisquam, tempore in? Sit quis ea maxime molestias nihil ad?voluptatem dolorem facere voluptas nemo. Corporis!</p>
                    </div>
                </div>
                <div class="col-md-4 p-0 d-flex align-items-center">
                    <div id="tile-pattern"></div>
                    <div class="form-wrapper w-100 px-4">
                        <div class="text-center">
                            <img class="mb-5" src="<?=site_url('assets/images/logo3.png')?>" alt="Logo" width="50%" height="50%">
                            <h3>IRAMADIBATU</h3>
                            <p class="lead mb-5 text-muted">Inventarisasi Sarana Keamanan Digital Terpadu</p>
                        </div>

                        <form id="form-login">
                            <div class="form-group">
                                <input name="username" type="text" class="form-control" id="username" required>
                                <label class="animating" for="username">Username</label>
                            </div>
                            <div class="form-group">
                                <input name="password" type="password" class="form-control" id="password" required>
                                <label class="animating" for="password">Password</label>
                            </div>
                            <div class="text-center">
                                <div class="login-loading"></div>
                            </div>
                            <p class="text-login-msg text-center"></p>
                            <div class="d-flex flex-row">
                                <button type="submit" class="btn btn-primary btn-login text-uppercase px-4 mr-4">
                                    Login <i class="fa fa-send ml-3"></i>
                                </button>
                                <div class="custom-control custom-checkbox align-self-center">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
    <!-- <script src="<?=site_url('assets/js/login.js')?>"></script> -->

    <!-- jQuery -->
    <script src="<?=site_url('themes/AdminLTE/plugins/jquery/jquery.min.js')?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?=site_url('themes/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <!-- jquery-validation -->
    <script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
    <script src="<?=site_url('themes/AdminLTE/plugins/jquery-validation/additional-methods.min.js')?>"></script>

    <script>
    $(function(){
        $('.text-login-msg').hide();
        $('.login-loading').hide();

        $('#form-login').validate({
            submitHandler: function(form, event) {
                event.preventDefault();

                $('.login-loading').show();

                const loginData = $(form).serialize();
                const loginUrl = '<?=site_url('/api/login')?>';
                
                setTimeout(() => {
                    $.ajax({
                        type: 'POST',
                        url: loginUrl,
                        dataType: 'json',
                        data: loginData,
                        success: function(res) {
                            $('.login-loading').hide();
                            const resAccessToken = res.data.access_token;
                            const resRefreshToken = res.data.refresh_token;

                            localStorage.setItem(ACCESS_TOKEN_KEY, resAccessToken);
                            localStorage.setItem(REFRESH_TOKEN_KEY, resRefreshToken);
                            
                            $('.text-login-msg').text('');
                            $('.text-login-msg').show();
                            $('.text-login-msg').removeClass('text-danger');
                            $('.text-login-msg').addClass('text-success');
                            $('.text-login-msg').text(res.message);
                            
                            setTimeout(() => {
                                $('.text-login-msg').text('redirecting...');

                                setTimeout(() => {
                                    $('.text-login-msg').hide();
                                    window.location.href = '<?=site_url('/dashboard')?>';
                                }, 1000);
                            }, 1000);
                        },
                        error: function(err) {
                            console.log(err.responseJSON);
                            $('.login-loading').hide();

                            $('.text-login-msg').text('');
                            $('.text-login-msg').show();
                            $('.text-login-msg').removeClass('text-success');
                            $('.text-login-msg').addClass('text-danger');
                            $('.text-login-msg').text(err.responseJSON.messages.error);
                        }
                    });
                }, 1000);
            },
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                username: {
                    required: 'Username tidak boleh kosong!'
                },
                password: {
                    required: 'Password tidak boleh kosong!'
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    </script>
</body>
</html>