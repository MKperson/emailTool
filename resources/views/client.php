<?php
//die(var_dump($_POST));
?>
<html>

<body>
    <h3>Editing</h3>
    <?php
    $name = $_POST['formCustomer'];
    $results = DB::select("select * from customer where c_name = '$name'");
    //var_dump($results);
    //echo "</br>";
    if (count($results) > 1)
        foreach ($results as &$result) {
            //echo "</br>";
        } else {
            $result = $results[0];
        echo "<h5>$result->c_name</h5>
        Email: $result->c_email</br></br>
        Current Phase: <input type='text' value='$result->p_phase'></br></br>
        Estimated time left: <input type='text'></br></br>
        Additional Comments:<br><textarea></textarea></br></br>
        <input type = 'submit'value = 'submit'>";
        }
        ?>

    </body>

    </html>