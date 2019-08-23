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

//$name = $_POST['formCustomer'];
$name = 'john';
$results = DB::select("select * from customer where f_name = '$name'");
var_dump($results);
echo "</br>";
foreach($results as &$result){
echo "</br>";
//echo $result['f_name'];
$key = get_object_vars($result);
echo "this is \$key ";
var_dump($key);
   foreach($result as $value){
      echo "$value" . " ";
   }
//$keys = (get_object_vars($results[0]));
//foreach($keys as &$key)
//$results[0]->$key ;
//echo $key;
echo "</br>";

}
var_dump($result->f_name);  // this is how you pull a peace of data out of an object
   ?>
   <p></p>
