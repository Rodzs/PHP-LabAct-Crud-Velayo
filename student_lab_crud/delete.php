<?php
require_once 'db_connect.php';
session_start();

$message = '';
$student = null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: select.php');
    exit();
}

try {
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $student = $stmt->fetch();
    
    if (!$student) {
        $_SESSION['error'] = "Student not found.";
        header('Location: select.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header('Location: select.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        $_SESSION['success'] = "Student deleted successfully.";
        header('Location: select.php');
        exit();
        
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Student CRUD</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="select.php">View Students</a>
                <a class="nav-link" href="insert.php">Add Student</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Delete Student</h2>

        <?php if ($message): ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($student): ?>
            <div class="alert alert-warning">
                <strong>Warning:</strong> You are about to delete this student record permanently.
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5>Student Information</h5>
                    <p><strong>ID:</strong> <?php echo $student['id']; ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                    <p><strong>Age:</strong> <?php echo $student['age']; ?></p>
                    <p><strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?></p>
                </div>
            </div>

            <form method="POST">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmCheckbox" required>
                        <label class="form-check-label" for="confirmCheckbox">
                            I understand this will permanently delete the student record
                        </label>
                    </div>
                </div>
                <button type="submit" name="confirm_delete" class="btn btn-danger">Delete Student</button>
                <a href="select.php" class="btn btn-secondary">Cancel</a>
                <a href="update.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">Edit Instead</a>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>