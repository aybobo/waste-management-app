

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->
   
    <!-- HK Wrapper -->
    <div class="hk-wrapper">

        <!-- Main Content -->
        <div class="hk-pg-wrapper hk-auth-wrapper">
            <header class="d-flex justify-content-between align-items-center">
                <a class="d-flex auth-brand" href="#">
                    <img class="brand-img" src="<?=base_url()?>dist/img/logo-dark1a.png" alt="brand" />
                </a>
                <!--<div class="btn-group btn-group-sm">
                    <a href="#" class="btn btn-outline-secondary">Help</a>
                    <a href="#" class="btn btn-outline-secondary">About Us</a>
                </div>-->
            </header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-5 pa-0">
                        <div id="owl_demo_1" class="owl-carousel dots-on-item owl-theme">
                            <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url(<?=base_url()?>dist/img/bg2.jpg);">
                                <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                    <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                        <h1 class="display-3 text-white mb-20">Open Door System International</h1>
                                        <!--<p class="text-white">The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. Again during the 90s as desktop publishers bundled the text with their software.</p>-->
                                    </div>
                                </div>
                                <div class="bg-overlay bg-trans-dark-50"></div>
                            </div>
                            <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url(<?=base_url()?>dist/img/bg2.jpg);">
                                <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                    <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                        <h1 class="display-3 text-white mb-20">Open Door System International</h1>
                                        <!--<p class="text-white">The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software.</p>-->
                                    </div>
                                </div>
                                <div class="bg-overlay bg-trans-dark-50"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 pa-0">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="home-msg">
                                    <?php if($msg = $this->session->flashdata('msg')) {
                                            echo '<div class="text-danger">' . $msg . '</div>';  } ?>
                                        <?php if($msg = $this->session->flashdata('success')) {
                                            echo '<div class="text-success">' . $msg . '</div>';  } ?>
                                </div>
                            </div>
                        </div>
                        <div class="auth-form-wrap py-xl-0 py-50">
                            <div class="auth-form w-xxl-55 w-xl-75 w-sm-90 w-xs-100">
                                <img class="profile-img-card" src="<?=base_url()?>assets/images/logo.png" />
                                <?php echo form_open('admin/sendpwdresetlink', ['class' => 'form-signin']); ?>
                                    <!--<h1 class="display-4 mb-10">Welcome Back :)</h1>
                                    <p class="mb-30">Sign in to your account and enjoy unlimited perks.</p>-->
                                    <!--<div class="form-group">
                                        <input class="form-control" name="email" placeholder="Email" type="email">
                                    </div>-->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control" placeholder="Email address">
                                            <!--<div class="input-group-append">
                                                <span class="input-group-text"><span class="feather-icon"><i data-feather="eye-off"></i></span></span>
                                            </div>-->
                                        </div>
                                    </div>
                                    <!--<div class="custom-control custom-checkbox mb-25">
                                        <input class="custom-control-input" id="same-address" type="checkbox" checked>
                                        <label class="custom-control-label font-14" for="same-address">Keep me logged in</label>
                                    </div>-->
                                    <button class="btn btn-success btn-block" type="submit">Send Password Link</button>
                                    <p class="font-14 text-center mt-15"><a href="<?=site_url('admin/index')?>" class="forgot-password">
                        Login
                    </a></p>
                                    <!--<div class="option-sep">Or</div>-->
                                    <div class="form-row">
                                        <div class="col-sm-6 mb-30">
                                            <!--<button class="btn btn-indigo btn-block btn-wth-icon"> <span class="icon-label"><i class="fa fa-facebook"></i> </span><span class="btn-text">Login with facebook</span></button>-->
                                        </div>
                                        <div class="col-sm-6 mb-30">
                                            <!--<button class="btn btn-sky btn-block btn-wth-icon"> <span class="icon-label"><i class="fa fa-twitter"></i> </span><span class="btn-text">Login with Twitter</span></button>-->
                                        </div>
                                    </div>
                                    
                                <?php echo form_close(); ?>
                                <!--<p class="text-center mb-30">Do have an account yet? <a href="#">Sign Up</a></p>-->
                                <p class="text-center mb-30">&copy; <?=date ('Y')?> <a href="https://opendoorlimited.com/" target="_blank">Open Door System International Limited</a></p>
                                <p class="text-center mb-30">Developed By <a href="mailto:insightconceptltd@gmail.com" target="_blank">Insight Concept Nig. Ltd.</a></p>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /HK Wrapper -->

