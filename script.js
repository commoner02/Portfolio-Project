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
    "https://github.com/commoner02/fitness-tracker",
    "https://github.com/commoner02/project2",
    "https://github.com/commoner02/project3",
  ];

  projectButtons.forEach((button, index) => {
    button.addEventListener("click", function () {
      window.open(projectRepos[index] || "#", "_blank");
    });
  });

  // Contact form functionality
  const contactForm = document.getElementById("contact-form");
  const formStatus = document.getElementById("form-status");

  contactForm.addEventListener("submit", async function (e) {
    e.preventDefault();

    const submitBtn = contactForm.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;

    submitBtn.textContent = "Sending...";
    submitBtn.disabled = true;
    formStatus.textContent = "";

    try {
      const formData = new FormData(contactForm);
      const response = await fetch("contact.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        formStatus.textContent = "Message sent successfully!";
        formStatus.style.color = "green";
        contactForm.reset();
      } else {
        throw new Error(result.error || "Failed to send message");
      }
    } catch (error) {
      formStatus.textContent = "Error sending message. Please try again.";
      formStatus.style.color = "red";
      console.error("Error:", error);
    } finally {
      submitBtn.textContent = originalText;
      submitBtn.disabled = false;

      // Clear status message after 5 seconds
      setTimeout(() => {
        formStatus.textContent = "";
      }, 5000);
    }
  });
});
