/* =========================
   DOM READY WRAPPER
========================= */
document.addEventListener("DOMContentLoaded", () => {

  /* =========================
     BURGER MENU
  ========================= */
  const menuToggle = document.getElementById("burger");
  const navLinks = document.getElementById("nav-links");

  if (menuToggle && navLinks) {
    menuToggle.addEventListener("click", () => {
      navLinks.classList.toggle("active");
      menuToggle.classList.toggle("active");
    });

    // Close menu on nav click
    const navItems = document.querySelectorAll(".nav-links a");

    navItems.forEach((link) => {
      link.addEventListener("click", () => {
        navLinks.classList.remove("active");
        menuToggle.classList.remove("active");
      });
    });
  }


  /* =========================
     ACTIVE NAV ON SCROLL
  ========================= */
  const sections = document.querySelectorAll("section");

  window.addEventListener("scroll", () => {
    let current = "";

    sections.forEach((section) => {
      const sectionTop = section.offsetTop - 120;

      if (window.scrollY >= sectionTop) {
        current = section.getAttribute("id");
      }
    });

    document.querySelectorAll(".nav-links a").forEach((link) => {
      link.classList.remove("active");

      if (link.getAttribute("href")?.includes(current)) {
        link.classList.add("active");
      }
    });
  });


  /* =========================
     FAQ TOGGLE
  ========================= */
  const faqItems = document.querySelectorAll(".faq-item");

  faqItems.forEach((item) => {
    const btn = item.querySelector(".faq-question");
    const answer = item.querySelector(".faq-answer");

    if (!btn || !answer) return;

    btn.addEventListener("click", () => {
      const isOpen = item.classList.contains("active");

      // Close all
      faqItems.forEach((i) => {
        i.classList.remove("active");
        const a = i.querySelector(".faq-answer");
        if (a) a.style.maxHeight = null;
      });

      // Open clicked
      if (!isOpen) {
        item.classList.add("active");
        answer.style.maxHeight = answer.scrollHeight + "px";
      }
    });
  });


  /* =========================
     CONTACT FORM
  ========================= */
  const form = document.getElementById("contactForm");
  const msg = document.getElementById("responseMsg");

  if (form && msg) {
    const formBtn = form.querySelector("button");

    form.addEventListener("submit", async function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      msg.innerText = "Sending...";
      msg.style.color = "white";

      if (formBtn) {
        formBtn.disabled = true;
        formBtn.innerText = "Sending...";
      }

      try {
        const response = await fetch("./contact.php", {
          method: "POST",
          body: formData
        });

        if (!response.ok) throw new Error("Server error");

        const data = await response.text();

        msg.innerText = data;
        msg.style.color = data.toLowerCase().includes("success") ? "orange" : "red";

        if (data.toLowerCase().includes("success")) {
          form.reset();
        }

      } catch (err) {
        console.error(err);
        msg.innerText = "Server error. Try again.";
        msg.style.color = "red";

      } finally {
        if (formBtn) {
          formBtn.disabled = false;
          formBtn.innerText = "Send Message";
        }
      }
    });
  }


  /* =========================
     SCROLL REVEAL
  ========================= */
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("active");
        }
      });
    },
    { threshold: 0.15 }
  );

  document
    .querySelectorAll(".reveal, .reveal-left, .reveal-right")
    .forEach((el) => observer.observe(el));


/* =========================
   BACK TO TOP
========================= */
const backToTopBtn = document.getElementById("back-to-top");

if (backToTopBtn) {

  window.addEventListener("scroll", () => {

    if (window.scrollY > 300) {
      backToTopBtn.classList.add("visible");
    } else {
      backToTopBtn.classList.remove("visible");
    }

  });

  backToTopBtn.addEventListener("click", () => {
    location.href = "#hero";
  });

}
});