<?php
include "connection.php";
$query = 'SELECT * FROM coffee ORDER BY date_time desc';
$result = $conn->query($query);
$row = $result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <title>Modern Coffee</title>
</head>

<body>
    <h1 style="text-align: center;">Modern Coffee</h1> <br>
    
    <div class="info-holder">
        <div class="indicator" style="display: inline;">
            <i class="bi bi-thermometer-half"></i>
            <span> <?php echo $row['temperature'] ?> °C</span>
        </div>
        <br>
        <div class="indicator" style="display: inline;">
            <i class="bi bi-cup"></i>
            <span><?php echo $row['volume'] ?> cL</span>
        </div>
    </div>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <footer class="navbar-elements">
        <a class="navbar-element-active">
            <i class="bi bi-house-fill"></i>
        </a>
        <a href="stats.php" class="navbar-element">
            <i class="bi bi-pie-chart"></i>
        </a>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
<?php

?>