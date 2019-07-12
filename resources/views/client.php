<?php
//die(var_dump($_POST));
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Emailer</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
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
    <div class="content">
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
            echo "<h4>$result->c_name</h4>";
            echo "<form action='/'> Email: $result->c_email</br>";
            echo "Current Phase <select>";
            for ($i = 1; $i <= $result->num_phase; $i++) {
                if ($i == $result->cur_phase) {
                    echo "<option value ='$i' selected='selected'>$i </option>";
                }
                echo "<option value ='$i'>$i </option>";
            }
            echo "</select></br>";
            //echo "Current Phase: <input type='text' value='$result->cur_phase'></br></br>";
            echo "$daymess : <input type='text' value='$result->est_day_left'></br>";
            echo "Additional Comments:<br><textarea >$result->comments</textarea></br></br>";
            if ($result->delv_content == true) {
                echo "<input type='radio' name='content' checked>Has Deliverd Content
            <input type='radio' name='content'>Waiting on Content</br>";
            } else {
                echo "<input type='radio' name='content' >Has Deliverd Content
            <input type='radio' name='content' checked>Waiting on Content</br>";
            }


            echo "<input type = 'submit'value = 'submit'>
        </form>";
        } else {
            echo "An error has occured";
        }


        ?>
    </div>

</body>

</html>