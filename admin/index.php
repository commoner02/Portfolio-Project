<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
protectPage();

$message = '';
$message_type = '';
$editProject = null;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message'], $_SESSION['message_type']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['add_project'])) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $project_url = trim($_POST['project_url']);
        $image_filename = trim($_POST['image_filename']);

        if (empty($title) || empty($description) || empty($project_url) || empty($image_filename)) {
            $_SESSION['message'] = 'All fields are required.';
            $_SESSION['message_type'] = 'error';
        } elseif (!file_exists('../uploads/' . $image_filename)) {
            $_SESSION['message'] = 'Image file not found. Please upload first.';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $pdo->prepare("INSERT INTO projects (title, description, project_url, image_url) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$title, $description, $project_url, $image_filename])) {
                $_SESSION['message'] = 'Project added successfully!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error adding project.';
                $_SESSION['message_type'] = 'error';
            }
        }
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['edit_project'])) {
        $id = $_POST['project_id'];
        $title = trim($_POST['edit_title']);
        $description = trim($_POST['edit_description']);
        $project_url = trim($_POST['edit_project_url']);
        $new_image = trim($_POST['edit_image_filename']);

        if (empty($title) || empty($description) || empty($project_url)) {
            $_SESSION['message'] = 'Title, description and URL are required.';
            $_SESSION['message_type'] = 'error';
        } else {
            if (!empty($new_image)) {
                if (!file_exists('../uploads/' . $new_image)) {
                    $_SESSION['message'] = 'New image file not found.';
                    $_SESSION['message_type'] = 'error';
                    header("Location: index.php");
                    exit();
                }
                $old = $pdo->prepare("SELECT image_url FROM projects WHERE id = ?");
                $old->execute([$id]);
                $oldImg = $old->fetchColumn();
                if ($oldImg && file_exists('../uploads/' . $oldImg)) {
                    unlink('../uploads/' . $oldImg);
                }
                $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, project_url=?, image_url=? WHERE id=?");
                $stmt->execute([$title, $description, $project_url, $new_image, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, project_url=? WHERE id=?");
                $stmt->execute([$title, $description, $project_url, $id]);
            }
            $_SESSION['message'] = 'Project updated successfully!';
            $_SESSION['message_type'] = 'success';
        }
        
        header("Location: index.php");
        exit();
    }
}

if (isset($_GET['edit_project'])) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$_GET['edit_project']]);
    $editProject = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET['delete_project'])) {
    $id = $_GET['delete_project'];
    $stmt = $pdo->prepare("SELECT image_url FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $image = $stmt->fetchColumn();

    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    if ($stmt->execute([$id])) {
        if ($image && file_exists('../uploads/' . $image)) {
            unlink('../uploads/' . $image);
        }
        $_SESSION['message'] = 'Project deleted successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error deleting project.';
        $_SESSION['message_type'] = 'error';
    }
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_message'])) {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    if ($stmt->execute([$_GET['delete_message']])) {
        $_SESSION['message'] = 'Message deleted successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error deleting message.';
        $_SESSION['message_type'] = 'error';
    }
    header("Location: index.php");
    exit();
}

$projectCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$messageCount = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$projects = $pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll();
$messages = $pdo->query("SELECT * FROM messages ORDER BY id DESC LIMIT 10")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="../uploads/logos/admin-svgrepo-com.svg" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mozilla+Text:wght@200..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>

    <div class="container">
        <?php if ($message): ?>

            <div class="message <?php echo $message_type; ?>" id="message-alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3><?php echo $editProject ? 'Edit Project' : 'Add New Project'; ?></h3>

                <form method="POST">
                    <?php if ($editProject): ?>
                        <input type="hidden" name="project_id" value="<?php echo $editProject['id']; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Project Title:</label>
                        <input type="text" name="<?php echo $editProject ? 'edit_title' : 'title'; ?>"
                            value="<?php echo $editProject ? htmlspecialchars($editProject['title']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="<?php echo $editProject ? 'edit_description' : 'description'; ?>" required><?php echo $editProject ? htmlspecialchars($editProject['description']) : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Project URL:</label>
                        <input type="url" name="<?php echo $editProject ? 'edit_project_url' : 'project_url'; ?>"
                            value="<?php echo $editProject ? htmlspecialchars($editProject['project_url']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Image Filename:</label>
                        <div class="upload-note">
                            Upload image to /uploads/ folder first, then enter filename here.
                            <?php if ($editProject): ?>Leave empty to keep current image.<?php endif; ?>
                        </div>

                        <div class="input-with-button">
                            <input type="text" id="imageInput" name="<?php echo $editProject ? 'edit_image_filename' : 'image_filename'; ?>"
                                placeholder="e.g., image.jpg" <?php echo !$editProject ? 'required' : ''; ?>>
                            <button type="button" class="preview-btn" onclick="previewImage()">Preview</button>
                        </div>

                        <div class="image-preview-box" id="preview-box">
                            <div class="preview-title">Image Preview</div>
                        </div>

                        <?php if ($editProject): ?>
                            <div class="current-image-display">
                                <strong>Current Image:</strong> <?php echo htmlspecialchars($editProject['image_url']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="<?php echo $editProject ? 'edit_project' : 'add_project'; ?>" class="btn">
                        <?php echo $editProject ? 'Update Project' : 'Add Project'; ?>
                    </button>
                    <?php if ($editProject): ?>
                        <a href="index.php" class="btn btn-cancel">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="dashboard-card">
                <h3>Dashboard Stats</h3>
                <div class="stats-item">
                    <span class="stats-label">Total Projects:</span>
                    <span class="stats-value"><?php echo $projectCount; ?></span>
                </div>
                <div class="stats-item">
                    <span class="stats-label">Total Messages:</span>
                    <span class="stats-value"><?php echo $messageCount; ?></span>
                </div>
            </div>
        </div>

        <div class="table-container">
            <h3>Manage Projects</h3>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>URL</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($project['title']); ?></td>
                            <td class="description-cell"><?php echo htmlspecialchars($project['description']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($project['project_url']); ?>" target="_blank">View</a></td>
                            <td><?php echo htmlspecialchars($project['image_url']); ?></td>
                            <td>
                                <a href="?edit_project=<?php echo $project['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="?delete_project=<?php echo $project['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Delete this project?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h3>Contact Messages</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($msg['name']); ?></td>
                            <td><?php echo htmlspecialchars($msg['email']); ?></td>
                            <td class="message-cell"><?php echo htmlspecialchars($msg['message']); ?></td>
                            <td><?php echo $msg['created_at'] ?? 'N/A'; ?></td>
                            <td>
                                <a href="?delete_message=<?php echo $msg['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Delete this message?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        if (document.getElementById('message-alert')) {
            setTimeout(() => document.getElementById('message-alert').style.display = 'none', 5000);
        }

        function previewImage() {
            const filename = document.getElementById('imageInput').value.trim();
            const preview = document.getElementById('preview-box');

            if (!filename) {
                alert('Please enter a filename first.');
                return;
            }

            preview.innerHTML = '<div class="preview-title">Image Preview</div><div class="placeholder">Loading...</div>';

            const img = new Image();
            img.onload = () => {
                preview.innerHTML = `<div class="preview-title">Image Preview</div><img src="../uploads/${filename}" alt="Preview">`;
            };
            img.onerror = () => {
                preview.innerHTML = '<div class="preview-title">Image Preview</div><div class="error-message">Image not found</div>';
            };
            img.src = `../uploads/${filename}`;
        }
    </script>
</body>

</html>