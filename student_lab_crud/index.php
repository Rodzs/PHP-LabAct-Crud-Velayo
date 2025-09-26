<?php
require_once 'db_connect.php';
session_start();

$message = '';
if (isset($_SESSION['success'])) {
    $message = $_SESSION['success'];
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
    unset($_SESSION['error']);
}

try {
    $total_stmt = $pdo->query("SELECT COUNT(*) FROM students");
    $total_students = $total_stmt->fetchColumn();
    
    $latest_stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC LIMIT 3");
    $latest_students = $latest_stmt->fetchAll();
} catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Student CRUD</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="index.php">Home</a>
                <a class="nav-link" href="select.php">View Students</a>
                <a class="nav-link" href="insert.php">Add Student</a>
            </div>
        </div>
    </nav>

    <div class="bg-primary text-white py-5">
        <div class="container text-center">
            <h1>Student Management System</h1>
            <p class="lead">PHP + MySQL CRUD Application</p>
            <a href="select.php" class="btn btn-light me-2">View All Students</a>
            <a href="insert.php" class="btn btn-outline-light">Add New Student</a>
        </div>
    </div>

    <div class="container mt-5">
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h2><?php echo number_format($total_students ?? 0); ?></h2>
                        <p>Total Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Recent Students</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($latest_students)): ?>
                            <?php foreach ($latest_students as $student): ?>
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <div>
                                        <strong><?php echo htmlspecialchars($student['name']); ?></strong><br>
                                        <small><?php echo htmlspecialchars($student['course']); ?></small>
                                    </div>
                                    <small><?php echo date('M j', strtotime($student['created_at'])); ?></small>
                                </div>
                            <?php endforeach; ?>
                            <div class="text-center mt-3">
                                <a href="select.php" class="btn btn-primary">View All Students</a>
                            </div>
                        <?php else: ?>
                            <p class="text-center">No students yet.</p>
                            <div class="text-center">
                                <a href="insert.php" class="btn btn-primary">Add First Student</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>