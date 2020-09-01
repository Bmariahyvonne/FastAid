
<?php 
    include('functions.php');
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex" href="{{ url('/') }}">
            <div class="pr-3"><img src="images/myapp.svg" style="max-height: 60px"></div>
            <div style="font-size: xx-large">FastAid</div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
           
               
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="position: relative; padding-left: 50px">
                        <img src="images/user_profile.png" style="width: 32px; height: 32px; position: absolute; top: 10px; left: 10px; border-radius: 50%">
                        <strong><?php echo $_SESSION['user']['username']; ?></strong><span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
               <ul>
                   <li><a href="profile.php"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                   <li><a href="index.php"><i class="fa fa-btn fa-user"></i>Logout</a></li>


                </li>
               </ul>
                    </div>
          
        </ul>
    </div>
</nav>
<div class="container">
    <div class="title m-b-md" style="margin-bottom: 5px; text-align: center; font-size: 50px;">
        <strong>WELCOME</strong>
    </div>
        <div class="col-3 d-block" style="width: 60%; font-size: 30px; float: left; margin-top: 20px">
            <div>
                <form action='/' method='get'>
                    <a>Copy and paste the number below to call an ambulance</a>
                    <input type='tel' name='tel' />
                    <input type='submit' onclick='call();return false;' value='Call' />
                </form>
                <script>
                    function call() {
                    var number = document.querySelector("input[name=tel]").value;
                    window.open('tel:' + number);
                    }
                </script>

                0778273647</a>
            </div>
            <div><img src="images/amb.gif" style="width: 450px; height: 350px; margin-right: 5px;"></div>

        </div>
        <div class="col-3" style="width: 40%; float: right; font-size: 15px; margin-top: 20px">
            <form method="POST" name=" myemailform" action="MAILTO:mariahyvonnebyamugisha@gmail.com">
            <div id="Feeling" class="dropdown-checklist" tabindex="100"></div>
            <span class="anchor">How are you feeling?</span>
            <ul class="Feeling">
                <li><input type ="checkbox" name="Feeling"/>Headache</li>
                <li><input type ="checkbox" name="Feeling"/>Stomachache</li>
                <li><input type ="checkbox" name="Feeling"/>Dizziness</li>
            </ul>

            <div id="doctor" class="dropdown-checklist" tabindex="100"></div>
            <span class="anchor">What doctor do you want to see? <span/>
                <ul class="doctor">
                <li><input type ="checkbox" name="doctor"/>Physician</li>
                    <li><input type ="checkbox" name="doctor"/>Dentist</li>
                    <li><input type ="checkbox" name="doctor"/>Gynaecologist</li>
                </ul>

                <div id="HIVTest" class="dropdown-radio" tabindex="100"></div>
                <span class="anchor">Do you need to test for HIV: </span>
                <ul>
                <li><input type="radio" name="HIVTest"/>YES</li>
                    <li><input type="radio" name="HIVTest"/>NO</li>
                </ul>

                Anything else we need to know: <br/>
                <textarea rows="5" cols="20" name="MoreDetails"></textarea><br/>

                <input type="submit" value="submit"/>
            </span>
            </form>
        </div>
    </div>
</body>
</html>

