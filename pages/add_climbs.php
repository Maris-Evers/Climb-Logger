<?php

include_once('../database/connection.php');
session_start();

if (!isset($_SESSION['loggedInUser']) || $_SESSION['loggedInUser'] == false) {
    header('Location: index.php');
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

<script src="../scripts/add_climbs_handler.js" defer></script>

<body>
    <a href="statistics.php">Go back</a>
    <form method="POST">
        <div>
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
        <div>
            <label for="climbinghall">Where did you climb:</label>
            <select name="climbinghall" id="climbinghall" onchange="climbing_wall_handler(this.value)">
                <option value="Zuidhaven" selected>Zuidhaven</option>
                <option value="National Climbing Centre">National Climbing Centre</option>
            </select>
        </div>
        <div>
            <label for="climbingwall">At what wall:</label>
            <select name="climbingwall" id="climbingwall">

            </select>
        </div>
        <div>
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
        <div>
            <p>Flashed:</p>
            <input type="radio" name="flashattempt" id="flash" value="yes" checked>
            <label for="flash">Flash</label>
            <input type="radio" name="flashattempt" id="noflash" value="no">
            <label for="noflash">No Flash</label>
        </div>
        <input type="hidden" name="submitted" value="submitted">
        <input type="submit" value="Submit Climb">
    </form>
</body>