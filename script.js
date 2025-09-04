const skills = [
  {
    name: "HTML",
    icon: "./uploads/logos/html-5-svgrepo-com.svg",
  },
  {
    name: "CSS",
    icon: "./uploads/logos/css-3-svgrepo-com.svg",
  },
  {
    name: "Javascript",
    icon: "./uploads/logos/js-svgrepo-com.svg",
  },
  {
    name: "PHP",
    icon: "./uploads/logos/php-svgrepo-com.svg",
  },
  {
    name: "Android",
    icon: "./uploads/logos/android-svgrepo-com.svg",
  },
  {
    name: "Java",
    icon: "./uploads/logos/java-svgrepo-com.svg",
  },
  {
    name: "Git",
    icon: "./uploads/logos/git-svgrepo-com.svg",
  },
];

function loadSkills() {
  const container = document.getElementById("skillContainer");
  if (container) {
    container.innerHTML = "";
    skills.forEach((skill) => {
      const skillDiv = document.createElement("div");
      skillDiv.className = "skill-item";
      skillDiv.innerHTML = `<img src="${skill.icon}" alt="skill-logo"><p>${skill.name}</p>`;
      container.appendChild(skillDiv);
    });
  }
}

document.addEventListener("DOMContentLoaded", function () {
  loadSkills();

  const navItems = document.querySelectorAll(".nav-item");
  const navBar = document.querySelector(".nav-bar");
  const hamburger = document.querySelector(".hamburger");
  const githubBtn = document.getElementById("Github-btn");
  const linkedinBtn = document.getElementById("Linkedin-btn");
  const contactForm = document.getElementById("contact-form");

  navItems.forEach((item) => {
    item.addEventListener("click", function () {
      const targetId = this.getAttribute("data-target");
      const targetSection = document.getElementById(targetId);

      if (targetSection) {
        if (navBar && navBar.classList.contains("active")) {
          navBar.classList.remove("active");
          hamburger.classList.remove("active");
          document.body.style.overflow = "";
        }

        const headerHeight = document.querySelector(".header").offsetHeight;
        const targetPosition = targetSection.offsetTop - headerHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth",
        });
      }
    });
  });

  if (hamburger && navBar) {
    hamburger.addEventListener("click", function () {
      this.classList.toggle("active");
      navBar.classList.toggle("active");
      document.body.style.overflow = navBar.classList.contains("active")
        ? "hidden"
        : "";
    });
  }

  document.addEventListener("click", function (event) {
    if (
      window.innerWidth < 980 &&
      !event.target.closest(".nav-bar") &&
      !event.target.closest(".hamburger") &&
      navBar &&
      navBar.classList.contains("active")
    ) {
      hamburger.classList.remove("active");
      navBar.classList.remove("active");
      document.body.style.overflow = "";
    }
  });

  if (githubBtn) {
    githubBtn.addEventListener("click", function () {
      window.open("https://github.com/commoner02", "_blank");
    });
  }

  if (linkedinBtn) {
    linkedinBtn.addEventListener("click", function () {
      window.open(
        "https://linkedin.com/in/sree-shuvo-kumar-joy-b6a60737a",
        "_blank"
      );
    });
  }

  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(contactForm);
      formData.append("sendEmail", "true");

      const submitButton = contactForm.querySelector('button[type="submit"]');
      const originalText = submitButton.textContent;

      submitButton.disabled = true;
      submitButton.textContent = "Sending...";

      fetch("index.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          if (data.includes("Message sent successfully!")) {
            showFormMessage("Message sent successfully!", "success");
            contactForm.reset();
          } else if (data.includes("All fields are required.")) {
            showFormMessage("All fields are required.", "error");
          } else if (data.includes("Please enter a valid email.")) {
            showFormMessage("Please enter a valid email.", "error");
          } else {
            showFormMessage(
              "Sorry, something went wrong. Please try again.",
              "error"
            );
          }
        })
        .catch((error) => {
          showFormMessage("An error occurred. Please try again.", "error");
        })
        .finally(() => {
          submitButton.disabled = false;
          submitButton.textContent = originalText;
        });
    });
  }

  function showFormMessage(message, type) {
    const messageContainer = document.querySelector(".contact-right");
    const existingMessage = messageContainer.querySelector(".success, .error");

    if (existingMessage) {
      existingMessage.remove();
    }

    const messageElement = document.createElement("p");
    messageElement.className = type;
    messageElement.textContent = message;
    messageContainer.insertBefore(
      messageElement,
      messageContainer.querySelector("form")
    );

    if (type === "success") {
      setTimeout(() => {
        messageElement.remove();
      }, 5000);
    }
  }
});
