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
        var_dump($name);
        //$call = "select * from customer where c_name = '$name'";
        $result = EmailerController::Fetch('customer', 'c_name', $name);

        if ($result != null) {
            $daymess = 'Estimated Day\'s left';
            if ($result->est_day_left == 1) {
                $daymess = ' One Day left';
            }

            echo "<h3>Editing</h3>";
            echo "<h4>$result->c_name</h4>"; ?>
            <form action="{{ route('update') }}" method='POST'> Email: <?php $result->c_email ?>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <?php
                echo "Current Phase <select id=\"phase\" name = 'phase'>";
                for ($i = 1; $i <= $result->num_phase; $i++) {
                    if ($i == $result->cur_phase) {
                        echo "<option value ='$i' selected='selected'>$i </option>";
                    }
                    echo "<option value ='$i'>$i </option>";
                }
                echo "</select></br>";
                //echo "Current Phase: <input type='text' value='$result->cur_phase'></br></br>";
                echo "$daymess : <input type='text' name= 'days' value='$result->est_day_left'></br>";
                echo "Additional Comments:<br><textarea >$result->comments</textarea></br>";
                if ($result->delv_content == true) {
                    echo "<input type='radio' name='content' checked>Has Deliverd Content
            <input type='radio' name='content'>Waiting on Content</br>";
                } else {
                    echo "<input type='radio' name='content' >Has Deliverd Content
            <input type='radio' name='content' checked>Waiting on Content</br>";
                }


                ?>
                <input type="submit" value='submit'> <!--onClick="update()">
                -->

                <script>
                    //jQuery(document).ready(function($) {

                    function update() {
                        alert('Running update.');
                        var ph = $('#phase').val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: "{{ route('update') }}",
                            type: 'POST',
                            data: {
                                phase: ph,
                                _token: '{{csrf_token()}}'


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
        <?php } else {
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