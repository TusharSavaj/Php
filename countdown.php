<?php
$showAlert = false;
$showError = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "countdown";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    echo "You are not Connect" . mysqli_connect_error();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $design = $_POST["selectTheme"];

    $sql = "INSERT INTO `countdown` (`title`, `startDate`, `endDate`, `Design`, `dt`) VALUES ('$title', '$startDate', '$endDate', '$design', current_timestamp())";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: countdown.php?success=1");
        exit;
    } else {
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CountDown Timer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: rgb(231, 231, 243);
        display: flex;
        flex-direction: column;
        padding: 70px;
        align-items: center;
        margin-left: 30rem;
        margin-right: 30rem;
        margin-top: -3rem;
    }

    form {
        background: white;
        padding: 20px 30px;
        border-radius: 12px;
        box-shadow: 0 15px 22px rgba(119, 115, 115, 0.1);
        margin-bottom: 20px;
    }

    input[type='date'] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1.2rem;
    }

    .form-select {
        width: 100%;
        margin: auto;
        margin-top: 10px;
    }

    #lableForm {
        margin-bottom: 10px;
        margin-top: 20px;
        font-weight: bold;
        width: 100%;
        background: rgb(223, 217, 217);
        border-radius: 6px;
        text-align: center;
        align-content: center;
        height: 3rem;
    }

    #title {
        width: 100%;
        height: 2.4rem;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    button {
        background: rgb(18, 100, 190);
        color: white;
        margin-top: 10px;
        border-radius: 6px;
        font-weight: bold;
        border: none;
        padding: 10px;
        width: 10rem;
        margin-left: 2rem;
    }

    button:hover {
        background: rgb(36, 128, 200);
    }

    .label {
        display: block;
        margin-top: 10px;
        font-weight: 600;
        text-align: center;
        font-size: 14px;
        color: #777;
    }

    .countdown-container {
        text-align: center;
        background: white;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        width: 100%;
        max-width: 600;
    }

    .countdown {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex: wrap;
        margin-left: 3.9rem;
    }

    .time-box {
        font-size: 28px;
    }

    .Section-title {
        margin-top: 20px;
        color: #555;
    }

    .timerdiv {
        display: flex;
        flex-direction: row;
    }

    .timer {
        font-weight: 600;
    }

    .Default {
        border: 1px solid #777;
        padding: 5px;
        border-bottom: 2px;
        border-top: 2px;
    }

    .Round {
        border: 1px solid #777;
        padding: 5px;
        border-radius: 20px;
    }

    .Square {
        border: 1px solid #777;
        padding: 3px;
    }
</style>

<body>
    <h2 class="text-center">Count Down Timer</h2>
    <form id="dateForm" action="countdown.php" method="post">
        <label id="lableForm" for="title">Enter Your Title</label><br>
        <input type="text" id="title" name="title" placeholder="Enter Your Title" required><br>

        <label id="lableForm" for="startDate">📅 Start Date 📅</label>
        <input type="date" id="startDate" name="startDate" required>

        <label id="lableForm" for="endDate">📅 End Date 📅</label>
        <input type="date" id="endDate" name="endDate" required>

        <label id="lableForm" for="selecttheme">Select Theme</label>
        <select class="form-select" id="selecttheme" name="selectTheme" aria-label="Default select example">
            <option selected>Default</option>
            <option value="Round">Round</option>
            <option value="Square">Square</option>
        </select>
        <button type="submit">Start</button>
        <button type="button" id="resetBtn">Reset</button>
    </form>
    <div>
        <?php
        $sql = "SELECT title, startDate, endDate, Design FROM countdown ORDER BY dt DESC";
        $result = mysqli_query($conn, $sql);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        $sno = 0;
        foreach ($data as $row) {
            $sno++;
            echo "
    <div class='countdown-container' id='countdownSection'>
        <strong>Your SrNo is: $sno<br>Your Title is: {$row['title']}<br>Start Date: {$row['startDate']}<br>Your End Date: {$row['endDate']}<br>Your Design is: {$row['Design']}</strong><br>

        <h3 class='Section-title'>⏱️Time Start</h3><br>
        <div class='timerdiv' id='countdownstart'><br>
            <div class='countdown' id='count'>
                <div class='time-box {$row['Design']}'>
                    <div id='c-days$sno' class='timer'>0</div>
                    <div class='label'>Days</div>
                </div>
                <div class='time-box {$row['Design']}'>
                    <div id='c-hours$sno' class='timer'>0</div>
                    <div class='label'>Hours</div>
                </div>
                <div class='time-box {$row['Design']}'>
                    <div id='c-minutes$sno' class='timer'>0</div>
                    <div class='label'>Minutes</div>
                </div>
                <div class='time-box {$row['Design']}'>
                    <div id='c-seconds$sno' class='timer'>0</div>
                    <div class='label'>Seconds</div>
                </div>
            </div>
        </div>
    </div>";
        }
        ?>
    </div>
    <script>
        <?php
        $sno = 0;
        foreach ($data as $row) {
            $sno++;
            $startTime = date('Y-m-d\TH:i:s', strtotime($row['startDate']));
            $endTime = date('Y-m-d\TH:i:s', strtotime($row['endDate']));

            echo "
    const startTime$sno = new Date('$startTime').getTime();
    const endTime$sno = new Date('$endTime').getTime();

    function pad(num) {
        return String(num).padStart(2, '0');
    }

    function updateCountdown$sno() {
        const now = new Date().getTime();
        const diff = endTime$sno - now;

        if (diff <= 0) {
            clearInterval(interval$sno);
            document.getElementById('c-days$sno').innerText = '00';
            document.getElementById('c-hours$sno').innerText = '00';
            document.getElementById('c-minutes$sno').innerText = '00';
            document.getElementById('c-seconds$sno').innerText = '00';
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById('c-days$sno').innerText = pad(days);
        document.getElementById('c-hours$sno').innerText = pad(hours);
        document.getElementById('c-minutes$sno').innerText = pad(minutes);
        document.getElementById('c-seconds$sno').innerText = pad(seconds);
    }

    const interval$sno = setInterval(updateCountdown$sno, 1000);
    updateCountdown$sno();
    ";
        }
        ?>
    </script>

    <script>
        document.getElementById("dateForm").addEventListener("submit", function(e) {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            let today = new Date();

            if (startDate >= endDate) {
                alert("Start date must be before end date!");
                return;
            }
            if (today < startDate) {
                alert("⏳ Timer will start after the Start Date.");

                return;
            }
        });
        document.getElementById("resetBtn").addEventListener("click", function() {
            document.getElementById("dateForm").reset();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
        crossorigin="anonymous"></script>
</body>

</html>