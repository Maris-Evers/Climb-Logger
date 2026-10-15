<?php

include_once('../database/connection.php');
session_start();

if (!isset($_SESSION['loggedInUser']) || $_SESSION['loggedInUser'] == false) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['loggedInUser'];

$sql = "SELECT * FROM climbing_routes WHERE userid = ? ORDER BY grade DESC LIMIT 10;";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user]);
$toptenclimbs = $stmt->fetchall();

$sql = "SELECT grade, flashattempt FROM climbing_routes WHERE userid = ? ORDER BY grade DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user]);
$allclimbs = $stmt->fetchall();
?>

<script type='text/javascript'>
    <?php
    $php_array = $allclimbs;
    $js_array = json_encode($php_array);
    echo "var javascript_array_climbing_grades = " . $js_array . ";\n";
    ?>

    const grades = [];
    const total = [];
    const flashed = [];

    for (const climb of javascript_array_climbing_grades) {
        let i = grades.indexOf(climb.grade);

        if (i === -1) {
            grades.push(climb.grade);
            total.push(0);
            flashed.push(0);
            i = grades.length - 1;
        }

        total[i]++;
        if (climb.flashattempt === "yes") flashed[i]++;
    }
</script>

<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .logout {
        position: absolute;
        top: 5px;
        right: 5px;
    }
</style>

<body>
    <div class="logout">
        <form action="../scripts/logout.php" method="POST">
            <input type="submit" value="Log out" />
        </form>
    </div>
    <div class="container">
        <div style="width: 500px;">
            <canvas id="myChart"></canvas>
        </div>
        <h1>Your Top ten climbs:</h1>
        <table>
            <tr>
                <th>
                    Grade
                </th>
                <th>
                    Flash
                </th>
                <th>
                    Color
                </th>
                <th>
                    What hall
                </th>
                <th>
                    What wall
                </th>
            </tr>
            <?php foreach ($toptenclimbs as $climb) { ?>
                <tr>
                    <td>
                        <?= $climb['grade']; ?>
                    </td>
                    <td>
                        <?= $climb['flashattempt']; ?>
                    </td>
                    <td>
                        <?= $climb['color']; ?>
                    </td>
                    <td>
                        <?= $climb['climbinghall']; ?>
                    </td>
                    <td>
                        <?= $climb['climbingwall']; ?>
                    </td>
                </tr>
            <?php }; ?>
        </table>
        <a href="add_climbs.php">add your climbs</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: grades,
                datasets: [{
                    data: total,
                    backgroundColor: ['rgba(221, 123, 234, 0.6)'],
                    borderColor: ['rgb(194, 41, 250)'],
                    label: 'Total',
                    borderWidth: 1
                }, {
                    data: flashed,
                    backgroundColor: ['rgba(153, 102, 255, 0.6)'],
                    borderColor: ['rgb(111, 41, 250)'],
                    label: 'Flash',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        stacked: false
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    </script>
</body>