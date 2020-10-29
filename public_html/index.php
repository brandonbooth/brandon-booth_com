<?php
require_once('../private/dbconnect.php');

session_start();

$_SESSION['message'] = '';

if (!isset($_SESSION['signed_in'])){
  // echo 'is not set' .date("Y-m-d H:i:s");
  $_SESSION['signed_in'] = "Not yet - ".date("Y-m-d H:i:s");
}

if(array_key_exists('login', $_POST)) { 
  $email = $mysqli_accounts->real_escape_string($_POST['email']);
  $username = $mysqli_accounts->real_escape_string($_POST['username']);
  $password = $mysqli_accounts->real_escape_string($_POST['password']);
  $sql = "SELECT password FROM users WHERE username='$username'";
  $results = $mysqli_accounts->query($sql);

  if ($results->num_rows > 0) {
      while($row = $results->fetch_assoc()) {
        $stored_password = $row["password"];
      }
  } else {
      echo "No results!";
  }

  $row = mysqli_fetch_row($results);  
  $row = $results->fetch_assoc();
  
  $_SESSION['signed_in'] = "noo";

  if (password_verify($password, $stored_password)) {
    $_SESSION['message'] = "Hi $username!";
    $_SESSION['error_message'] = "";
    $_SESSION['username'] = $username;
    $_SESSION['signed_in'] = "yes" ;
    header("location: inputform.php");
  }
  else {            
    $_SESSION['message'] = "";
    $_SESSION['error_message'] = "Login was not successful!";
    $_SESSION['signed_in'] = "no";
  }
}
?>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-176327266-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-176327266-1');
  </script>


  <title>Brandon Booth | Industrial Engineer, Developer & Creator</title>
  <meta charset="utf-8">
  <meta name="description" content="Brandon Booth - Industrial Engineer, San Francisco, California">
  <meta name="keywords" content="Brandon Booth,Industrial Engineer,San Francisco California">
  <meta name="author" content="Brandon Booth">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Open Graph protocol - used for social media -->
  <meta property="og:title" content="Brandon Booth's Portfolio" />
  <meta property="og:description" content="Personal webpage of Brandon D Booth, San Francisco, California." />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://brandon-booth.com" />
  <meta property="og:image" content="https://brandon-booth.com/img/andina_small.jpg" />

  <!-- icon -->
  <link rel="icon" href="/img/V8_BB_white.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/V8_BB_white.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/V8_BB_white.png">

  <link rel="apple-touch-icon" href="/img/V8_BB_white.png">

  <meta name="apple-mobile-web-app-title" content="BB Splash">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <!-- <meta name="apple-mobile-web-app-status-bar-style" content="black"> -->
  <!-- <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"> -->

  <!-- iPhone Xs Max (1242px x 2688px) -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)"
    href="/img/bb_splash_1242x2688.png">
  <!-- iPhone Xr (828px x 1792px) -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)"
    href="/img/bb_splash_828x1792.png">
  <!-- iPhone X, Xs (1125px x 2436px) -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)"
    href="/img/bb_splash_1125x2436.jpg">
  <!-- iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus (1242px x 2208px) -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)"
    href="/img/bb_splash_1242x2208.png">
  <!-- iPhone 8, 7, 6s, 6 (750px x 1334px) -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)"
    href="/img/bb_splash_750x1334.png">
  <!-- iPad Pro 12.9" (2048px x 2732px) -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
    href="/img/bb_splash_2048x2732.png">
  <!-- iPad Pro 11” (1668px x 2388px) -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
    href="/img/bb_splash_1668x2388.png">
  <link rel="apple-touch-startup-image"
    media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
    href="/img/bb_splash_1668x2224.png">
  <!-- iPad Mini, Air (1536px x 2048px) -->
  <link rel="apple-touch-startup-image"
    media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
    href="/img/bb_splash_1536x2048.png">

  <!-- iPad Pro 10.5" (1668px x 2224px) -->
  <link rel="apple-touch-icon" sizes="180x180" href="/img/V8_BB_white.png">
  <link rel="mask-icon" href="/img/V8_BB_white.png" color="#6F6F6F">
  <meta name="msapplication-TileColor" content="#00aba9">
  <meta name="theme-color" content="#ffffff">

  <!-- service worker manifest -->
  <link rel="manifest" href="/manifest.json">

  <!-- Link to icon lib -->
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>

  <link href='https://fonts.googleapis.com/css?family=Averia Libre' rel='stylesheet'>

  <style>
    /* https://nationalparktypeface.com/Download */
    @font-face {
      /* font-family: NationalParkRegular; */
      /* src: url("misc/NationalPark/nationalparkregular.otf") format("otf"); */
      /* src: url("misc/NationalPark/nationalparkregular.otf"); */
      font-family: nationalparkregular;
      src: url(misc/NationalPark/nationalpark-regular.otf);
    }

    @font-face {
      font-family: nationalparkoutline;
      src: url(misc/NationalPark/nationalpark-outline.otf);
    }

    @keyframes spring {
      15% {
        -webkit-transform-origin: center center;
        -webkit-transform: scale(1.2, 1.1);
      }

      40% {
        -webkit-transform-origin: center center;
        -webkit-transform: scale(0.95, 0.95);
      }

      75% {
        -webkit-transform-origin: center center;
        -webkit-transform: scale(1.05, 1);
      }

      100% {
        -webkit-transform-origin: center center;
        -webkit-transform: scale(1, 1);
      }
    }

    * {
      /* font-family:nationalparkregular; */
      font-family: Arial;
      /* font-family: 'Averia Libre'; */
      margin: 0;
      padding: 0;
      text-decoration: none;
    }

    .background {
      background-color: #fff;
      height: 100%;
      width: 100%;
      padding-top: 0%;
      position: fixed;
      z-index: -1;
    }

    .bgimg {
      min-height: 100%;
      width: 100%;
    }

    .roundedbutton {
      color: white;
      display: inline-block;
      font-size: 14pt;
      text-decoration: none;
      padding: 10px 20px 10px 20px;
      border: 2px solid white;
      border-radius: 10000px;
      margin-top: 20px;
    }

    .roundedbutton:hover {
      background-color: white;
      color: #333;
      border: 2px solid white;
      transition: 0.5s;
    }

    .pagesection {
      padding-top: 60px;
      padding-bottom: 10px;
      width: 100%;
    }

    #home {
      color: white;
      padding-top: 80px;
      margin-bottom: 200px
    }

    #about_me {
      color: white;
      background-color: #333;
    }

    .about_me_cont {
      margin-left: 20%;
      width: 60%;
      padding: 10px 0px 20px 0px;
      padding-top: 10px;
      padding-bottom: 20px;
      border-radius: 5px;
    }

    #projects {
      background-color: white;
      color: #333;
    }

    #education {
      background-color: #333;
      color: white;
    }

    #work_experience {
      background-color: #333;
      color: white;
    }
    
    #login {
      color: white;
      background-color: #333;
    }

    .landing_image {
      margin-top: 10px;
    }

    .about_me_img {
      border-radius: 50%;
      border: 2px solid white;
    }

    h1 {
      color: white;
      font-weight: bolder;
      font-size: 36pt;
      letter-spacing: 2px;
      margin-bottom: 10px; 
    }

    h2 {
      font-size: 54pt;
      font-weight: bolder;
      margin-bottom: 10px;
    }

    h3 {
      font-size: 20pt;
      font-weight: bold;
    }

    p {
      font-size: 12pt;
      font-weight: lighter;
    }

    @media only screen and (max-width: 950px) {
      .about_me_cont {
        margin-left: 2%;
        width: 96%;
      }
      
      h1 {
        font-size: 34pt;
      }

      h2 {
        font-size: 32pt;
      }

      h3 {
        font-size: 20pt;
        font-weight: bolder;
      }

      p {
        font-size: 9pt;
      }
    }

    .card_container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      grid-gap: 5px;
      max-width: 1080px;
      margin: 0 auto 30px;
      padding: 2%;
    }

    .card {
      position: relative;
      width: 100%;
      object-fit: cover;
      box-shadow: 0 5px 5px 0 rgba(233, 240, 243, 0.5);
      border-radius: 5px;
      background-color: #333;
      color: white;
    }

    .box_overlay {
      opacity: 0%;
      border-radius: 5px;
      background-color: #333;
      position: absolute;
      z-index: 10;
      width: 100%;
      height: 100%;
      transition: 0.5s;
    }

    .box_overlay>h3 {
      margin-top: 25%;
    }

    .box_overlay>p {
      color: lightgray;
      margin-bottom: 10px;
      padding-left: 20px;
      padding-right: 20px;
    }

    .box_overlay:hover {
      opacity: 95%;
      /* filter: blur(1px); */
      /* transition: filter 0.3s ease-in; */
      /* transform: scale(1.1); */
    }

    .hover_contentbox_text {
      text-decoration: none;
      color: white;
    }

    .hover_contentbox_text:hover {
      text-decoration: none;
      color: white;
    }

    .hover_contentbox_text>h3 {
      margin-top: 20px;
    }

    .hover_contentbox_text>p {
      padding-bottom: 20px;
      padding-left: 20px;
      padding-right: 20px;
    }

    .hover_contentbox_text>img {
      display: block;
      border-radius: 0px 0px 5px 5px;
    }

    .section_item {
      margin-top: 20px;
      margin-bottom: 20px;
      margin-left: 15%;
      margin-right: 15%;
      padding: 20px;
      box-shadow: 0 5px 5px 0 rgba(233, 240, 243, 0.5), 0 0 0 1px #E6ECF8;
      border-radius: 5px;
      background-color: white;
      color: #333;
    }

    @media only screen and (max-width: 600px) {
      .section_item {
        margin-top: 20px;
        margin-bottom: 20px;
        margin-left: 2%;
        margin-right: 2%;
        padding: 20px;
        box-shadow: 0 5px 5px 0 rgba(233, 240, 243, 0.5), 0 0 0 1px #E6ECF8;
        border-radius: 5px;
        background-color: white;
        color: #333;
      }
    }

    .item_icon {
      display: inline-block;
      vertical-align: top;
      font-weight: bold;
    }

    .item_icon>img {
      border-radius: 2px;
    }

    .item_text {
      width: 90%;
      display: inline-block;
    }

    .item_text_h {
      font-weight: bold;
    }

    .item_text_hg {
      color: grey;
    }

    .item_text_hr {
      color: grey;
      float: right;
    }

    footer {
      background-color: #fff;
      margin-left: 0px;
      margin-right: 0px;
      width: 100%;
      padding-top: 60px;
      padding-bottom: 60px;
    }

    .footer_text {
      margin-top: 20px;
      color: grey;
    }

    .media_button {
      color: #333;
      transition: 0.5s;
    }

    .media_button:Hover {
      color: grey;
    }

    /* ========================================================================================================================================== */
    /* ========================================================================================================================================== */
    /* ========================================================================================================================================== */
    /* ============================================== */
    /* =================== Navbar =================== */
    /* javascript selection activation */
    .selected {
      text-decoration: none;
      color: #333 !important;
      background-size: 100% 100%;
      animation: spring 300ms ease-out;
      font-weight: bold;
    }

    .topnav {
      display: flex;
      width: 100%;
      justify-content: space-between;
      text-align: center;
      position: fixed;
      z-index: 15;
      background-color: #fff;
      opacity: 0.9;
    }

    .navlink {
      padding: 1rem 2rem 1.15rem;
      text-transform: uppercase;
      cursor: pointer;
      color: rgb(150, 150, 150);
      margin: auto;
      text-decoration: none;
    }

    .navlink:hover {
      background-color: transparent;
      text-decoration: none;
      color: #333;
      background-size: 100% 100%;
      animation: spring 300ms ease-out;
      /* text-shadow: 0 -1px 0 #333; */
      font-weight: bold;
    }

    /* Hamburger */
    .icon {
      display: none;
      right: 1;
      top: 0;
      padding-top: 11px;
      padding-right: 11px;
    }

    .icon:hover {
      background-color: transparent;
    }

    /* Hambuger - Icon 1 */
    #ham-bar1,
    #ham-bar2,
    #ham-bar3,
    #ham-bar4 {
      width: 40px;
      height: 27.01px;
      position: relative;
      margin: 0px auto;
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
      -webkit-transition: .5s ease-in-out;
      -moz-transition: .5s ease-in-out;
      -o-transition: .5s ease-in-out;
      transition: .5s ease-in-out;
      cursor: pointer;
    }

    #ham-bar1 span,
    #ham-bar3 span,
    #ham-bar4 span {
      display: block;
      position: absolute;
      height: 3px;
      width: 100%;
      background: #333;
      border-radius: 9px;
      opacity: 1;
      left: 0;
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
      -webkit-transition: .25s ease-in-out;
      -moz-transition: .25s ease-in-out;
      -o-transition: .25s ease-in-out;
      transition: .25s ease-in-out;
    }

    /* Icon 3 */
    #ham-bar3 span:nth-child(1) {
      top: 0px;
    }

    #ham-bar3 span:nth-child(2),
    #ham-bar3 span:nth-child(3) {
      top: 14px;
    }

    #ham-bar3 span:nth-child(4) {
      top: 28px;
    }

    #ham-bar3.open span:nth-child(1) {
      top: 28px;
      width: 0%;
      left: 50%;
    }

    #ham-bar3.open span:nth-child(2) {
      -webkit-transform: rotate(45deg);
      -moz-transform: rotate(45deg);
      -o-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    #ham-bar3.open span:nth-child(3) {
      -webkit-transform: rotate(-45deg);
      -moz-transform: rotate(-45deg);
      -o-transform: rotate(-45deg);
      transform: rotate(-45deg);
    }

    #ham-bar3.open span:nth-child(4) {
      top: 28px;
      width: 0%;
      left: 50%;
    }

    /* if screen is less than 950 */
    @media only screen and (max-width: 950px) {

      /* === nav links === */
      #myLink1,
      #myLink2,
      #myLink3 {
        display: none;
      }

      .topnav {
        display: inline;
        overflow: hidden;
        background-color: #fff;
      }

      .navlink {
        color: rgb(150, 150, 150);
        padding: 14px 16px;
        text-decoration: none;
        display: block;
      }

      .navlink:hover {
        background-color: transparent;
        text-decoration: none;
        color: #333;
      }

      /* Hamburger */
      .ham-bar3 {
        display: none;
      }

      .icon {
        display: inline;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 15;
      }

      .icon:hover {
        background-color: transparent;
      }
    }

    /* =================== Navbar =================== */
    /* ============================================== */
    /* ========================================================================================================================================== */
    /* ========================================================================================================================================== */
    /* ========================================================================================================================================== */
  
  
  
  
/* ========================================================================================================================================== */
/* ========================================================================================================================================== */ 
/* module login   */


/* * {
  color: black;
} */
/* 
body {
  font-family: Arial, Helvetica, sans-serif;
  } */

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  /* width: 100%; */
}

button:hover {
  opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

img.logo {
  
  margin-top: 20px;
  width: 15%;
  /* border-radius: 50%; */
}

.input_container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  /* z-index: 1; Sit on top */
  z-index: 20; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  color: #333;
  /* padding-top: 60px; */  
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  /* margin: 5% auto 15% auto; 5% from the top, 15% from the bottom and centered */
  margin: 4% auto 15% auto;  /*XX% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 70%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
  
  
  

  </style>

<!-- stylesheet for login module -->
<!-- <link rel="stylesheet" href="form.css"> -->






</head>

<body>
  <!-- Top Navigation Menu -->
  <div id="navbar" class="topnav">
    <a id="navlogo" class="navlink" href="#home">
      <img src="img/V8_BB_white.png" alt="Brandon Booth Logo" width="25" height="25">
    </a>
    <a id="myLink1" class="navlink" href="#about_me">About Me</a>
    <a id="myLink2" class="navlink" href="#projects">Projects</a>
    <a id="myLink3" class="navlink" href="#education">Education</a>
    <a id="myLink4" class="navlink" href="#work_experience">Work Experience</a>
    <a id="myLink5" class="navlink" href="#login">Login</a>
    <a class="icon">
      <div id="ham-bar3" href="javascript:void(0);" onclick="myFunction()">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </a>
  </div>

  <!-- background image -->
  <div class="background" align="center">
    <picture>
      <source srcset="img/twin_peaks_narrow.png" media="(max-width: 600px)">
      <source srcset="img/twin_peaks.png">
      <img src="img/twin_peaks.png" alt="twin peaks, San Francisco, California" class="bgimg">
    </picture>
  </div>

  <!-- Home/Landing Page section -->
  <div id="home" class="pagesection" align="center">
    
    <!-- empty space -->
    <div style="height:15%;"></div>    
    <h1 style="color: rgb(150, 150, 150);  text-shadow: 0 0 3px #fff;">Brandon Booth</h1>
    <h1 style="font-style: italic; text-shadow: 0 0 3px #333;">Industrial Engineer, Developer & Creator</h1>
    
    <h3 style="color: rgb(150, 150, 150);  text-shadow: 0 0 3px #fff;">San Francisco, CA</h3>
    <!-- <img class="landing_image about_me_img" src="img/mthoodsummit.jpg" width="35%" alt="Brandon Booth profile photo"> -->
    <!-- <img class="landing_image" src="img/V8_BB_white.png" width="15%" alt="Brandon Booth profile photo"> -->
    <div>
      <a class="roundedbutton" href="mailto:brandon.booth@yahoo.com">
        Say Hello
      </a>
    </div>
  </div>

  <!-- empty space -->
  <div style="height:200px;"></div>

  <!-- About Me Section -->
  <section id="about_me" class="pagesection" align="center">
    <h2>About Me</h2>
    <div class="about_me_cont" align="center">
      <img class="about_me_img" src="img/Brandon_Profile_Photo_square.jpg" width="25%" alt="Andina">
      <h3>Hi, I'm Brandon Booth. Thanks for visiting my website.</p>
        <p style="text-align: center;">I'm an Industrial Engineer located in San Francisco, California with over 5 years of experience implementing and optimizing manufactring and supply chain processes and systems within the microelectronics and apparel industries. I've built this website to display some of my personal projects and web development work.</p>
      </div>
  </section>

  <!-- Projects Section -->
  <section id="projects" class="pagesection" align="center">
    <h2>Projects</h2>

    <!-- Project Boxes -->
    <div class="card_container">
      
      <div class="card" align="center">
        <div class="box_overlay" align="center">
          <h3>
            Eat - SF
          </h3>
          <p>
            A list of my favorite food spots in San Francisco, CA
          </p>
          <a class="roundedbutton" href="eatSF.php">
            Visit Website
          </a>
        </div>

        <a class="hover_contentbox_text" href="eatSF.php">
          <h3>
            Eat - SF
          </h3>
          <p>
          </p>
          <img src="img/projects_eatSF.png" alt="coming soon" width="100%">
        </a>
      </div>

      <div class="card" align="center">
        <div class="box_overlay" align="center">
          <h3>
            Bars - SF
          </h3>
          <p>
            A list of bars in San Francisco, California
          </p>
          <a href="barsSF.php" class="roundedbutton">
            Visit Website
          </a>
        </div>

        <a class="hover_contentbox_text" href="barsSF.php">
          <h3>
            Bars - SF
          </h3>
          <p>
          </p>
          <img src="img/projects_barsSF.png" alt="coming soon" width="100%">
        </a>
      </div>

      <div class="card" align="center">
        <div class="box_overlay" align="center">
          <h3>
            Breweries - SF
          </h3>
          <p>
            A list of breweries in San Francisco, California
          </p>
          <a href="breweriesSF.php" class="roundedbutton">
            Visit Website
          </a>
        </div>

        <a class="hover_contentbox_text" href="breweriesSF.php">
          <h3>
            Breweries - SF
          </h3>
          <p>
          </p>
          <img src="img/breweriesSF/Harmonic Brewing.jpg" alt="coming soon" width="100%">
        </a>
      </div>


      <div class="card" align="center">
        <div class="box_overlay" align="center">
          <h3>
            Eat - PDX
          </h3>
          <p>
            A list of my favroite food spots in Portland, OR
          </p>
          <a class="roundedbutton" href="eatPDX.php">
            Visit Website
          </a>
        </div>

        <a class="hover_contentbox_text" href="eatPDX.php">
          <h3>
            Eat - PDX
          </h3>
          <p>
          </p>
          <img src="img/projects_eatPDX.jpg" alt="coming soon" width="100%">
        </a>
      </div>

      <div class="card" align="center">
        <div class="box_overlay" align="center">
          <h3>
            Coffee - PDX
          </h3>
          <p>
            A list of my favorite coffee spots and cafés in Portland, OR
          </p>
          <a href="coffeePDX.php" class="roundedbutton">
            Visit Website
          </a>
        </div>

        <a class="hover_contentbox_text" href="coffeePDX.php">
          <h3>
            Coffee - PDX
          </h3>
          <p>
          </p>
          <img src="img/projects_coffeePDX.png" alt="coming soon" width="100%">
        </a>
      </div>

      <div class="card" align="center">
        <div class="box_overlay" align="center">
          <h3>
            Breweries - PDX
          </h3>
          <p>
            A list of the best Breweries in Portland, OR
          </p>
          <a href="breweriesPDX.php" class="roundedbutton">
            Visit Website
          </a>
        </div>

        <a class="hover_contentbox_text" href="breweriesPDX.php">
          <h3>
            Breweries - PDX
          </h3>
          <p>
          </p>
          <img src="img/projects_breweriesPDX.png" alt="coming soon" width="100%">
        </a>
      </div>

      
      <div class="card" align="center">
        <div class="box_overlay" align="center">
          <h3>
            Eat - CDMX
          </h3>
          <p>
            A list of my favorite food spots in Mexico City, Mexico
          </p>
          <a href="eatCDMX.php" class="roundedbutton">
            Visit Website
          </a>
        </div>

        <a class="hover_contentbox_text" href="eatCDMX.php">
          <h3>
            Eat - Mexico City
          </h3>
          <p>
          </p>
          <img src="img/projects_eatCDMX.png" alt="coming soon" width="100%">
        </a>
      </div>
    </div>
  </section>


    <!-- Education -->
    <section id="education" class="pagesection" align="center">
      <h2>
        Education
      </h2>

      <div class="section_item" align="left">
        <!-- icon -->
        <div class="item_icon">
          <img src="img/oregonstate.png" alt="Oregon State Logo" width="35px" height="35px">
        </div>

        <!-- text -->
        <div class="item_text">
          <p>
            <span class="item_text_h">Oregon State University,</span>
            <span class="item_text_hg">Corvallis, OR</span>
            <span class="item_text_hr"></span>
          </p>
          <p class="item_text_h">B.S. Industrial Engineering, B.S. Manufacturing Engineering</p>
          <p>&#8226; Institute of Industrial Engineers - Chapter President (2014 - 2015)</p>
          <p>&#8226; Industrial Engineers - Publicity Director (2012 - 2014)</p>
          <p>&#8226; Society of Manufacturing Engineers - Webmaster (2013 - 2014)</p>
          <p>&#8226; Teaching Assistant - ENGR 248: Engineering Graphics and 3-D Modeling</p>         
          <p>&#8226; Teaching Assistant - IE 212: Computational Methods for Industrial Engineering</p>
        </div>
      </div>

    </section>


    <!-- Work Experience -->
    <section id="work_experience" class="pagesection" align="center">
      <h2>
        Work Experience
      </h2>
      <a href="https://oldnavy.gap.com/">
      <div class="section_item" align="left">
        <!-- icon -->
        <div class="item_icon">
          <img src="img/oldnavy.jpg" alt="Old Navy Logo" width="35px" height="35px">
        </div>

        <!-- text -->
        <div class="item_text">
          <p>
            <span class="item_text_h">Old Navy,</span>
            <span class="item_text_hg">San Francisco, CA</span>
            <span class="item_text_hr">August 2019 - Present</span>
          </p>
          <p class="item_text_h">Inventory Planner, Online Inventory Strategy</p>
          <p>&#8226; Develop analytical tools and business processes for the digital merchandising teams and senior management
            of
            the online business segment</p>
          <p>&#8226; Generate bottoms up financial rollups</p>
        </div>
      </div>
    </a>

      <div class="section_item" align="left">
        <!-- icon -->
        <div class="item_icon">
          <img src="img/tek.jpg" alt="Tektronix Logo" width="35px" height="35px">
        </div>

        <!-- text -->
        <div class="item_text">
          <p>
            <span class="item_text_h">Tektronix,</span>
            <span class="item_text_hg">Beaverton, OR</span>
            <span class="item_text_hr">February 2016 - July 2019</span>
          </p>
          <p class="item_text_h">Product Engineer, Tektronix Component Solutions</p>
          <p>&#8226; Provided focal point leadership for resolving manufacturing and supply chain issues regarding assemblies
            of
            BGA and hybrid packages, multichip modules, and electro-optic modules</p>
          <p>&#8226; Identified and executed opportunities for gross margin improvement, while meeting customer and industry
            standards, and Military/Government compliance requirements</p>
          <p>&#8226; Managed engineering builds and transition of NPI product from engineering to production status</p>
          <p>&#8226; Drove implementation and maintenance of assembly drawings, component specifications, bill of materials,
            routings, and product cost models</p>
          <p>&#8226; Created and managed systems for collecting production data (Oracle collection plans, Access forms)</p>
          <p>&#8226; Developed Excel macros for extraction and analysis of manufacturing data (e.g SPC, test, scrap,
            production
            flags)</p>
          <p>&#8226; Served as primary contact for customer technical assistance</p>
        </div>
      </div>

      <div class="section_item" align="left">
        <!-- icon -->
        <div class="item_icon">
          <img src="img/intel.png" alt="Intel Logo" width="35px" height="35px">
        </div>

        <!-- text -->
        <div class="item_text">
          <p>
            <span class="item_text_h">Intel,</span>
            <span class="item_text_hg">Aloha, OR</span>
            <span class="item_text_hr">June 2015 - February 2016</span>
          </p>
          <p class="item_text_h">Operations Manager, Factory Operations</p>
          <p>&#8226; Performed administrative management and drove the development of over 20 manufacturing technicians</p>
          <p>&#8226; Prioritized execution of repairs to maximize factory performance</p>
          <p>&#8226; Identified and implemented manufacturing resource projects to improve factory performance</p>
          <p>&#8226; Developed programs aimed at improving the factory safety record</p>
        </div>
      </div>


      <div class="section_item" align="left">
        <!-- icon -->
        <div class="item_icon">
          <img src="img/intel.png" alt="Intel Logo" width="35px" height="35px">
        </div>

        <!-- text -->
        <div class="item_text">
          <p>
            <span class="item_text_h">Intel,</span>
            <span class="item_text_hg">Hillsboro, OR</span>
            <span class="item_text_hr">April 2014 - January 2015</span>
          </p>
          <p class="item_text_h">Manufacturing Engineering Intern, Wireless Platform Research & Development Group</p>
          <p>&#8226; Performed bill of material, design for manufacturability, and first article inspections of Intel wireless products</p>
          <p>&#8226; Developed label artwork containing ecology and regulatory markings for Wi-Fi and WiGig modules</p>
          <p>&#8226; Created, inspected, and released tape-outs to contract manufacturers and assisted with resolving manufacturing issues</p>
          <p>&#8226; Developed VBA macros and Perl scripts to automate tape-out inspection process and part file management</p>
          <p>&#8226; Co-coordinated MECOP Internship Tours at Intel Jones Farm Campus</p>
        </div>
      </div>


      <div class="section_item" align="left">
        <!-- icon -->
        <div class="item_icon">
          <img src="img/daimler.png" alt="Daimler Logo" width="35px" height="35px">
        </div>

        <!-- text -->
        <div class="item_text">
          <p>
            <span class="item_text_h">Daimler Trucks North America,</span>
            <span class="item_text_hg">Portland, OR</span>
            <span class="item_text_hr">April 2013 - September 2013</span>
          </p>
          <p class="item_text_h">Industrial Engineering & Manufacturing Systems Intern, Manufacturing Engineering Group</p>
          <p>&#8226; Developed, maintained, and reported on labor standards</p>
          <p>&#8226; Assisted with the development of systems for planning, scheduling, and costing</p>
          <p>&#8226; Identified, developed, and reported on plant performance metrics and key performance indicators</p>
          <p>&#8226; Revised labor standards to reflect process and design changes</p>
          <p>&#8226; Developed decision support systems using VBA for automating mainframe database lookup and entry</p>
          <p>&#8226; Created work instructions for Industrial Engineering & Manufacturing Systems Department applications</p>
        </div>
      </div>


      <div class="section_item" align="left">
        <!-- icon -->
        <div class="item_icon">
          <img src="img/nordstrom.png" alt="Nordstrom Logo" width="35px" height="35px">
        </div>

        <!-- text -->
        <div class="item_text">
          <p>
            <span class="item_text_h">Nordstrom,</span>
            <span class="item_text_hg">Portland, OR</span>
            <span class="item_text_hr">June 2010 - January 2014</span>
          </p>
          <p class="item_text_h">Salesperson, Menswear and Men's Accessories</p>
          <p class="item_text_h">Future Nordstrom Leaders intern</p>
        </div>
      </div>
    </section>

    <!-- Login Section -->
    <section id="login" class="pagesection" align="center">
      <h2>Partner Login</h2>

      <!-- <div class="about_me_cont">
        <a class="roundedbutton" onclick="document.getElementById('id01').style.display='block'">
          Login
        </a>
      </div> -->

      <div class="about_me_cont">
        <button class="roundedbutton" onclick="document.getElementById('id01').style.display='block'">Login</button>
      </div>

      <!-- <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button> -->

      <div id="id01" class="modal">
        
        <form class="modal-content animate" method="post">
          <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <!-- <img src="img/img_avatar.png" alt="Avatar" class="avatar"> -->
            <img src="img/V8_BB_white.png" alt="Avatar" class="logo">
          </div>

          <div class="input_container" align="left">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
              
            <button type="submit" name="login" style="width: 100%;">Login</button>
            
            <label>
              <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
      
          </div>

          <div class="input_container" align="left" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
          </div>
        </form>
      </div>

    </section>

    <!-- empty space to assist navbar -->
    <!-- <div style="height:800px; -moz-box-shadow: inset 0 0 10px #000000; -webkit-box-shadow: inset 0 0 10px #000000; box-shadow: inset 0 0 10px #000000;"></div> -->
    <!-- <div style="height:800px; box-shadow: inset 0px 50px 10px #333;"></div> -->
    <div style="height:200px; background-color: #333;"></div>



    <footer>
      <div class="" align="center">
        <img src="img/V8_BB_white.png" alt="BB Logo" width="75" height="75">
        <br>
        <br>

        <a aria-label="LinkedIn" href="https://www.linkedin.com/in/brandon-booth-4b335232">
          <span class="media_button fa-stack">
            <i class="far fa-circle fa-stack-2x"></i>
            <i class="fab fa-linkedin fa-stack-1x"></i>
          </span>
        </a>

        <a aria-label="GitHub" href="https://github.com/brandonbooth">
          <span class="media_button fa-stack">
            <i class="far fa-circle fa-stack-2x"></i>
            <i class="media_button_icon fab fa-github fa-stack-1x"></i>
          </span>
        </a>

        <a aria-label="email" href="mailto:brandon.booth@yahoo.com">
          <span class="media_button fa-stack">
            <i class="far fa-circle fa-stack-2x"></i>
            <i class="media_button_icon  far fa-envelope fa-stack-1x"></i>
          </span>
        </a>

        <br>

        <p class="footer_text">Handcrafted by Brandon D Booth - Spring 2020</p>

      </div>
    </footer>

    <!-- expose JQuery globally "or" statement to write script to backup src path if cannot complete window.Query  -->
    <!-- "x3" is used in stead of "<" to avoid errors caused by interpreting end of script early  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery/jquery-3.2.1.slim.min.js">\x3C/script>')</script>

    <!--prevents page from scrolling down on refresh (ctrl+r) -->
    <script>history.scrollRestoration = "manual"</script>

    <script>
      //hamburger action
      $(document).ready(function () {
        $('#ham-bar1,#ham-bar2,#ham-bar3,#ham-bar4').click(function () {
          $(this).toggleClass('open');
        });
      });
    </script>

    <script>
      // assign navbar links to vars so that they may be activated
      var a = document.getElementById("myLink1");
      var b = document.getElementById("myLink2");
      var c = document.getElementById("myLink3");
      var d = document.getElementById("myLink4");
      var e = document.getElementById("myLink5");
      var element = document.getElementById("ham-bar3");

      // navbar drop-down menu 
      function myFunction() {
        if (a.style.display === "block") {
          a.style.display = "none";
          b.style.display = "none";
          c.style.display = "none";
          d.style.display = "none";
          e.style.display = "none";
        } else {
          a.style.display = "block";
          b.style.display = "block";
          c.style.display = "block";
          d.style.display = "block";
          e.style.display = "block";
        }
      }

      // screen width event function
      function displayWindowSize() {
        
        // Get width and height of the window excluding scrollbars
        var w = document.documentElement.clientWidth;
        var h = document.documentElement.clientHeight;

        // close hamburger if width is expanded beyond 950px
        if (w > 950) {
          a.style.display = "block";
          b.style.display = "block";
          c.style.display = "block";
          d.style.display = "block";
          e.style.display = "block";
          element.classList.remove("open");
        } else {
          a.style.display = "none";
          b.style.display = "none";
          c.style.display = "none";
          d.style.display = "none";
          e.style.display = "none";
          element.classList.remove("open");
        }
      }

      // Attaching the event listener function to window's resize event
      window.addEventListener("resize", displayWindowSize);

      // Call function
      displayWindowSize();
    </script>

    <script>
      window.addEventListener("scroll", function () {
        // Finding all elements of a class (creates an array of results)
        let sections = document.getElementsByClassName("pagesection");
        
        var mylinks = ["navlogo", "myLink1", "myLink2", "myLink3", "myLink4","myLink5"];
        var i;
        var elementTargets = [];
        var elements = [];
        var currentselection = 0;

        for (i = 0; i < sections.length; i++) {
          elementTargets[i] = sections[i];
          elements[i] = document.getElementById(mylinks[i]);
        }

        // ====================================================
        // ================ transparent navbar ================
        // if (window.scrollY < (30)) {
        //   // alert("Scroll is greater than 60");
        //   document.getElementById("navbar").style.backgroundColor = "transparent";
        //   document.getElementById("myLink1").style.color = "white";
        //   document.getElementById("myLink2").style.color = "white";
        //   document.getElementById("myLink3").style.color = "white";
        //   document.getElementById("myLink4").style.color = "white";
        // }

        // if (window.scrollY > (30)) {
        // alert("Scroll is greater than 60");
        //   document.getElementById("navbar").style.backgroundColor = "white";
        //   document.getElementById("myLink1").style.color = "rgb(150, 150, 150)";
        //   document.getElementById("myLink2").style.color = "rgb(150, 150, 150)";
        //   document.getElementById("myLink3").style.color = "rgb(150, 150, 150)";
        //   document.getElementById("myLink4").style.color = "rgb(150, 150, 150)";
        // }
        // ====================================================
        // ====================================================


        for (i = 0; i < elements.length; i++) {

          if (window.scrollY < (elementTargets[1].offsetTop)) {
            // Finding all elements of a class (creates an array of results)
            let x = document.getElementsByClassName("selected");

            // If it exists, remove it.
            if (x.length > 0) {
              x[0].classList.remove("selected");
            }
          }

          if ((window.scrollY > (elementTargets[i].offsetTop - 10)) && (window.scrollY < (elementTargets[i].offsetTop - 10 + elementTargets[i].offsetHeight))) {
            // Finding all elements of a class (creates an array of results)
            let x = document.getElementsByClassName("selected");

            // If it exists, remove it.
            if (x.length > 0) {
              let xx = x[0].id;
              currentselection = xx;
            }

            if (mylinks[i] != currentselection) {

              // Finding all elements of a class (creates an array of results)
              let x = document.getElementsByClassName("selected");

              // If it exists, remove it.
              if (x.length > 0) {
                x[0].classList.remove("selected");
              }

              elements[i].classList.add("selected");
              currentselection = i;
            }

          }
        }
      });
    </script>

    <!-- Service Worker Navigator-->
    <!-- <script src="/js/app.js"></script> -->
</body>

</html>