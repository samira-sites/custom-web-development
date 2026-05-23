const menuToggle = document.getElementById("burger");
const navLinks = document.getElementById("nav-links");

menuToggle.addEventListener("click", () => {
  navLinks.classList.toggle("active");
  menuToggle.classList.toggle("active");
});

// Active Navbar Links
const sections = document.querySelectorAll("section");
const navItems = document.querySelectorAll(".nav-links a");

// Close Menu When Clicking Nav Link
navItems.forEach((link) => {
  link.addEventListener("click", () => {
    navLinks.classList.remove("active");
    menuToggle.classList.remove("active");
  });
});

window.addEventListener("scroll", () => {
  let current = "";

  sections.forEach((section) => {
    const sectionTop = section.offsetTop - 120;

    if (scrollY >= sectionTop) {
      current = section.getAttribute("id");
    }
  });

  navItems.forEach((link) => {
    link.classList.remove("active");

    if (link.getAttribute("href").includes(current)) {
      link.classList.add("active");
    }
  });
});

// =========================
// FAQ TOGGLE (CLEAN FIX)
// =========================
const faqItems = document.querySelectorAll(".faq-item");

faqItems.forEach((item) => {
  const btn = item.querySelector(".faq-question");
  const answer = item.querySelector(".faq-answer");

  btn.addEventListener("click", () => {
    const isOpen = item.classList.contains("active");

    // close all
    faqItems.forEach((i) => {
      i.classList.remove("active");
      const a = i.querySelector(".faq-answer");
      a.style.maxHeight = null;
    });

    // open clicked
    if (!isOpen) {
      item.classList.add("active");
      answer.style.maxHeight = answer.scrollHeight + "px";
    }
  });
});


// =========================
// CONTACT FORM
// =========================
const form = document.getElementById("contactForm");
const msg = document.getElementById("responseMsg");

if (form && msg) {
  const btn = form.querySelector("button");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    console.log("Sending form...");
    console.log([...formData.entries()]);

    msg.innerText = "Sending...";
    msg.style.color = "white";
    msg.classList.add("show");

    btn.disabled = true;
    btn.innerText = "Sending...";

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
      btn.disabled = false;
      btn.innerText = "Send Message";
    }
  });
}

// =========================
// SCROLL REVEAL
// =========================
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


 // =========================
// BACK TO TOP
// ========================= 
  const btn = document.getElementById('back-to-top');
  const text = document.querySelector('.back-top-text');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      btn.classList.add('visible');
    } else {
      btn.classList.remove('visible');
    }
  });


  btn.addEventListener('click', () => {
    window.location.href = '#hero';
  });

