<?php

$weather = "";
$error = "";

if (array_key_exists('city', $_GET)) {

    $city = str_replace(' ', '', $_GET['city']);
    $file_headers = @get_headers("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");
    if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $error = "That city could not be found.";
    } else {

        $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");
        $pageArray = explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);

        if (sizeof($pageArray) > 1) {

            $secondPageArray = explode('</span></p></td>', $pageArray[1]);

            if (sizeof($secondPageArray) > 1) {
                $weather = $secondPageArray[0];
            } else {
                $error = "That city could not be found.";
            }
        } else {
            $error = "That city could not be found.";
        }
    }
}
?>

<!Doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Weather Scrapper!</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


    <style type="text/css">
        html {
            background: url(https://images.unsplash.com/photo-1496858705185-1f25b056e4a7?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        body {
            background: none;
        }

        .container {
            text-align: center;
            margin-top: 150px;
            width: 450px;
            color: white;
        }

        input {
            margin: 20px 0;
            ;
        }

        #weather {
            margin-top: 15px;

        }
    </style>
</head>

<body>

    <div class="container">
        <h1>What's The Weather?</h1>
        <form>
            <fieldset class="mb-3">
                <label for="city" class="form-label">Enter the name of a city</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="London,Lucknow" value="<?php

                                                                                                                    if (array_key_exists('city', $_GET)) {

                                                                                                                        echo $_GET['city'];
                                                                                                                    }
                                                                                                                    ?>">
            </fieldset>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div id="weather">
            <?php

            if ($weather) {

                echo '<div class="alert alert-success" role="alert">' . $weather . '</div>';
            } else if ($error) {

                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }




            ?>

        </div>

    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script type="text/javascript" src="jquery-3.5.1.min.js"></script>

</body>

</html>