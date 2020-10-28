<?php
    session_start();
    require_once('../include_/dbconnect.php'); 
    
    $_SESSION['table_name'] = 'list_pages';
    
    // // Return the number of rows in result set
    $sql = "SELECT * FROM ".$_SESSION['table_name'];
    $result = $mysqli->query($sql);
    $rowcount = mysqli_num_rows($result);
    $fieldcount = mysqli_field_count($mysqli);

    /* Get   field information for all columns */
    $finfo = $result->fetch_fields();
    
    $ctr = 0;

    echo 'The following ' . $rowcount . ' subjectplace files were created at ' .date("Y-m-d H:i:s") . ': ';
    echo '<br>';
    echo '<br>';

    foreach ($finfo as $val) {
        $field[$ctr] = $val->name;
        $ctr = $ctr + 1;
    }
    
    for ($y = 1; $y <= $rowcount; $y++) {
        $query = "SELECT * FROM ".$_SESSION['table_name']." WHERE id =". $y . ";";
        $results = $mysqli->query($query);
        // $row = $results->fetch_assoc(); OOP
        $row = mysqli_fetch_row($results);
        
        echo 'List['.$y.']: '.$row[0];
        echo ' - ';

        $page_title = $row[0];
        $page_description = $row[1];
        $page_keywords = $row[2];
        $page_name = $row[3];
        $page_author = $row[4];
        $page_image = $row[5];
        $color1 = $row[6];
        $twitter_link = $row[7];
        $table_name = $row[8];
        $last_update = $row[9];
        $id = $row[10];

        echo "File written at ".date("Y-m-d H:i:s");
        echo "<br>";
        $template = 'subjectplace.php';
        $output_file = $page_name;
        $file_contents = file_get_contents($template);
        $file_contents = str_replace("@1@",$color1,$file_contents);
        $file_contents = str_replace("@2@",$page_title,$file_contents);
        $file_contents = str_replace("@3@",$page_description,$file_contents);
        $file_contents = str_replace("@4@",$page_keywords,$file_contents);
        $file_contents = str_replace("@5@",$page_name,$file_contents);
        $file_contents = str_replace("@6@",$page_author,$file_contents);
        $file_contents = str_replace("@7@",$page_image ,$file_contents);
        $file_contents = str_replace("@8@",$twitter_link,$file_contents);
        $file_contents = str_replace("@9@",$table_name,$file_contents);
        $file_contents = str_replace("@10@",$last_update,$file_contents);
        
        file_put_contents($output_file,$file_contents);

        $sql = "CREATE TABLE list_".$table_name." (id int NOT NULL AUTO_INCREMENT, Place text, Place_description text, Photo text, Rank int(11), PRIMARY KEY (id));";
        $result = $mysqli->query($sql);
    }
?>

<p><a href="inputform.php"><-- Back to Input Form</a></p>