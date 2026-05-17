<?php
// PHP Developer — Group B

$scores_file = "scores.txt";
$name  = "";
$score = "";

// ── RECEIVE AND SAVE POST DATA ──────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST["player_name"] ?? "");
    $score = trim($_POST["score"] ?? "");

    if (!empty($name) && $score !== "") {
        $line = htmlspecialchars($name) . " | " . htmlspecialchars($score) . "/10\n";
        file_put_contents($scores_file, $line, FILE_APPEND);
    }
}

// ── READ ALL SAVED SCORES ───────────────────────────
$entries = [];
if (file_exists($scores_file)) {
    $entries = file($scores_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// ── SCORE MESSAGE ───────────────────────────────────
$s = intval($score);
if ($s >= 8)      $msg = "Excellent! 🏆";
elseif ($s >= 5)  $msg = "Good job! 👍";
else              $msg = "Keep practising! 📚";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results & Scores Board</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Result banner */
        .result-banner {
            background: linear-gradient(135deg, #1e88e5, #1a237e);
            color: white;
            text-align: center;
            padding: 36px 20px;
            border-radius: 12px;
            margin: 30px auto;
            max-width: 500px;
            box-shadow: 0 6px 20px rgba(30,136,229,0.3);
        }
        .result-banner .result-name {
            font-size: 1.2rem;
            margin-bottom: 8px;
            opacity: 0.9;
        }
        .result-banner .result-score {
            font-size: 5rem;
            font-weight: bold;
            line-height: 1;
            margin: 10px 0;
        }
        .result-banner .result-score span {
            font-size: 1.8rem;
            opacity: 0.8;
        }
        .result-banner .result-msg {
            font-size: 1.4rem;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Scores table */
        .scores-wrapper {
            max-width: 600px;
            margin: 40px auto;
        }
        .scores-wrapper h2 {
            color: #1a237e;
            border-bottom: 3px solid #42a5f5;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        th {
            background: linear-gradient(135deg, #42a5f5, #1e88e5);
            color: white;
            padding: 12px 16px;
            text-align: left;
            font-size: 1rem;
        }
        td {
            padding: 11px 16px;
            border-bottom: 1px solid #eee;
            font-size: 0.95rem;
            color: #333;
        }
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) td { background-color: #f7fafd; }
        .no-scores {
            text-align: center;
            color: #888;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            border: 2px dashed #ccc;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            background: linear-gradient(135deg, #43a047, #2e7d32);
            color: white;
            padding: 12px 30px;
            border-radius: 100px;
            text-decoration: none;
            font-weight: bold;
            transition: opacity 0.3s;
        }
        .back-btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <h1>TECH QUIZ</h1>

    <!-- ── YOUR RESULT (shows only after submitting) ── -->
    <?php if (!empty($name)): ?>
    <div class="result-banner">
        <p class="result-name">Well done, <?= htmlspecialchars($name) ?>!</p>
        <div class="result-score"><?= $s ?><span> / 10</span></div>
        <p class="result-msg"><?= $msg ?></p>
    </div>
    <?php endif; ?>

    <!-- ── SCORES BOARD ── -->
    <div class="scores-wrapper">
        <h2>📋 Scores Board</h2>

        <?php if (empty($entries)): ?>
            <div class="no-scores">No scores yet. Be the first to play!</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Player Name</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entries as $index => $entry): ?>
                        <?php
                            $parts  = explode(" | ", $entry, 2);
                            $player = $parts[0] ?? "Unknown";
                            $result = $parts[1] ?? "?/10";
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($player) ?></td>
                            <td><?= htmlspecialchars($result) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <br>
        <a href="index.html" class="back-btn">🔄 Play Again</a>
    </div>
</body>
</html>
