<?php
// src/index.php
require_once 'vendor/autoload.php';
require_once 'db.php';
session_start();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

function categorizeTask($urgency, $importance) {
    if ($urgency && $importance) return 'Do First';
    if (!$urgency && $importance) return 'Schedule';
    if ($urgency && !$importance) return 'Delegate';
    return 'Eliminate';
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($request->getMethod() === 'POST') {
    $title = $request->request->get('title');
    $urgency = $request->request->get('urgency') === '1';
    $importance = $request->request->get('importance') === '1';
    $category = categorizeTask($urgency, $importance);

    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, urgency, importance, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $urgency, $importance, $category]);
    header('Location: index.php');
    exit();
} else {
    $stmt = $pdo->prepare("SELECT id, title, category FROM tasks WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $tasks = $stmt->fetchAll();
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eisenhower Matrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(-45deg, #1e3c72, #2a5298, #6dd5ed, #2193b0);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            color: #fff;
        }

        @keyframes gradientMove {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        .container {
            padding-top: 40px;
        }

        .matrix {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 20px;
            margin-top: 30px;
        }

        .quadrant {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            min-height: 200px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .quadrant h2 {
            font-size: 1.25rem;
            margin-bottom: 15px;
            color: #fff;
        }

        .task {
            background-color: #ffffffcc;
            color: #333;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: move;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .task a {
            float: right;
            color: red;
            text-decoration: none;
        }

        .task a:hover {
            text-decoration: underline;
        }

        form input[type="text"] {
            margin-bottom: 10px;
        }

        .form-inline label {
            margin-right: 10px;
            color: #fff;
        }

        .form-inline .form-check-input {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Eisenhower Matrix</h1>
    <div class="text-end mb-3">
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
    <form method="post" class="form-inline mb-4 d-flex gap-2 flex-wrap">
        <input type="text" name="title" class="form-control flex-grow-1" placeholder="Task Title" required>
        <div class="form-check form-check-inline">
            <input type="checkbox" name="urgency" value="1" class="form-check-input" id="urgentCheck">
            <label class="form-check-label" for="urgentCheck">Urgent</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="checkbox" name="importance" value="1" class="form-check-input" id="importantCheck">
            <label class="form-check-label" for="importantCheck">Important</label>
        </div>
        <button type="submit" class="btn btn-light">Add Task</button>
    </form>

    <div class="matrix">
        <?php
        $categories = ['Do First', 'Schedule', 'Delegate', 'Eliminate'];
        foreach ($categories as $cat) {
            echo "<div class='quadrant' data-category='$cat'><h2>$cat</h2>";
            foreach ($tasks as $task) {
                if ($task['category'] === $cat) {
                    echo "<div class='task' draggable='true' data-id='{$task['id']}'>" .
                         htmlspecialchars($task['title']) .
                         " <a href='delete.php?id={$task['id']}' onclick=\"return confirm('Delete this task?')\">✕</a></div>";
                }
            }
            echo "</div>";
        }
        ?>
    </div>
</div>

<script>
    document.querySelectorAll('.task').forEach(task => {
        task.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', task.dataset.id);
        });
    });

    document.querySelectorAll('.quadrant').forEach(quadrant => {
        quadrant.addEventListener('dragover', e => e.preventDefault());
        quadrant.addEventListener('drop', e => {
            e.preventDefault();
            const taskId = e.dataTransfer.getData('text/plain');
            const category = quadrant.dataset.category;
            fetch('move.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${taskId}&category=${encodeURIComponent(category)}`
            }).then(() => location.reload());
        });
    });
</script>
</body>
</html>

    <?php
    $html = ob_get_clean();
    $response = new Response($html);
    $response->send();
}
