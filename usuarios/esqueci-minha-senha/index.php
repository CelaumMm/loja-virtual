<?php
require_once '../app.php';

use App\Core\Template;

Template::getNavegacao([
    [
        'nome' => 'Home',
        'url' => Template::url(),
        'icon' => 'fa fa-home pr-1'
    ],
    [
        'nome' => 'Usuários',
        'url' => '',
        'icon' => 'fa fa-users pr-1'
    ],
    [
        'nome' => 'Esqueci minha senha',
        'url' => Template::url() . PROJETO . DS . 'esqueci-minha-senha',
        'icon' => 'fa fa-key pr-1'
    ]
]);

?>

<!-- main-container start -->
<!-- ================ -->
<div class="main-container dark-translucent-bg" style="background-image:url('<?= Template::templateUrl() . 'images/background-img-6.jpg'; ?>');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto">
                <!-- main start -->
                <!-- ================ -->
                <div class="main object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="100">
                    <div class="form-block p-30 light-gray-bg border-clear">
                        <h2 class="title d-flex justify-content-center">Esqueci minha senha</h2>
                        <form class="form-horizontal" method="POST" action="./post.php">
                            <div class="form-group has-feedback row">
                                <label for="email" class="col-md-3 control-label text-md-right col-form-label">Email <span class="text-danger small">*</span></label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" id="email" value="<?= getPost('email'); ?>" required>
                                    <i class="fa fa-envelope form-control-feedback pr-4"></i>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-group btn-default btn-animated">Recuperar <i class="fa fa-check"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- main end -->
            </div>
        </div>
    </div>
</div>
<!-- main-container end -->

<?php Template::getFooter(); ?>
