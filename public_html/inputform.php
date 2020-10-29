<?php
    session_start();
    $_SESSION['rdrs'] = 1;

    $_SESSION['rdrs'] = $_SESSION['rdrs'] + 1;

    if ($_SESSION['rdrs'] > 5){
      echo '5 redirects';
    }
    else {
      // header("location: index.php");
    }

    if ($_SESSION['signed_in'] == "yes"){
      
    }
    else {
      header("location: index.php");
    }

    if (!isset($_SESSION['table_name'])){
      // echo 'is not set' .date("Y-m-d H:i:s");
      $_SESSION['table_name'] = "list_eatSF";
    }

    // change list button
    if(array_key_exists('change_list', $_POST)) { 
      $_SESSION['table_name'] = $_POST['table_lists'];
      // header("location: inputform.php");
    }

    // change list button
    if(array_key_exists('table_lists', $_POST)) { 
      $_SESSION['table_name'] = $_POST['table_lists'];
      // header("location: inputform.php");
    }

  require_once('../private/dbconnect.php');   
    
    // // Return the number of rows in result set
    $sql = "SELECT * FROM ".$_SESSION['table_name'];
    $result = $mysqli->query($sql);
    $rowcount = mysqli_num_rows($result);
    $fieldcount = mysqli_field_count($mysqli);

    // echo "<br> row count: ". $rowcount."<br>";
    // echo "<br> field count: ". $fieldcount."<br>";
    
    /* Get   field information for all columns */
    $finfo = $result->fetch_fields();
    
    $ctr = 0;
    
    foreach ($finfo as $val) {
        $field[$ctr] = $val->name;
        $ctr = $ctr + 1;
    }
    
    for ($y = 1; $y <= $rowcount; $y++) {
        $query = "SELECT * FROM ".$_SESSION['table_name']." WHERE id =". $y . ";";
        $results = $mysqli->query($query);
        // echo "<br> row: ". $row[0]."<br>";
        if ($results->num_rows > 0) {
            // output data of each row
            while($row = $results->fetch_assoc()) {
                // echo "<br> Place: ". $row["Place"]."<br>";
                // echo "<br> Place: ". $row[$field[0]] ."<br>";
                for ($x = 1; $x <= $fieldcount; $x++) {
                  ${'r' . $y. 'c'. $x} = $row[$field[$x-1]];
                  ${'r' . $y. 'c'. $field[$x-1]} = $row[$field[$x-1]];
                }
            }
        } else {
            echo "0 results";
        }
    }
    
    // add item button
    if(array_key_exists('add_item', $_POST)) { 
      $place = 'PLACE';
      $place_description = 'PLACE DESCRIPTION';
      $photo = 'PHOTO';
      
      // $sql = "INSERT INTO " . $_SESSION['table_name'] ." (Place,Place_Description,Photo) VALUES ('$place','$place_description','$photo')";
      $sql = "INSERT INTO " . $_SESSION['table_name'] ." () VALUES ()";
      

      if ($mysqli->query($sql) === true) {    
        
        $sql = "ALTER TABLE " . $_SESSION['table_name'] ."  DROP COLUMN id;";
        $mysqli -> query($sql);


        $sql = "ALTER TABLE " . $_SESSION['table_name'] ."  ORDER BY place;";
        $mysqli -> query($sql);


        $sql = "ALTER TABLE  " . $_SESSION['table_name'] ."  ADD id INT PRIMARY KEY AUTO_INCREMENT;";
        $mysqli -> query($sql);
        $mysqli -> close();
        header("location: inputform.php");
      }
      else {
        $_SESSION['message'] = "User could not be added to the database!";
      }
    }

    // refresh pages button
    if(array_key_exists('refresh_pages_button', $_POST)) { 
      header("location: write_file.php");
    }

    // row specific buttons
    for ($x = 1; $x <= $rowcount; $x++) {
    
      // remove buttons
      if(array_key_exists('remove_button_' . $x, $_POST)) {
        $offset = $x - 1;
        $sql = "DELETE FROM " . $_SESSION['table_name'] ." where id = (select id from (select id from " . $_SESSION['table_name'] ." order by id limit " . $offset . ",1) as n)";
        $mysqli -> query($sql);
        $sql = "ALTER TABLE " . $_SESSION['table_name'] ." DROP COLUMN id;";
        $mysqli -> query($sql);
        $sql = "ALTER TABLE " . $_SESSION['table_name'] ." ADD id INT PRIMARY KEY AUTO_INCREMENT;";
        $mysqli -> query($sql);
        $mysqli -> close();
        header("location: inputform.php");
      }
      
      // update buttons
      if(array_key_exists('update_button_' . $x, $_POST)) {    
        $offset = $x - 1;

        // assign field entries to vars
        for ($a = 0; $a < $fieldcount; $a++) {
          $field_entry[$a] = $_POST[$field[$a].$x];
        }
        for ($y = 0; $y < $fieldcount; $y++) {
          if ($field_entry[$y] <> "") {
            $sql = "UPDATE " . $_SESSION['table_name'] ." SET $field[$y] = '$field_entry[$y]' WHERE id = $x;";
            $mysqli -> query($sql);
          }
        }
        
        $sql = "ALTER TABLE " . $_SESSION['table_name'] ." DROP COLUMN id;";
        $mysqli -> query($sql);    
        $sql = "ALTER TABLE " . $_SESSION['table_name'] ." ADD id INT PRIMARY KEY AUTO_INCREMENT;";
        $mysqli -> query($sql);
        $mysqli -> close();
        header("location: inputform.php");
      }
    } 
?>

<!-- <!DOCTYPE html> -->
<html>
<head>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=0">

  <!-- Link to icon lib -->
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>

  <link href='https://fonts.googleapis.com/css?family=Averia Libre' rel='stylesheet'>


<style>

* {
  /* box-sizing: border-box; */
}

body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: #333;
  margin: 0px;
  padding: 0px;
}

h2 {
  color: white;
}

.form-inline {  
  background-color: white;
  width: 100%; 
  /* display:inline-block */
  display: flex;
  /* flex-flow: row wrap; */
  align-items: center;
  /* outline-style: ridge; */
  margin: 5px 0px 0px 0px;
  /* white-space:nowrap; */
}

.form-inline label {
  margin: 5px 10px 5px 10px;
}

.form-inline input {
  vertical-align: middle;
  margin: 5px 10px 5px 0;
  padding: 10px;
  background-color: #fff;
  /* color: white; */
  border: 1px solid #ddd;
}

.form-inline button {
  padding: 10px 20px;
  /* background-color: #333; */
  border: 1px solid #ddd;
  color: white;
  cursor: pointer;
}

.form-inline button:hover {
  background-color: white;
  color: black;
}

.input_item {
  white-space:nowrap;  
}

@media (max-width: 800px) {
  .form-inline input {
    margin: 10px 0;
  }
  
  .form-inline {
    /* white-space:normal; */
    flex-direction: column;
    align-items: stretch;
  }

  .input_item {
    white-space:normal; 
  }

  .add_item_button {
    border: 2px solid white;
      border-radius: 10000px;




      width: 47%;
      border: 2px solid white;
      border-radius: 10000px;
      margin-top: 20px;
}

  .update_button {
      width: 47%;
      border: 2px solid white;
      border-radius: 10000px;
      margin-top: 20px;

  }
  
  .remove_button {
      width: 47%;
      border: 2px solid white;
      border-radius: 10000px;
      margin-top: 20px;

  }
  .row_buttons {
  padding-bottom: 10px;
  }

}


.lists {
  padding: 10px 20px;
  /* background-color: #333; */
  border: 1px solid #ddd;
  /* color: white; */
  color: #333;

  cursor: pointer;
}

.change_list_button {
  padding: 10px 20px;
  /* background-color: #333; */
  border: 1px solid #ddd;
  /* color: white; */
  color: #333;

  cursor: pointer;
}



.add_item_button {
  /* margin: 5px 0px 0px 10px; */
  /* padding: 10px 20px; */
  background-color: green;
  border: 1px solid #ddd;
  color: white;
  cursor: pointer;




  white-space: pre;
  

  padding: 10px 20px;
  /* background-color: #333; */
  border: 1px solid white;
  color: white;
  cursor: pointer;


  /* padding: 1rem 2rem 1.15rem; */
      text-transform: uppercase;
      cursor: pointer;
      margin: auto;
      text-decoration: none;


}

.add_item_button:hover {
  background-color: white;
  color: black;
}


.row_buttons {
      display: flex;
      width: 100%;
      justify-content: space-between;
      text-align: center;
      
      /* position: fixed; */
      /* z-index: 15; */
      /* background-color: #fff; */
      /* opacity: 0.9; */
}

.update_button {
  white-space: pre;
  

  padding: 10px 20px;
  background-color: #333;
  border: 1px solid white;
  color: white;
  cursor: pointer;


  padding: 1rem 2rem 1.15rem;
      text-transform: uppercase;
      cursor: pointer;
      /* color: rgb(150, 150, 150); */
      margin: auto;
      text-decoration: none;


}

.remove_button {

  white-space: pre;

  padding: 10px 20px;
  background-color: #c00000;
  border: 1px solid white;
  color: white;
  cursor: pointer;



  padding: 1rem 2rem 1.15rem;
      text-transform: uppercase;
      cursor: pointer;
      /* color: rgb(150, 150, 150); */
      margin: auto;
      text-decoration: none;
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

    .navitem {
      padding: .5rem 1rem 0rem 0rem;
      
      text-transform: uppercase;
      cursor: pointer;
      color: rgb(150, 150, 150);
      /* margin: auto; */
      text-decoration: none;
    }

    .navitem:hover {
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
        /* display: inline; */
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
  
/* ===================== */
/* footer */


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





</style>
</head>

<body>

  <!-- Top Navigation Menu -->
  <div id="navbar" class="topnav">
    <a id="navlogo" class="navlink" href="https://brandon-booth.com">
      <img src="img/V8_BB_white.png" alt="Brandon Booth Logo" width="25" height="25">
    </a>
    <!-- <a id="myLink1" class="navlink" href="#about_me">Empty</a> -->
    
  <a id="" class="navitem" href="#">

    <form action="inputform.php" method="post" enctype="multipart/form-data" autocomplete="off">    
      <select class="lists" id="table_lists" name="table_lists" onchange="this.form.submit()">

        <?php
          // $mysqli = new mysqli('localhost','brandonb_brandon','testing123','brandonb_places');
          
          //show tables
          $result = $mysqli->query("SHOW TABLES from brandonb_places LIKE 'list_%'");
          
          // default option
          echo '<option value="'.$_SESSION['table_name'].'">'. $_SESSION['table_name'].'</option>';

          while($tableName = mysqli_fetch_row($result)){
            $table = $tableName[0];
            // echo '<h3>' ,$table, '</h3>';
            echo '<option value="' . $table . '">' . $table . '</option>';
          }
        ?>
      </select>
      <!-- <input class="change_list_button" name="change_list" type="submit" value="Change List"> -->
    </form>

  <a>

    <a class="icon">
      <!-- <div id="ham-bar3" href="javascript:void(0);" onclick="myFunction()">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div> -->
    </a>
  </div>

<?php
  date_default_timezone_set("America/Los_Angeles");
  // echo '<h2>Session List Item: ' . $_SESSION['table_name'] .' - ' .date("Y-m-d H:i:s") . '</h2>';
  // echo '<h2>' . $_SESSION['message'] .'</h2>';
  // echo '<h2>Table name:' . $_SESSION['table_name'] .'</h2>';
?>

<!-- <p>Note: Form will stay horizontal until the screen width of the browser window is less than 850 pixels: then the form is displayed vertically instead of horizontally.</p> -->  
<div style="height: 80px;"></div>

  <form class="row_buttons" action="inputform.php" method="post" enctype="multipart/form-data" autocomplete="off">
    <!-- <button class="add_item_button" name="add_item" type="submit">(+) Add Item</button> -->
    
    <button class="add_item_button" name="add_item" type="submit">(+) Add Item</button>
    <button class="add_item_button" name="refresh_pages_button" type="submit">Refresh pages</button>
    
  </form>

<?php  
for ($rownum = 1; $rownum <= $rowcount; $rownum++) {
  echo '<!-- Content Box'.$rownum.'-->';
  echo '<div class="form-inline" action="">';
    // echo '<div>Row #'.$rownum.': </div>';

    echo '<form class="form-inline" action="" method="post" enctype="multipart/form-data" autocomplete="off">';
    
    $display_style = 'initial';

    for ($fieldnum = 0; $fieldnum <$fieldcount; $fieldnum++) {
    
      if ($_SESSION['table_name'] <> 'list_pages') {
        if ($fieldnum == 0) {
          $display_style = 'initial';
        }
        else {
          $display_style = 'none';
        }
      }

    echo '<div style="display: ' . $display_style . ';" class="input_item">';
      echo '<label for="'. $field[$fieldnum] .'" >'. $field[$fieldnum] .':</label>';
      echo '<input id="'. $field[$fieldnum] .'" name="'. $field[$fieldnum] . $rownum .'" type="text" placeholder="' . ${'r' . $rownum .'c'. $field[$fieldnum]} .'">';
    echo "</div>";  

    }

    echo '<div class="row_buttons">';
      echo '<button class="update_button" name="update_button_' . $rownum .'" type="submit">Update</button>';
      echo '<button class="remove_button" name="remove_button_' . $rownum .'" type="submit">(-) Remove</button>';  
    echo '</div>';

    echo '</form>';
  echo '</div>';

  }
?>  





</body>


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


</html>