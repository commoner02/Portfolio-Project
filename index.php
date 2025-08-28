<?php

session_start();

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
        <div class="skill-list">
          <div class="skill-item">
            <img src="./uploads/logos/html-5-svgrepo-com.svg" alt="skill-logo">
            <p>HTML</p>
          </div>
          <div class="skill-item">
            <img src="./uploads/logos/css-3-svgrepo-com.svg" alt="skill-logo">
            <p>CSS</p>
          </div>
          <div class="skill-item">
            <img src="./uploads/logos/js-svgrepo-com.svg" alt="skill-logo">
            <p>Javascript</p>
          </div>
          <div class="skill-item">
            <img src="./uploads/logos/php-svgrepo-com.svg" alt="skill-logo">
            <p>PHP</p>
          </div>
          <div class="skill-item">
            <img src="./uploads/logos/android-svgrepo-com.svg" alt="skill-logo">
            <p>Android</p>
          </div>
          <div class="skill-item">
            <img src="./uploads/logos/java-svgrepo-com.svg" alt="skill-logo">
            <p>Java</p>
          </div>
          <div class="skill-item">
            <img src="./uploads/logos/git-svgrepo-com.svg" alt="skill-logo">
            <p>Git</p>
          </div>

        </div>
      </div>
    </div>
    <div id="projects" class="projects">
      <div class="project-container">
        <h3>Projects</h3>
        <div class="project-list">
          <div class="project-item">
            <div class="project-left">
              <img src="./uploads/projects/OOP Project-Fitness.png" alt="Project-Fitness" class="project-image">
            </div>
            <div class="project-right">
              <div class="project-title">
                <h4>Fitness Tracking System using OOP in C++</h4>
              </div>
              <div class="project-details">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corrupti iure deleniti officia est laborum animi perferendis rerum consectetur sapiente.
              </div>
              <div class="project-button">
                <button>See Repo</button>
              </div>
            </div>
          </div>
          <div class="project-item">
            <div class="project-left">
              <img src="./uploads/projects/OOP Project-Fitness.png" alt="Project-Fitness" class="project-image">
            </div>
            <div class="project-right">
              <div class="project-title">
                <h4>Fitness Tracking System using OOP in C++</h4>
              </div>
              <div class="project-details">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corrupti iure deleniti officia est laborum animi perferendis rerum consectetur sapiente.
              </div>
              <div class="project-button">
                <button>See Repo</button>
              </div>
            </div>
          </div>
          <div class="project-item">
            <div class="project-left">
              <img src="./uploads/projects/OOP Project-Fitness.png" alt="Project-Fitness" class="project-image">
            </div>
            <div class="project-right">
              <div class="project-title">
                <h4>Fitness Tracking System using OOP in C++</h4>
              </div>
              <div class="project-details">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam corrupti iure deleniti officia est laborum animi perferendis rerum consectetur sapiente.
              </div>
              <div class="project-button">
                <button>See Repo</button>
              </div>
            </div>
          </div>

        </div>
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
            <!-- Display messages if they exist -->
            <?php if (!empty($success_message)): ?>
              <div class='success'><?php echo $success_message; ?></div>
            <?php elseif (!empty($error_message)): ?>
              <div class='error'><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form id="contact-form" method="POST" action="contact.php">
              <div class="honeypot" style="position: absolute; left: -5000px;">
                <input type="text" name="website" tabindex="-1">
              </div>
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
                <button type="submit" name="sendEmail">Send Email</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <p>©Copyright 2025 | Shuvo(commoner02). All rights reserved.</p>
  </footer>
  <script src="script.js"></script>
</body>

</html>