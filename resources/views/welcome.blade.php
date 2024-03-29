<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" value="{{ csrf_token() }}">

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
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))

        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
        <?php //$update = EmailerController::Update($_POST['clientdata']);
        //echo $update;
            ?>
            <div class="title m-b-md">
                Emailer Tool
            </div>

            <div>
                <h3>Who do you want to update?<h3>
                        <!--<a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                -->
                        <form action="/client" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            

                            Who do you want to edit?

                            <select name="formCustomer">
                                <?php
                               use App\Http\Controllers\EmailerController;
                                $results = EmailerController::Fetch('customer');
                                //DB::select("select * from customer");
                                //var_dump($results);
                                echo "<option value='' >Select... </option></br>";
                                foreach ($results as &$result) {
                                    $name = $result->c_name;
                                    echo "<option value ='$name'>$name </option>";
                                }
                                ?>
                            </select>
                            
                            <input type="submit" value="submit"><br>
                            <input type= "button" value = "Preview Email Template" onclick = "location.href = '/template'">
                        </form>



            </div>
        </div>
    </div>
</body>

</html>