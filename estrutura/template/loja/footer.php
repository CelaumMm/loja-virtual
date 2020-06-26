<?php

use App\Core\Template; ?>

    <!-- footer start (Add "dark" class to #footer in order to enable dark footer) -->
    <!-- ================ -->
    <footer id="footer" class="clearfix dark">

    <!-- .footer start -->
    <!-- ================ -->
    <div class="footer">
        <div class="container">
        <div class="footer-inner">
            <div class="row">
            <div class="col-lg-6">
                <div class="footer-content">
                <div class="logo-footer"><img id="logo-footer" src="<?= Template::templateUrl() . 'images/logo_light_blue.png'; ?>" alt=""></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus illo vel dolorum soluta consectetur doloribus sit. Delectus non tenetur odit dicta vitae debitis suscipit doloribus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed dolore fugit vitae quia dicta inventore reiciendis. Ipsa, aut voluptas quaerat.</p>
                <ul class="list-inline mb-20">
                    <li class="list-inline-item"><i class="text-default fa fa-map-marker pr-1"></i> Street Address No, City</li>
                    <li class="list-inline-item"><i class="text-default fa fa-phone pl-10 pr-1"></i> +00 1234567890</li>
                    <li class="list-inline-item"><a href="#" class="link-dark"><i class="text-default fa fa-envelope-o pl-10 pr-1"></i> example@your_domain.com</a></li>
                </ul>
                <div class="separator-2"></div>
                <ul class="social-links circle margin-clear animated-effect-1">
                    <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li class="googleplus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li class="xing"><a href="#"><i class="fa fa-xing"></i></a></li>
                    <li class="skype"><a href="#"><i class="fa fa-skype"></i></a></li>
                    <li class="youtube"><a href="#"><i class="fa fa-youtube"></i></a></li>
                    <li class="dribbble"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                    <li class="flickr"><a href="#"><i class="fa fa-flickr"></i></a></li>
                    <li class="instagram"><a href="#"><i class="fa fa-instagram"></i></a></li>
                </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer-content">
                <h2 class="title">Contact Us</h2>
                <form class="margin-clear">
                    <div class="form-group has-feedback mb-10">
                    <label class="sr-only" for="name2">Name</label>
                    <input type="text" class="form-control" id="name2" placeholder="Name" required>
                    <i class="fa fa-user form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback mb-10">
                    <label class="sr-only" for="email2">Email address</label>
                    <input type="email" class="form-control" id="email2" placeholder="Enter email" required>
                    <i class="fa fa-envelope form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback mb-10">
                    <label class="sr-only" for="message2">Message</label>
                    <textarea class="form-control" rows="4" id="message2" placeholder="Message" required></textarea>
                    <i class="fa fa-pencil form-control-feedback"></i>
                    </div>
                    <input type="submit" value="Send" class="margin-clear submit-button btn btn-default">
                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- .footer end -->

    <!-- .subfooter start -->
    <!-- ================ -->
    <div class="subfooter">
        <div class="container">
        <div class="subfooter-inner">
            <div class="row">
            <div class="col-md-12">
                <p class="text-center">Copyright © 2019. All rights reserved.</p>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- .subfooter end -->

    </footer>
    <!-- footer end -->
</div>
<!-- page-wrapper end -->

<?php if(isAdminMaster()): ?>
<div class="style-switcher">
    <a class="trigger" href="javascript:void" onclick="location.href = '<?= Template::url() . env('PROJETO_ADMIN'); ?>'" title="Admin">
        <i class="fa fa-cog"></i>
    </a>
</div>
<?php endif; ?>

</body>
</html>