<?php
require_once 'db_connect.php';

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
        header('Location: select.php');
        exit();
    }
} catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $age = (int)$_POST['age'];
    $course = trim($_POST['course']);
    
    if (empty($name) || empty($email) || empty($course) || $age < 16 || $age > 100) {
        $message = "Please fill all fields correctly.";
    } else {
        try {
            $sql = "UPDATE students SET name = ?, email = ?, age = ?, course = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $email, $age, $course, $id]);
            $message = "Student updated successfully!";
            $student['name'] = $name;
            $student['email'] = $email;
            $student['age'] = $age;
            $student['course'] = $course;
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
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
        <h2>Update Student</h2>

        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($student): ?>
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" name="age" min="16" max="100" value="<?php echo $student['age']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="course" class="form-label">Course</label>
                        <select class="form-select" name="course" required>
                            <option value="">Select Course</option>
                            <option value="Computer Science" <?php echo ($student['course'] === 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="Information Technology" <?php echo ($student['course'] === 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
                            <option value="Engineering" <?php echo ($student['course'] === 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                            <option value="Business Administration" <?php echo ($student['course'] === 'Business Administration') ? 'selected' : ''; ?>>Business Administration</option>
                            <option value="Mathematics" <?php echo ($student['course'] === 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning">Update Student</button>
                <a href="select.php" class="btn btn-secondary">Cancel</a>
                <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-danger">Delete</a>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>