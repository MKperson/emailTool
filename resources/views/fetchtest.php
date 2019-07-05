<?php
use Illuminate\Support\Facades\DB;

//    $dbhost = 'localhost:3306';
//    $dbuser = 'root';
//    $dbpass = 'rootpassword';
//    $dbname = 'emailer_db';
   
//    $conn = new mysqli($dbhost, $dbuser,null,$dbname);
   
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     } 
//     echo "Connected successfully";
    
    
//    $sql = 'SELECT * FROM customer';
//    $result = $conn->query($sql);

//    //echo $result;


//    if ($result->num_rows > 0) {
//        // output data of each row
//        while($row = $result->fetch_assoc()) {
//            echo "id: " . $row["id"]. " - Name: " . $row["f_name"]. " " . $row["l_name"]. "<br>";
//        }
//    } else {
//        echo "0 results";
//  }
//    $conn->close();


$results = DB::select('select * from customer');
//foreach($results as &$value)
$keys = (get_object_vars($results[0]));
foreach($keys as &$key)
echo "$key" . " " ;// $results[0]->$key ;
//var_dump($results);


   ?>
