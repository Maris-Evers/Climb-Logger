<?php

include_once('../database/connection.php');
session_start();

if (!isset($_SESSION['loggedInUser']) || $_SESSION['loggedInUser'] == false) {
    header('Location: index.html');
    exit;
}

if (isset($_POST['submitted'])) {
    $grade = $_POST['grade'];
    $climbinghall = $_POST['climbinghall'];
    $climbingwall = $_POST['climbingwall'];
    $color = $_POST['color'];
    $flash = $_POST['flashattempt'];
    $user_id = $_SESSION['loggedInUser'];

    $sql = "INSERT INTO climbing_routes (`userid`, `grade`, `climbinghall`, `climbingwall`, `color`, `flashattempt`)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $grade, $climbinghall, $climbingwall, $color, $flash]);

    unset($_POST['submitted']);
}



?>

<style>
    .flash p {
        margin-bottom: 0px;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add climbs</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<script src="../scripts/add_climbs_handler.js" defer></script>

<body class="bg-dark text-light">
    <div class="container text-center position-absolute top-50 start-50 translate-middle">
    <a href="statistics.php">Go back</a>
    <form method="POST">
        <div class="py-2">
            <label for="grade">The grade of the climb:</label>
            <select id="grade" name="grade">
                <option value="2+">2+</option>
                <option value="3a">3a</option>
                <option value="3b">3b</option>
                <option value="3c">3c</option>
                <option value="4a">4a</option>
                <option value="4b">4b</option>
                <option value="4c">4c</option>
                <option value="5a">5a</option>
                <option value="5a+">5a+</option>
                <option value="5b">5b</option>
                <option value="5b+">5b+</option>
                <option value="5c">5c</option>
                <option value="5c+">5c+</option>
                <option value="6a">6a</option>
                <option value="6a+">6a+</option>
                <option value="6b">6b</option>
                <option value="6b+">6b+</option>
                <option value="6c">6c</option>
                <option value="6c+">6c+</option>
                <option value="7a">7a</option>
                <option value="7a+">7a+</option>
                <option value="7b">7b</option>
                <option value="7b+">7b+</option>
                <option value="7c">7c</option>
                <option value="7c+">7c+</option>
                <option value="8a">8a</option>
                <option value="8a+">8a+</option>
                <option value="8b">8b</option>
                <option value="8b+">8b+</option>
                <option value="8c">8c</option>
                <option value="8c+">8c+</option>
            </select> 
        </div>
        <div class="py-2">
            <label for="climbinghall">Where did you climb:</label>
            <select name="climbinghall" id="climbinghall" onchange="climbing_wall_handler(this.value)">
                <option value="Zuidhaven" selected>Zuidhaven</option>
                <option value="National Climbing Centre">National Climbing Centre</option>
            </select>
        </div>
        <div class="py-2">
            <label for="climbingwall">At what wall:</label>
            <select name="climbingwall" id="climbingwall">

            </select>
        </div>
        <div class="py-2">
            <label for="color">The color of the climb:</label>
            <select name="color" id="color">
                <option value="blue">blue</option>
                <option value="purple">purple</option>
                <option value="red">red</option>
                <option value="black">black</option>
                <option value="white">white</option>
                <option value="orange">orange</option>
                <option value="yellow">yellow</option>
                <option value="mint">mint</option>
                <option value="green">green</option>
                <option value="pink">pink</option>
            </select>
        </div>
        <div class="py-2 flash">
            <p>Flashed:</p>
            <input type="radio" name="flashattempt" id="flash" value="yes" checked>
            <label for="flash">Flash</label>
            <input type="radio" name="flashattempt" id="noflash" value="no">
            <label for="noflash">No Flash</label>
        </div>
        <input type="hidden" name="submitted" value="submitted">
        <input type="submit" value="Submit Climb">
    </form>
    </div>
</body>
</html>