document.addEventListener("DOMContentLoaded", function () {
  // Navigation functionality
  const navItems = document.querySelectorAll(".nav-item");
  const navBar = document.querySelector(".nav-bar");
  const hamburger = document.querySelector(".hamburger");

  // Add click event to each nav item
  navItems.forEach((item) => {
    item.addEventListener("click", function () {
      const targetId = this.getAttribute("data-target");
      const targetSection = document.getElementById(targetId);

      if (targetSection) {
        // Close mobile menu if open
        if (navBar.classList.contains("active")) {
          navBar.classList.remove("active");
          hamburger.classList.remove("active");
          document.body.style.overflow = "";
        }

        // Scroll to the target section with offset for header
        const headerHeight = document.querySelector(".header").offsetHeight;
        const targetPosition = targetSection.offsetTop - headerHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth",
        });
      }
    });
  });

  // Hamburger menu toggle
  hamburger.addEventListener("click", function () {
    this.classList.toggle("active");
    navBar.classList.toggle("active");
    document.body.style.overflow = navBar.classList.contains("active")
      ? "hidden"
      : "";
  });

  // Close menu when clicking outside on mobile
  document.addEventListener("click", function (event) {
    if (
      window.innerWidth < 980 &&
      !event.target.closest(".nav-bar") &&
      !event.target.closest(".hamburger") &&
      navBar.classList.contains("active")
    ) {
      hamburger.classList.remove("active");
      navBar.classList.remove("active");
      document.body.style.overflow = "";
    }
  });

  // Button functionality
  document.getElementById("Github-btn").addEventListener("click", function () {
    window.open("https://github.com/commoner02", "_blank");
  });

  document
    .getElementById("Linkedin-btn")
    .addEventListener("click", function () {
      window.open(
        "https://linkedin.com/in/sree-shuvo-kumar-joy-b6a60737a",
        "_blank"
      );
    });

  // Project buttons
  const projectButtons = document.querySelectorAll(".project-button button");
  const projectRepos = [
    "https://github.com/commoner02/OOP-Project",
    "https://github.com/commoner02/project2",
    "https://github.com/commoner02/project3",
  ];

  projectButtons.forEach((button, index) => {
    button.addEventListener("click", function () {
      window.open(projectRepos[index] || "#", "_blank");
    });
  });

  // Contact form functionality
  //   document.addEventListener('DOMContentLoaded', function() {
  //   const contactForm = document.getElementById('contact-form');
  //   const formStatus = document.getElementById('form-status');

  //   contactForm.addEventListener('submit', function(e) {
  //       e.preventDefault();

  //       // Show loading state
  //       const submitBtn = contactForm.querySelector('button[type="submit"]');
  //       const originalText = submitBtn.textContent;
  //       submitBtn.textContent = 'Sending...';
  //       submitBtn.disabled = true;

  //       // Create FormData object
  //       const formData = new FormData(contactForm);

  //       // Send AJAX request
  //       fetch('contact.php', {
  //           method: 'POST',
  //           body: formData
  //       })
  //       .then(response => response.json())
  //       .then(data => {
  //           if (data.success) {
  //               // Show success message
  //               formStatus.textContent = data.message;
  //               formStatus.className = 'success';
  //               formStatus.style.display = 'block';

  //               // Reset form
  //               contactForm.reset();
  //           } else {
  //               // Show error message
  //               formStatus.textContent = data.message;
  //               formStatus.className = 'error';
  //               formStatus.style.display = 'block';
  //           }
  //       })
  //       .catch(error => {
  //           // Show error message
  //           formStatus.textContent = 'An error occurred. Please try again.';
  //           formStatus.className = 'error';
  //           formStatus.style.display = 'block';
  //       })
  //       .finally(() => {
  //           // Reset button state
  //           submitBtn.textContent = originalText;
  //           submitBtn.disabled = false;

  //           // Hide status message after 5 seconds
  //           setTimeout(() => {
  //               formStatus.style.display = 'none';
  //           }, 5000);
  //       });
  //   });
  // });
});
