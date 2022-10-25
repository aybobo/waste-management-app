<!DOCTYPE html>
<!-- 
Template Name: Brunette - Responsive Bootstrap 4 Admin Dashboard Template
Author: Hencework
Contact: https://hencework.ticksy.com/

License: You must have a valid license purchased only from templatemonster to legally use the template for your project.
-->
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Waste Management Application</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url()?>favicon.ico">
    <link rel="icon" href="<?=base_url()?>favicon.ico" type="image/x-icon">
    
    <!-- vector map CSS -->
    <link href="<?=base_url()?>vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />

    <!-- Toggles CSS -->
    <link href="<?=base_url()?>vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    
    <!-- Toastr CSS -->
    <link href="<?=base_url()?>vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="<?=base_url()?>dist/css/style.css" rel="stylesheet" type="text/css">
    <!-- custom css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="login-header">Waste Management Application</h4>
            </div>
            <!-- -->
        </div>
        <div class="home-msg">
            <?php if($msg = $this->session->flashdata('msg')) {
                    echo '<div class="text-danger">' . $msg . '</div>';  } ?>
                <?php if($msg = $this->session->flashdata('success')) {
                    echo '<div class="text-success">' . $msg . '</div>';  } ?>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="card card-container">
                    <h4 class="ctr-msg">Login</h4>
                    <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
                    <img class="profile-img-card" src="<?=base_url()?>assets/images/logo.png" />
                    <p id="profile-name" class="profile-name-card"></p>
                    <!--<form class="form-signin">-->
                     <?php echo form_open('Admin/login', ['class' => 'form-signin']); ?>
                        <!--<span id="reauth-email" class="reauth-email"></span>-->
                        <input type="email" name="email" class="form-control" placeholder="Email address">
                        <input type="password" name="pwd" class="form-control" placeholder="Password">
                        
                        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
                     <?php echo form_close(); ?>
                    <!--</form>/form -->
                    <a href="<?=site_url('admin/forgotpassword')?>" class="forgot-password">
                        Forgot the password?
                    </a>
                </div><!-- /card-container -->
                <!-- -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                 <div class="text-white space-left">
                     <p>&copy; <?=date ('Y')?> <a href="https://opendoorlimited.com/" target="_blank">Open Door System International Limited</a></p>
                 </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                 <div class="text-white space-left mt-4">
                     <p>Developed By <a href="mailto:insightconceptltd@gmail.com" target="_blank">Insight Concept Nig. Ltd.</a></p>
                 </div>
            </div>
        </div>
    </div><!-- /container -->

    <!-- jQuery -->
    <script src="<?=base_url()?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url()?>vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?=base_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Slimscroll JavaScript -->
    <script src="<?=base_url()?>dist/js/jquery.slimscroll.js"></script>

    <!-- Fancy Dropdown JS -->
    <script src="<?=base_url()?>dist/js/dropdown-bootstrap-extended.js"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="<?=base_url()?>dist/js/feather.min.js"></script>

    <!-- Toggles JavaScript -->
    <script src="<?=base_url()?>vendors/jquery-toggles/toggles.min.js"></script>
    <script src="<?=base_url()?>dist/js/toggle-data.js"></script>
    
    <!-- Counter Animation JavaScript -->
    <script src="<?=base_url()?>vendors/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?=base_url()?>vendors/jquery.counterup/jquery.counterup.min.js"></script>
    
    <!-- EChartJS JavaScript -->
    <script src="<?=base_url()?>vendors/echarts/dist/echarts-en.min.js"></script>
    
    <!-- Sparkline JavaScript -->
    <script src="<?=base_url()?>vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    
    <!-- Vector Maps JavaScript -->
    <script src="<?=base_url()?>vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="<?=base_url()?>vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?=base_url()?>dist/js/vectormap-data.js"></script>

    <!-- Owl JavaScript -->
    <script src="<?=base_url()?>vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    
    <!-- Toastr JS -->
    <!--<script src="<?=base_url()?>vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>-->
    
    <!-- Init JavaScript -->
    <script src="<?=base_url()?>dist/js/init.js"></script>
    <script src="<?=base_url()?>dist/js/dashboard-data.js"></script>
<script>
    $( document ).ready(function() {
    // DOM ready

    // Test data
    /*
     * To test the script you should discomment the function
     * testLocalStorageData and refresh the page. The function
     * will load some test data and the loadProfile
     * will do the changes in the UI
     */
    // testLocalStorageData();
    // Load profile if it exits
    loadProfile();
});

/**
 * Function that gets the data of the profile in case
 * thar it has already saved in localstorage. Only the
 * UI will be update in case that all data is available
 *
 * A not existing key in localstorage return null
 *
 */
function getLocalProfile(callback){
    var profileImgSrc      = localStorage.getItem("PROFILE_IMG_SRC");
    var profileName        = localStorage.getItem("PROFILE_NAME");
    var profileReAuthEmail = localStorage.getItem("PROFILE_REAUTH_EMAIL");

    if(profileName !== null
            && profileReAuthEmail !== null
            && profileImgSrc !== null) {
        callback(profileImgSrc, profileName, profileReAuthEmail);
    }
}

/**
 * Main function that load the profile if exists
 * in localstorage
 */
function loadProfile() {
    if(!supportsHTML5Storage()) { return false; }
    // we have to provide to the callback the basic
    // information to set the profile
    getLocalProfile(function(profileImgSrc, profileName, profileReAuthEmail) {
        //changes in the UI
        $("#profile-img").attr("src",profileImgSrc);
        $("#profile-name").html(profileName);
        $("#reauth-email").html(profileReAuthEmail);
        $("#inputEmail").hide();
        $("#remember").hide();
    });
}

/**
 * function that checks if the browser supports HTML5
 * local storage
 *
 * @returns {boolean}
 */
function supportsHTML5Storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}

/**
 * Test data. This data will be safe by the web app
 * in the first successful login of a auth user.
 * To Test the scripts, delete the localstorage data
 * and comment this call.
 *
 * @returns {boolean}
 */
function testLocalStorageData() {
    if(!supportsHTML5Storage()) { return false; }
    localStorage.setItem("PROFILE_IMG_SRC", "//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" );
    localStorage.setItem("PROFILE_NAME", "César Izquierdo Tello");
    localStorage.setItem("PROFILE_REAUTH_EMAIL", "oneaccount@gmail.com");
}
</script>
</body>
</html>