<?php

use App\Core\Template;
?>

<aside class="col col-lg order-lg-1"><!-- sidebar start -->
    <div class="sidebar">
        <div class="block clearfix">
            <h3 class="title">Menu admin</h3>
            <div class="separator-2"></div>
            <nav>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?= Template::url() . PROJETO; ?>"><i class="fa fa-bar-chart pr-2" aria-hidden="true"></i>Admin</a></li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?= Template::url() . PROJETO . '/usuarios'; ?>"><i class="fa fa-users pr-2" aria-hidden="true"></i>Lista de usuários</a></li>
                </ul>
            </nav>
        </div>
    </div>
</aside><!-- sidebar end -->