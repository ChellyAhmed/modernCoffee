<?php
//Connect to DB
include "connection.php";

//Get an array of all the entries from the last 7 days
$query = 'SELECT * FROM coffee WHERE date_time >= now() - interval 7 day ORDER BY date_time asc';
$result = $conn->query($query) or die($conn->error);
$row = $result->fetch_all();

//Get an array $volumes containing the values of the total coffee consumed.
$last = $row[0][2];
$volumes = array($last);
for ($i = 1; $i < sizeof($row); $i++) {
    if ($row[$i][2] > $last) {
        array_push($volumes, $row[$i][2] - $last);
    }
    $last = $row[$i][2];
}

//Get the total volume of consumed coffee
$total = 0;
foreach ($volumes as $key => $volume) {
    $total += $volume;
}

//Get the weekly volume of consumed coffee.
$weekly = $total / 7;


//Get average temp, elapsed time and speed
$query = 'SELECT * FROM coffee WHERE date_time >= now() - interval 7 day ORDER BY date_time desc';
$result = $conn->query($query) or die($conn->error);
$row = $result->fetch_all();
$indexOfEmptyCup = array();
$averageTemperatures = array(); //Contains average temperature of koll ta3beyya
$times = array(); //Contains time elapsed of koll ta3beyya
$speeds = array();

//Get when cup is empty
for ($i = 0; $i < sizeof($row); $i++) {
    if ($row[$i][2] <= 5) {
        if ($i == sizeof($row) - 1 || $row[$i + 1][2] > 5) {
            array_push($indexOfEmptyCup, $i);
        }
    }
}
for ($i = 0; $i < sizeof($indexOfEmptyCup) - 1; $i++) {
    array_push($averageTemperatures, ($row[$indexOfEmptyCup[$i]][1] + $row[$indexOfEmptyCup[$i + 1] - 1][1]) / 2);
    $time_elapsed = date_create($row[$indexOfEmptyCup[$i]][3])->diff(date_create($row[$indexOfEmptyCup[$i + 1] - 1][3])); //Get the difference
    $time_elapsed = ($time_elapsed->d * 24 + $time_elapsed->h) * 60 + ($time_elapsed->i); //Convert the difference to a single unit (minutes)
    array_push($times, $time_elapsed);
    $speed = ($row[$indexOfEmptyCup[$i + 1] - 1][2] - $row[$indexOfEmptyCup[$i]][2]) / $time_elapsed;
    array_push($speeds, $speed);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <title>Modern Coffee - Overall Consumption Stats</title>
</head>

<body>
    <h1 style="text-align: center;">Overall Consumption Statistics</h1> <br>


    <div style="padding: 10px;">
        <h5 style="text-align: center;">in the past 7 days:</h5>
        <h6>Total volume of consumed coffee:</h6>
        <span><?php
                try {
                    echo $total . "cL"; ?>
            <?php } catch (Throwable $th) {
                    echo "Not enough data to measure statistics.";
                } ?></span>
        <br>
        <br>
        <h6>Average daily volume of consumed coffee:</h6>
        <span><?php
                try {
                    echo round($weekly, 2, PHP_ROUND_HALF_UP) . "cL"; ?>
            <?php } catch (Throwable $th) {
                    echo "Not enough data to measure statistics.";
                } ?></span>
        <br>
        <br>
        <h6>Average time to finish coffee:</h6>
        <span><?php
                try {
                    echo round(array_sum($times) / count($times), 2, PHP_ROUND_HALF_UP) . "minutes"; ?>
            <?php } catch (Throwable $th) {
                    echo "Not enough data to measure statistics.";
                } ?></span>
        <br>
        <br>
        <h6>Average temperature of coffee:</h6>
        <span><?php
                try {
                    echo round(array_sum($averageTemperatures) / count($averageTemperatures), 2, PHP_ROUND_HALF_UP) . "°C"; ?>
            <?php } catch (Throwable $th) {
                    echo "Not enough data to measure statistics.";
                } ?></span>
        <br>
        <br>
        <h6>Drinking speed:</h6>
        <span><?php
                try {
                    echo round(array_sum($speeds) / count($speeds), 2, PHP_ROUND_HALF_UP) . "cL/min"; ?>
            <?php } catch (Throwable $th) {
                    echo "Not enough data to measure statistics.";
                } ?></span>
    </div>





    <footer class="navbar-elements">
        <a href="index.php" class="navbar-element">
            <i class="bi bi-house"></i>
        </a>
        <a class="navbar-element-active">
            <i class="bi bi-pie-chart-fill"></i>
        </a>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>