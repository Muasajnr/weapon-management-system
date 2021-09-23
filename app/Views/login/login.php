<?=$this->extend('layouts/auth_layout')?>
<?=$this->section('custom-style')?>
<style>
.lds-dual-ring {
    display: inline-block;
    width: 40px;
    height: 40px;
}
.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 32px;
    height: 32px;
    margin: 4px;
    border-radius: 50%;
    border: 3px solid #fff;
    border-color: #3385ff transparent #fff transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
<?=$this->endSection()?>
<?=$this->section('content') ?>
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?=site_url()?>" class="h1"><b>Inventory</b><br>Senjata Api</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form id="form-login">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div style="display:none;" class="lds-dual-ring"></div>
                </div>
                <p class="text-login-msg text-center"></p>
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
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
<?= $this->endSection() ?>

<?=$this->section('custom-js')?>
<script>
$(function() {
    $('.text-login-error').hide();
    $('.lds-dual-ring').hide();

    $('#form-login').on('submit', function(e) {
        e.preventDefault();

        $('.lds-dual-ring').show();

        const loginData = $(this).serialize();
        const loginUrl = '<?=site_url('/api/login')?>';

        setTimeout(() => {
            $.ajax({
                type: 'POST',
                url: loginUrl,
                dataType: 'json',
                data: loginData,
                success: function(res) {
                    $('.lds-dual-ring').hide();
                    const authToken = res.data.token;
                    localStorage.setItem('auth_token', authToken);
                    
                    $('.text-login-msg').show();
                    $('.text-login-msg').removeClass('text-danger');
                    $('.text-login-msg').addClass('text-success');
                    $('.text-login-msg').text(res.data.message);
                    
                    setTimeout(() => {
                        $('.text-login-msg').text('redirecting...');

                        setTimeout(() => {
                            $('.text-login-msg').hide();
                            window.location.href = '<?=site_url('/dashboard')?>';
                        }, 1000);
                    }, 500);
                },
                error: function(err) {
                    console.log(err.responseJSON);
                    $('.lds-dual-ring').hide();
                    $('.text-login-msg').show();
                    $('.text-login-msg').removeClass('text-success');
                    $('.text-login-msg').addClass('text-danger');
                    $('.text-login-msg').text(err.responseJSON.messages.error);
                }
            });
        }, 2000);
    });
});
</script>
<?=$this->endSection()?>