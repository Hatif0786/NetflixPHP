<?php
require "backend/init.php";

if(isset($_SESSION['userLoggedIn'])){
    redirect_to(url_for('home'));
} else if(Login::isLoggedIn()){
    $user_id=Login::isLoggedIn();
    $loadFromUser->userData($user_id);
    $status=$loadFromUser->get("token",["status"],['user_id'=>$user_id]);
    if($status['status']==1){
        redirect_to(url_for("home"));
    }
    else{
       redirect_to(url_for('verification'));
    }
}


if(isset($_SESSION['email'])){
    $email=$_SESSION['email'];
    if(is_post_request()){
        if(isset($_POST['submitButton'])){
           $firstName=FormSanitizer::sanitizeFormName($_POST['firstName']);
           $lastName=FormSanitizer::sanitizeFormName($_POST['lastName']);
           $email=FormSanitizer::sanitizeFormEmail($_POST['email']);
           $pwd=FormSanitizer::sanitizeFormPassword($_POST['pwd']);
           $wasSuccessful=$account->register($firstName, $lastName, $email, $pwd);
           if($wasSuccessful){
                session_regenerate_id();
                $_SESSION['userLoggedIn']=$wasSuccessful;
                if(isset($_POST['remember'])){
                    $tstrong=true;
                    $token=bin2hex(openssl_random_pseudo_bytes(64, $tstrong));
                    $loadFromUser->create("token", ["user_id"=>$wasSuccessful,'token'=>sha1($token)]);
                    setcookie("FBID", $token, time()+3600*24*7, "/", NULL, NULL, true);
                }
                redirect_to(url_for('verification'));
            }
        }
    }
}else{
    redirect_to(url_for('index'));
} 
$pageTitle="Netflix || Registration"; ?>
<?php require "backend/shared/header.php"; ?>
        <header class="site-header signUpBasicHeader">
            <a href="index" class="brand-container" title="netflix">
               <svg  class="site-logo" viewBox="0 0 111 30"  focusable="false"><g><path d="M105.06233,14.2806261 L110.999156,30 C109.249227,29.7497422 107.500234,29.4366857 105.718437,29.1554972 L102.374168,20.4686475 L98.9371075,28.4375293 C97.2499766,28.1563408 95.5928391,28.061674 93.9057081,27.8432843 L99.9372012,14.0931671 L94.4680851,-5.68434189e-14 L99.5313525,-5.68434189e-14 L102.593495,7.87421502 L105.874965,-5.68434189e-14 L110.999156,-5.68434189e-14 L105.06233,14.2806261 Z M90.4686475,-5.68434189e-14 L85.8749649,-5.68434189e-14 L85.8749649,27.2499766 C87.3746368,27.3437061 88.9371075,27.4055675 90.4686475,27.5930265 L90.4686475,-5.68434189e-14 Z M81.9055207,26.93692 C77.7186241,26.6557316 73.5307901,26.4064111 69.250164,26.3117443 L69.250164,-5.68434189e-14 L73.9366389,-5.68434189e-14 L73.9366389,21.8745899 C76.6248008,21.9373887 79.3120255,22.1557784 81.9055207,22.2804387 L81.9055207,26.93692 Z M64.2496954,10.6561065 L64.2496954,15.3435186 L57.8442216,15.3435186 L57.8442216,25.9996251 L53.2186709,25.9996251 L53.2186709,-5.68434189e-14 L66.3436123,-5.68434189e-14 L66.3436123,4.68741213 L57.8442216,4.68741213 L57.8442216,10.6561065 L64.2496954,10.6561065 Z M45.3435186,4.68741213 L45.3435186,26.2498828 C43.7810479,26.2498828 42.1876465,26.2498828 40.6561065,26.3117443 L40.6561065,4.68741213 L35.8121661,4.68741213 L35.8121661,-5.68434189e-14 L50.2183897,-5.68434189e-14 L50.2183897,4.68741213 L45.3435186,4.68741213 Z M30.749836,15.5928391 C28.687787,15.5928391 26.2498828,15.5928391 24.4999531,15.6875059 L24.4999531,22.6562939 C27.2499766,22.4678976 30,22.2495079 32.7809542,22.1557784 L32.7809542,26.6557316 L19.812541,27.6876933 L19.812541,-5.68434189e-14 L32.7809542,-5.68434189e-14 L32.7809542,4.68741213 L24.4999531,4.68741213 L24.4999531,10.9991564 C26.3126816,10.9991564 29.0936358,10.9054269 30.749836,10.9054269 L30.749836,15.5928391 Z M4.78114163,12.9684132 L4.78114163,29.3429562 C3.09401069,29.5313525 1.59340144,29.7497422 0,30 L0,-5.68434189e-14 L4.4690224,-5.68434189e-14 L10.562377,17.0315868 L10.562377,-5.68434189e-14 L15.2497891,-5.68434189e-14 L15.2497891,28.061674 C13.5935889,28.3437998 11.906458,28.4375293 10.1246602,28.6868498 L4.78114163,12.9684132 Z" fill="#e50914"></path></g></svg> 
               <span class="screen-reader-text">Netflix</span>
            </a>
            <a href="login" class="signInLink">Sign In</a>
        </header>
    <section class="simpleContainer">
        <div class="centerContainer">
            <form action="<?php echo h($_SERVER['PHP_SELF']);?>" method="POST">
                <div class="regFormContainer">
                    <div class="stepHeader-container">
                        <h1 class="stepTitle">Create account to start watching Netflix</h1>
                    </div>
                    <div class="stepHeader-body">
                    <?php echo $account->getErrorMessage(Constant::$firstNameCharacters) ?>
                        <div class="group">
                            <label for="fname">First Name</label>
                            <input type="text" name="firstName" value="<?php echo getInputValue('firstName')?>" id="fname" autocomplete="off" required>
                        </div>
                        <?php echo $account->getErrorMessage(Constant::$lastNameCharacters) ?>
                        <div class="group">
                            <label for="lname">Last Name</label>
                            <input type="text" name="lastName" id="lname" value='<?php echo getInputValue('lastName')?>' autocomplete="off" required>
                        </div>
                        <?php echo $account->getErrorMessage(Constant::$emailInvalid) ?>
                        <div class="group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo $email;?>" autocomplete="off" required>
                        </div>
                        <?php echo $account->getErrorMessage(Constant::$passwordLength); ?>
                        <div class="group">
                            <label for="pwd">Password</label>
                            <input type="password" name="pwd" id="pwd" autocomplete="off" required>
                        </div>
                        <div class="group r-me" id="re">
                            <div>
                                <input type="checkbox" id="showPassword" class="remember">
                                <label for="showPassword" id="show_password_hide">Show Password</label>
                            </div>
                            <div>
                                <input type="checkbox" name="remember" id="remember" required class="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                    </div>
                    <div class="submitBtnContainer">
                        <button type="submit" name="submitButton">Register</button>
                    </div>
                </div>
            </form>
        </div>
       
    </section>
    <script src="frontend/assets/js/showPassword.js"></script>
</body>
</html>