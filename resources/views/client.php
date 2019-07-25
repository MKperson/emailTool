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

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #dadfe3;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

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
                    <input type="button" value="Cancel" onclick="location.href = '/'">
                    <!---->

                    <script>
                        //jQuery(document).ready(function($) {

                        function update() {
                            //alert('Running update.');
                            //var ph = $('#phase').val();
                            var cpid = $('#cur_phase').val();
                            var cma = $('#c_email').val();
                            var cadd = $('#c_address').val();
                            var cnum = $('#c_number').val();
                            var cid = $('#cust_id').val();
                            var tok = $('#_token').val();
                            var pn = $('#p_name').val();
                            var edl = $('#est_day_left').val();
                            var pc = $('#p_comment').val();
                            var dc = $('#delv_content')[0].checked
                            if (dc == true)
                                dc = 1;
                            else
                                dc = 0;
                            console.log(cpid);


                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: "/update",
                                type: 'POST',
                                data: {
                                    c_email: cma,
                                    c_address: cadd,
                                    c_number: cnum,
                                    cust_id: cid,
                                    _token: tok,
                                    p_name: pn,
                                    est_day_left: edl,
                                    p_comment: pc,
                                    delv_content: dc,
                                    cur_phase:cpid

                                    //form: str,
                                    //phase: ph,
                                    //_token: '{{csrf_token()}}'
                                },
                                success: function(response) {
                                    console.log('Success: ' + response);
                                    location.href='/';
                                    alert('Success');
                                },
                                error: function(xhr, errorCode, errorThrown) {
                                    console.log(xhr.responseText);
                                }
                            })
                        };

                        function reload() {
                            //alert("Reload called");
                            var cid = $('#cust_id').val();
                            var pn = $('#p_name').val();
                            $.ajax({
                                url: "/reload",
                                type: 'POST',
                                data: {
                                    cust_id: cid,
                                    p_name: pn
                                },
                                success: function(response) {
                                    console.log('Success: ' + response);
                                    location.reload(true);
                                },
                                error: function(xhr, errorCode, errorThrown) {
                                    console.log(xhr.responseText);
                                }
                            })
                             //location.reload(true);
                        };


                           
                    </script>

            </form>
        <?php
        } else {
            echo "An error has occured";
        }

        $js = "jQuery(document).ready(function($){

            function update() {
                alert('Running update.');
                var ph = $('#phase').value();

                $.ajax({
                    url: '/update',
                    type: 'POST',
                    data: {
                        phase: ph
                    },
                    success: function(response) {
                        console.log('Success: ' + response);
                    },
                    error: function(xhr, errorCode, errorThrown) {
                        console.log(xhr.responseText);
                    }
                })
            }
            });";


        ?>
    </div>

</body>

</html>