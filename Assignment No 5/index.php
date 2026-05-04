<?php
require_once 'db.php';

// Check if tables are correctly loaded and db connected.
// Handle Insert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);
    header("Location: index.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE students SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $id]);
    header("Location: index.php");
    exit;
}

// Fetch all students
$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch a student for edit
$editStudent = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $editStudent = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Database</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Student Database Management</h1>
        
        <div class="card">
            <h2><?= $editStudent ? 'Edit Student' : 'Add New Student' ?></h2>
            <form action="index.php" method="POST">
                <input type="hidden" name="action" value="<?= $editStudent ? 'update' : 'create' ?>">
                <?php if ($editStudent): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editStudent['id']) ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Enter student's full name" value="<?= $editStudent ? htmlspecialchars($editStudent['name']) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter student's email address" value="<?= $editStudent ? htmlspecialchars($editStudent['email']) : '' ?>" required>
                </div>
                
                <div class="btn-container">
                    <button type="submit" class="btn"><?= $editStudent ? 'Update Details' : 'Add Student' ?></button>
                    <?php if ($editStudent): ?>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Registered Students</h2>
            <?php if (count($students) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?= htmlspecialchars($student['id']) ?></td>
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <td><?= htmlspecialchars($student['email']) ?></td>
                                <td>
                                    <div class="btn-container">
                                        <a href="index.php?edit=<?= $student['id'] ?>" class="btn btn-small">Edit</a>
                                        <a href="index.php?delete=<?= $student['id'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No students found in the database. Add one using the form above!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
