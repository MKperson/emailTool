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
                Email: <input type = 'text' name='c_email' value = '<?php echo $result->c_email ?>'></br>
                Address: <input type = 'text' name = 'c_address' value = '<?php echo $result->c_address?>'></br>
                Phone: <input type = 'text' name = 'c_number'value = '<?php echo $result->c_number?>'></br>
                <input type="hidden" name="cust_id" value = '<?php echo $result->cust_id?>'>
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                Current Phase <select name='p_name'>
                    <?php
                    $index = 0;
                    for ($i = 0; $i < sizeof($phase); $i++) {
                        if ($phase[$i]->phase_id == $result->cur_phase) {
                            $index=$i
                            ?>
                            <option value='<?php echo $phase[$i]->p_name ?>' selected='selected'><?php echo $phase[$i]->p_name ?> </option>
                        <?php
                        } else {
                            ?>
                            <option value='<?php echo $phase[$i]->p_name?>'><?php echo $phase[$i]->p_name ?> </option>
                        <?php
                        }
                    }
                    echo "</select></br>";
                    //echo "Current Phase: <input type='text' value='$result->cur_phase'></br></br>";
                    //echo "$daymess : <input type='text' name= 'days' value='$result->est_day_left'></br>";
                    ?>
                    <?php echo $daymess?> : <input type = 'text' name = 'est_day_left' value = '<?php echo $phase[$index]->est_day_left?>'> </br>
                    
                    Additional Comments:<br><textarea name = 'p_comment'><?php echo $phase[$index]->p_comment?></textarea></br>
                    <?php 
                    if ($result->delv_content == true) {
                        echo "<input type='radio' name='delv_content' checked value = '1'>Has Deliverd Content
            <input type='radio' name='delv_content' value = '0'>Waiting on Content</br>";
                    } else {
                        echo "<input type='radio' name='delv_content' value='1' >Has Deliverd Content
            <input type='radio' name='delv_content' checked value='0'>Waiting on Content</br>";
                    }


                    ?>
                    <input type="submit" value='submit' >
                    <!--onClick="update()"-->

                    <script>
                        //jQuery(document).ready(function($) {

                        function update() {
                            alert('Running update.');
                            var ph = $('#phase').val();
                            var str = $( "form" ).serialize();

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: "/update",
                                type: 'POST',
                                data: //$("#registerSubmit").serialize()
                                {
                                    form: str,
                                    //phase: ph,
                                    //_token: '{{csrf_token()}}'


                                },
                                success: function(response) {
                                    console.log('Success: ' + response);
                                },
                                error: function(xhr, errorCode, errorThrown) {
                                    console.log(xhr.responseText);
                                }
                            })
                        };
                        //});
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