<?php
// Check if user is logged in
require_once '../includes/auth.php';
protectPage();

// Connect to database
require_once '../includes/config.php';

// Initialize message variable
$message = '';

// Handle project deletion
if (isset($_GET['delete'])) {
    $project_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    if ($stmt->execute([$project_id])) {
        // Redirect to prevent re-deletion on refresh
        header("Location: index.php?msg=deleted");
        exit();
    } else {
        $message = "Error deleting project!";
    }
}

// Handle success messages from redirects
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'added':
            $message = "Project added successfully!";
            break;
        case 'updated':
            $message = "Project updated successfully!";
            break;
        case 'deleted':
            $message = "Project deleted successfully!";
            break;
    }
}

// Get projects from database
$projects_stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $projects_stmt->fetchAll();

// Get messages from database
$messages_stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $messages_stmt->fetchAll();

// Handle project form (for both add and edit)
$edit_mode = false;
$project_id = '';
$title = $description = $image_url = $project_url = '';

// Check if editing a project
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $project_id = $_GET['edit'];

    // Get project data
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
    $project = $stmt->fetch();

    if ($project) {
        $title = $project['title'];
        $description = $project['description'];
        $image_url = $project['image_url'];
        $project_url = $project['project_url'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $project_url = trim($_POST['project_url']);
    $image_url = trim($_POST['image_filename']);
    $edit_mode = isset($_POST['edit_mode']) && $_POST['edit_mode'] == '1';
    $project_id = isset($_POST['project_id']) ? $_POST['project_id'] : '';

    // Validate required fields
    if (empty($title) || empty($description)) {
        $message = "Title and description are required!";
    } else {
        // Save to database
        try {
            if ($edit_mode && !empty($project_id)) {
                // Update existing project
                $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, image_url=?, project_url=? WHERE id=?");
                $success = $stmt->execute([$title, $description, $image_url, $project_url, $project_id]);
                if ($success) {
                    // Redirect to prevent re-submission on refresh
                    header("Location: index.php?msg=updated");
                    exit();
                } else {
                    $message = "Error updating project!";
                }
            } else {
                // Insert new project
                $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_url, project_url) VALUES (?, ?, ?, ?)");
                $success = $stmt->execute([$title, $description, $image_url, $project_url]);
                if ($success) {
                    // Redirect to prevent re-submission on refresh
                    header("Location: index.php?msg=added");
                    exit();
                } else {
                    $message = "Error adding project!";
                }
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.4;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .header h1 {
            margin-bottom: 5px;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .section {
            background: white;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section-header {
            background: #3498db;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .section-content {
            padding: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            padding: 4px 8px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
            margin-right: 3px;
            display: inline-block;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .form-table {
            width: 100%;
        }

        .form-table td {
            padding: 10px;
            border: none;
        }

        .form-table label {
            font-weight: bold;
            color: #2c3e50;
        }

        .form-table input,
        .form-table textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }

        .form-table textarea {
            height: 80px;
            resize: vertical;
        }

        .submit-btn {
            background: #2ecc71;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .cancel-btn {
            background: #95a5a6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            margin-left: 10px;
            font-size: 14px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 3px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .project-image {
            max-width: 60px;
            max-height: 60px;
            border-radius: 3px;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 2px;
            border-radius: 3px;
            display: none;
        }

        .note {
            color: #666;
            font-size: 12px;
            font-style: italic;
            margin-bottom: 5px;
        }

        .no-data {
            text-align: center;
            color: #666;
            padding: 20px;
            font-style: italic;
        }

        /* Auto-expanding text cells */
        .expandable-text {
            word-wrap: break-word;
            white-space: pre-wrap;
            max-width: 300px;
            line-height: 1.4;
        }

        .message-cell {
            min-width: 200px;
            max-width: 400px;
        }

        .description-cell {
            min-width: 200px;
            max-width: 350px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['username']; ?>! | <a href="logout.php" style="color: white;">Logout</a></p>
    </div>

    <div class="container">
        <!-- Show message if exists -->
        <?php if (!empty($message)): ?>
            <div class="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Projects Section -->
        <div class="section">
            <div class="section-header">Projects</div>
            <div class="section-content">
                <?php if (count($projects) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>URL</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($project['image_url'])): ?>
                                            <img src="../uploads/<?php echo htmlspecialchars($project['image_url']); ?>"
                                                alt="<?php echo htmlspecialchars($project['title']); ?>"
                                                class="project-image">
                                        <?php else: ?>
                                            <div style="width: 60px; height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #666;">No Image</div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($project['title']); ?></td>
                                    <td class="description-cell">
                                        <div class="expandable-text"><?php echo htmlspecialchars($project['description']); ?></div>
                                    </td>
                                    <td>
                                        <?php if (!empty($project['project_url'])): ?>
                                            <a href="<?php echo htmlspecialchars($project['project_url']); ?>" target="_blank" style="color: #3498db;">View</a>
                                        <?php else: ?>
                                            <span style="color: #999;">No URL</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?edit=<?php echo $project['id']; ?>" class="btn btn-edit">Edit</a>
                                        <a href="?delete=<?php echo $project['id']; ?>" class="btn btn-delete"
                                            onclick="return confirm('Are you sure you want to delete this project?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No projects found. Add your first project below.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Project Form Section -->
        <div class="section">
            <div class="section-header"><?php echo $edit_mode ? 'Edit Project' : 'Add New Project'; ?></div>
            <div class="section-content">
                <form method="POST">
                    <input type="hidden" name="edit_mode" value="<?php echo $edit_mode ? '1' : '0'; ?>">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">

                    <table class="form-table">
                        <tr>
                            <td style="width: 120px;"><label for="title">Project Title:</label></td>
                            <td><input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="description">Description:</label></td>
                            <td><textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="project_url">Project URL:</label></td>
                            <td><input type="url" id="project_url" name="project_url" value="<?php echo htmlspecialchars($project_url); ?>" placeholder="https://example.com"></td>
                        </tr>
                        <tr>
                            <td><label for="image_filename">Image:</label></td>
                            <td>
                                <div class="note">Upload image to 'uploads' folder first, then enter filename only</div>
                                <input type="text" id="image_filename" name="image_filename"
                                    value="<?php echo htmlspecialchars($image_url); ?>"
                                    placeholder="filename.png" onchange="updatePreview()">
                                <img id="imagePreview" class="image-preview" src="" alt="Image preview">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="submit-btn"><?php echo $edit_mode ? 'Update Project' : 'Add Project'; ?></button>
                                <?php if ($edit_mode): ?>
                                    <a href="index.php" class="cancel-btn">Cancel</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <!-- Messages Section -->
        <div class="section">
            <div class="section-header">Messages</div>
            <div class="section-content">
                <?php if (count($messages) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                    <td class="message-cell">
                                        <div class="expandable-text"><?php echo htmlspecialchars($msg['message']); ?></div>
                                    </td>
                                    <td><?php echo date('M j, Y g:i A', strtotime($msg['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No messages found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function updatePreview() {
            const input = document.getElementById('image_filename');
            const preview = document.getElementById('imagePreview');

            if (input.value.trim()) {
                preview.src = '../uploads/' + input.value.trim();
                preview.style.display = 'block';
                preview.onerror = function() {
                    this.style.display = 'none';
                }
            } else {
                preview.style.display = 'none';
            }
        }

        <?php if ($edit_mode && !empty($image_url)): ?>
            updatePreview();
        <?php endif; ?>

        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000);
    </script>
</body>

</html>