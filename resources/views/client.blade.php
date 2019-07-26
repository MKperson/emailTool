@extends('layouts.app')

<?php
//die(var_dump($_POST));
?>

<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <title>Emailer</title>

    
</head>
@section('content')

<body>

    <div>
        <?php

        use \App\Http\Controllers\EmailerController;

        $name = $_POST['formCustomer'];
        //var_dump($name);
        //$call = "select * from customer where c_name = '$name'";
        $result = EmailerController::Fetch('customer', 'c_name', $name);
        //var_dump($result);
        $phase = EmailerController::Fetch('c_phase', 'cust_id', $result->cust_id);
        //var_dump(sizeof($phase));
        //var_dump($phase[0]->phase_id);
        //var_dump($result->cur_phase);
        //*
        if ($result != null) {
            $daymess = 'Estimated Day\'s left';
            //if ($result->est_day_left == 1) {
            //$daymess = ' One Day left';
            //}

            echo "<h3>Editing</h3>";
            echo "<h4>$result->c_name</h4>"; ?>
            <form action="/update" method='POST'>
                <!---->
                Email: <input type='text' id='c_email' value='<?php echo $result->c_email ?>'></br>
                Address: <input type='text' id='c_address' value='<?php echo $result->c_address ?>'></br>
                Phone: <input type='text' id='c_number' value='<?php echo $result->c_number ?>'></br>
                <input type="hidden" id="cust_id" value='<?php echo $result->cust_id ?>'>
                <input type="hidden" id="cur_phase" value='<?php echo $result->cur_phase ?>'>
                <input type="hidden" id="company_name" value='<?php echo $result->c_name ?>'>

                <input type="hidden" id="_token" value="{{ csrf_token() }}">

                Current Phase <select id='p_name' onchange="reload()">
                    <?php
                    $index = 0;
                    for ($i = 0; $i < sizeof($phase); $i++) {
                        if ($phase[$i]->phase_id == $result->cur_phase) {
                            $index = $i
                            ?>
                            <option value='<?php echo $phase[$i]->p_name ?>' selected='selected'><?php echo $phase[$i]->p_name ?> </option>
                        <?php
                        } else {
                            ?>
                            <option value='<?php echo $phase[$i]->p_name ?>'><?php echo $phase[$i]->p_name ?> </option>
                        <?php
                        }
                    }
                    echo "</select></br>";
                    //echo "Current Phase: <input type='text' value='$result->cur_phase'></br></br>";
                    //echo "$daymess : <input type='text' name= 'days' value='$result->est_day_left'></br>";
                    ?>
                    <?php echo $daymess ?> : <input type='text' id='est_day_left' value='<?php echo $phase[$index]->est_day_left ?>'> </br>

                    Additional Comments:<br><textarea id='p_comment'><?php echo $phase[$index]->p_comment ?></textarea></br>
                    <?php
                    if ($result->delv_content == true) {
                        echo "<input type='radio' name='delv_content' id='delv_content' checked value = '1'>Has Deliverd Content
            <input type='radio' name='delv_content' id='delv_content' value = '0'>Waiting on Content</br>";
                    } else {
                        echo "<input type='radio' name='delv_content' id='delv_content' value='1' >Has Deliverd Content
            <input type='radio' name='delv_content'  checked value='0'>Waiting on Content</br>";
                    }


                    ?>
                    <input type="button" value='Submit' onClick="update()">
                    <input type="button" value="Cancel" onclick="location.href = '/'"><br>
                    <input type="button" value="Preview message" onclick="preview()">
                    
                    <script type="text/javascript" src='js/scripts.js'></script>

            </form>
        <?php
        } else {
            echo "An error has occured";
        }




        ?>
    </div>

</body>
@endsection

</html>