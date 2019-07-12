<?php
//die(var_dump($_POST));
?>
<html>

<body>

    <?php

    use \App\Http\Controllers\EmailerController;
    use PhpParser\Node\Stmt\TryCatch;
    use PHPUnit\Framework\MockObject\Stub\Exception;

    $name = $_POST['formCustomer'];
    //$call = "select * from customer where c_name = '$name'";
    $result = EmailerController::Fetch('customer', 'c_name', $name);

    if ($result != null) {
        $daymess = 'Estimated Day\'s left';
        if ($result->est_day_left == 1) {
            $daymess = ' One Day left';
        }
        
        echo "<h3>Editing</h3>";
        echo "<h5>$result->c_name</h5>";
        echo "Email: $result->c_email</br></br>";
        echo "Current Phase: <input type='text' value='$result->cur_phase'></br></br>";
        echo "$daymess : <input type='text' value='$result->est_day_left'></br></br>";
        echo "Additional Comments:<br><textarea >$result->comments</textarea></br></br>";
        if($result->delv_content == true){
            echo "<input type='radio' name='content' checked>Has Deliverd Content
            <input type='radio' name='content'>Waiting on Content</br>";
        }
        else{
            echo "<input type='radio' name='content' >Has Deliverd Content
            <input type='radio' name='content' checked>Waiting on Content</br>";
        }
        

        echo"<input type = 'submit'value = 'submit'>";
    } else {
        echo "An error has occured";
    }


    ?>


</body>

</html>