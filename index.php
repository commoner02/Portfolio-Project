<?php

session_start();
include './includes/config.php';

$visitCount = isset($_COOKIE['visit_count']) ? (int)$_COOKIE['visit_count'] + 1 : 1;
setcookie('visit_count', $visitCount, time() + (365 * 24 * 60 * 60), '/');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sendEmail'])) {

  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $message = trim($_POST['message']);

  if (empty($name) || empty($email) || empty($message)) {
    $_SESSION['error_message'] = 'All fields are required.';
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['error_message'] = 'Please enter a valid email.';
    } else {
      $query = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
      $stmt = $pdo->prepare($query);

      if ($stmt->execute([$name, $email, $message])) {
        $_SESSION['success_message'] = 'Message sent successfully!';
      } else {
        $_SESSION['error_message'] = 'Sorry, something went wrong. Please try again.';
      }
    }
  }

  header("Location: index.php#contacts");
  exit;
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfolio</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="shortcut icon" href="./uploads/logos/icons8-portfolio-undefined-96.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mozilla+Text:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
  <header class="header">
    <div class="header-contents">
      <button class="hamburger">
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
      </button>
      <div class="logo">
        Dev<span id="logo-name">Joy</span>
      </div>
      <nav class="nav-bar">
        <div class="nav-item" data-target="home">Home</div>
        <div class="nav-item" data-target="education">Education</div>
        <div class="nav-item" data-target="projects">Projects</div>
        <div class="nav-item" data-target="contacts">Contacts</div>
      </nav>
    </div>
  </header>
  <main>
    <div id="home" class="intro">
      <div class="intro-container">
        <div class="intro-left">
          <div class="intro-text">
            <p><span>Hello,</span> I'm</p>
            <p id="name">Shuvo Kumar Joy</p>
            <p>
              CSE Student at KUET | Web Developer | Tech Enthusiast | Hardware Tinkerer | Exploring Embedded Systems and Network Solutions.
            </p>
            <div class="intro-buttons">
              <div class="btnHolder">
                <button id="Github-btn">Github</button>
              </div>
              <div class="btnHolder">
                <button id="Linkedin-btn">LinkedIn</button>
              </div>
            </div>
          </div>
        </div>
        <div class="intro-right">
          <img src="./uploads/me/myPhoto02.png" alt="myPhoto" />
        </div>
      </div>
    </div>

    <div id="skills-section" class="skills">
      <div class="skill-content">
        <h3>Skills</h3>
        <div class="skill-list" id="skillContainer">
        </div>
      </div>
    </div>

    <div id="projects" class="projects">
      <div class="project-container">
        <h3>Projects</h3>
        <?php
        $query = "SELECT * FROM projects";
        $result = $pdo->query($query);
        if ($result) {
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $project_title = $row['title'];
            $project_description = $row['description'];
            $project_image = $row['image_url'];
            $project_link = $row['project_url'];
        ?>

            <div class='project-item'>
              <div class='project-left'>
                <img src='./uploads/<?php echo htmlspecialchars($project_image, ENT_QUOTES, 'UTF-8'); ?>' alt='<?php echo htmlspecialchars($project_title, ENT_QUOTES, 'UTF-8'); ?>' class='project-image'>
              </div>
              <div class='project-right'>
                <div class='project-title'>
                  <h4><?php echo htmlspecialchars($project_title, ENT_QUOTES, 'UTF-8'); ?></h4>
                </div>
                <div class='project-details'>
                  <?php echo nl2br(htmlspecialchars($project_description, ENT_QUOTES, 'UTF-8')); ?>
                </div>
                <div class='project-button'>
                  <button onclick="window.location.href='<?php echo htmlspecialchars($project_link, ENT_QUOTES, 'UTF-8'); ?>'">See Repo</button>
                </div>require_once '../includes/auth.php';
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
              </div>
            </div>

        <?php
          }
        } else {
          echo "Error fetching projects.";
        }
        ?>
      </div>
    </div>

    <div id="education" class="education">
      <div class="edu-container">
        <h3>Education Life</h3>
        <div class="edu-contents">
          <div class="edu-item">
            <h4 class="edu-degree">BSc.</h4>
            <h4 class="edu-institute">Khulna University of Engineering and Technology,Khulna</h4>
            <h5 class="edu-details">CSE, 2023-2027</h5>
          </div>
          <div class="edu-item">
            <h4 class="edu-degree">HSC</h4>
            <h4 class="edu-institute">Saidpur Government Science College, Saidpur</h4>
            <h5 class="edu-details">Science, 2019-2021</h5>
          </div>
          <div class="edu-item">
            <h4 class="edu-degree">SSC</h4>
            <h4 class="edu-institute">Sundarganj A.M. Govt. Boys High School, Sundarganj</h4>
            <h5 class="edu-details">Science, 2014-2019</h5>
          </div>
        </div>
      </div>
    </div>

    <div id="contacts" class="contacts">
      <div class="contact-container">
        <h3>Contact Me</h3>
        <div class="contact-content">
          <div class="contact-left">
            <p>I would like you hear from You.<br>
              Contact for any need or talk.
            </p>
          </div>
          <div class="contact-right">
            <?php if (!empty($success_message)): ?>
              <div class='success'><?php echo $success_message; ?></div>
            <?php elseif (!empty($error_message)): ?>
              <div class='error'><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form id="contact-form" method="POST" action="">
              <div>
                <input id="sender_name" type="text" name="name" placeholder="Your Name" required>
              </div>
              <div>
                <input id="sender_email" type="email" name="email" placeholder="Email" required>
              </div>
              <div>
                <textarea id="sender_message" name="message" placeholder="Message" required></textarea>
              </div>
              <div>
                <button type="submit" name="sendEmail">Send Message</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <p id="visit-count">Visit Count: <?php echo $visitCount; ?></p>
    <p>©Copyright 2025 | Shuvo(commoner02). All rights reserved.</p>
  </footer>
  <script src="script.js"></script>
</body>

</html>