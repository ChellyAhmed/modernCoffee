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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <title>Modern Coffee</title>
</head>

<body>
    <img class="beans-top" src="beans.png" alt="Coffee beans for background">
    <h1 style="text-align: center;">Modern Coffee</h1> <br>

    <div class="info-holder">
        <div class="indicator" style="display: inline;">
            <i class="bi bi-thermometer-half"></i>
            <span> <?php echo $row['temperature'] ?> °C</span>
        </div>
        <br>
        <div class="indicator" style="display: inline;">
            <i class="bi bi-cup"></i>
            <span><?php echo round($row['volume'], 2, PHP_ROUND_HALF_UP) ?> cL</span>
        </div>
        <br>
        <br>
        <div class="suggestion">
            <img src="croissant.jpg" alt="suggestion-pic" style="text-align: center;"><br>
            <span style="font-size: x-small;">We suggest that you have a delicious french croissant along with your coffee.<br />Chahia Taïba!</span>
        </div>
    </div>




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <footer class="navbar-elements">
        <a class="navbar-element-active">
            <i class="bi bi-house-fill"></i>
        </a>
        <div class="line"> </div>
        <a href="stats.php" class="navbar-element">
            <i class="bi bi-pie-chart"></i>
        </a>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>



    <script>
        function notifyMe() {
            if (!window.Notification) {
                console.log('Browser does not support notifications.');
            } else {
                // check if permission is already granted
                if (Notification.permission === 'granted') {
                    // show notification here
                    var notify = new Notification('Your coffee is getting cold!', {
                        body: 'Hi there! Do not forget to drink your coffee. It is getting cold!',
                        icon: './beans.png',
                    });
                } else {
                    // request permission from user
                    Notification.requestPermission().then(function(p) {
                        if (p === 'granted') {
                            // show notification here
                            var notify = new Notification('Your coffee is getting cold!', {
                                body: 'Hi there! Do not forget to drink your coffee. It is getting cold!',
                                icon: './beans.png',
                            });
                        } else {
                            console.log('User blocked notifications.');
                        }
                    }).catch(function(err) {
                        console.error(err);
                    });
                }
            }
        }

        if ( <?php echo $row['temperature'] ; ?> < 10) {
            notifyMe();
        }
    </script>


</body>

</html>
<?php

?>