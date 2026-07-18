<?php
$pageTitle = "About Samira Omar | Website Developer";
$pageDescription = "Learn more about Samira Omar, a website developer creating modern, responsive websites and landing pages for businesses.";
$pageKeywords = "about samira omar, full-stack web developer, website developer";
$pageCanonical = "https://samiraomar.com/about.php";
$pageOgImage = "https://samiraomar.com/assets/images/preview.webp";
$pageOgAlt = "About Samira Omar";
?>

<?php include 'header.php'; ?>
<style>
:root {
  --black: #000;
  --white: #fff;
  --accent: #fe8d14;
  --border: rgba(255, 255, 255, 0.1);
  --muted: rgba(255, 255, 255, 0.72);
  --radius: 5px;
  --transition: 0.3s ease;
}

* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
  color: var(--white);
  background: var(--black);
  line-height: 1.6;
}

img {
  max-width: 100%;
  display: block;
  border-radius: var(--radius);
}

.wrap {
  max-width: 1040px;
  margin: 0 auto;
  padding: 0 24px;
}

/* LABEL */
.label {
  text-align: center;
  font-size: 11px;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--accent);
  background: rgba(254,141,20,.12);
  border: 1px solid rgba(254,141,20,.35);
  border-radius: 20px;
  padding: 4px 14px;
  display: inline-block;
  margin: 2rem;
}

/* HERO */
.about-hero {
  padding: 64px 24px 48px;
  text-align: center;
  background:
    radial-gradient(circle at top, rgba(254,141,20,.12), transparent 45%),
    var(--black);
  border-bottom: 1px solid var(--border);
  min-height: 100vh;
}

.about-hero h1 {
  font-size: clamp(32px,4vw,58px);
  margin: 6px 0 14px;
  letter-spacing: -0.02em;
  color: var(--white);
}

.about-hero h1 span {
  color: var(--accent);
}

.about-hero p {
  max-width: 560px;
  margin: 0 auto;
  color: var(--muted);
  font-size: 17px;
}

/* STORY SECTION */
.story-section {
  padding: 64px 0;
  border-bottom: 1px solid var(--border);
}

.story-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 48px;
  align-items: center;
}

.photo-pair {
  display: flex;
  gap: 14px;
}

.photo-box {
  flex: 1;
  aspect-ratio: 3/4;
  overflow: hidden;
  border-radius: var(--radius);
  border: 1px solid var(--border);
  background: #111;
  box-shadow: 0 6px 20px rgba(0,0,0,.5);
  transition: var(--transition);
}

.photo-box:hover {
  transform: translateY(-4px) scale(1.02);
  border-color: rgba(254,141,20,.5);
}

.photo-box img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: var(--radius);
}

.caption {
  text-align: center;
  font-size: 13px;
  color: var(--muted);
  font-style: italic;
  margin-top: 10px;
}

.story-text h2 {
  font-size: 26px;
  margin-top: 0;
  margin-bottom: 16px;
  color: var(--white);
}

.story-text p {
  color: var(--muted);
  font-size: 15.5px;
  margin: 0 0 12px;
}

.speech-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  margin-top: 14px;
  color: var(--accent);
  font-weight: 600;
  font-size: 14.5px;
  text-decoration: none;
  border-bottom: 1px solid var(--accent);
  padding-bottom: 2px;
  transition: var(--transition);
}

.speech-link:hover {
  color: var(--white);
  border-color: var(--white);
}

/* DIFFERENT SECTION */
.different {
  padding: 56px 0;
  text-align: center;
  background: #0a0a0a;
  border-bottom: 1px solid var(--border);
}

.different .wrap {
  max-width: 680px;
}

.different h2 {
  font-size: 24px;
  margin-bottom: 14px;
  color: var(--white);
}

.different p {
  color: var(--muted);
  font-size: 15.5px;
}

.approach {
  padding: 64px 0;
  border-bottom: 1px solid var(--border);
}

.approach h2 {
  text-align: center;
  font-size: 26px;
  margin-bottom: 36px;
  color: var(--white);
}

.approach-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  max-width: 760px;
  margin: 0 auto;
}

.approach-item {
  display: flex;
  gap: 12px;
  padding: 18px;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  background: #0d0d0d;
  transition: var(--transition);
}

.approach-item:hover {
  border-color: rgba(254,141,20,.4);
  transform: translateY(-3px);
}

.approach-item .check {
  color: var(--accent);
  font-weight: 700;
  font-size: 18px;
  line-height: 1.4;
}

.approach-item p {
  margin: 0;
  font-size: 14.5px;
  color: var(--white);
}

/* BASED IN KUWAIT */
.location {
  padding: 48px 0;
  text-align: center;
  border-bottom: 1px solid var(--border);
}

.location h3 {
  font-size: 18px;
  margin-bottom: 10px;
  color: var(--accent);
}

.location p {
  max-width: 520px;
  margin: 0 auto;
  color: var(--muted);
  font-size: 15px;
}

/* TRUST LINE */
.trust-line {
  padding: 32px 24px;
  text-align: center;
  background: #111;
  border-bottom: 1px solid var(--border);
}

.trust-line p {
  margin: 0 auto;
  font-size: 15px;
  color: var(--white);
  font-weight: 500;
  max-width: 480px;
}

.trust-line p::before {
  content: "✓ ";
  color: var(--accent);
  font-weight: 700;
}

/* CTA */
.about-cta {
  padding: 64px 24px;
  text-align: center;
  background: var(--black);
  color: #fff;
  padding: 1rem 1rem 0px;
  margin-top: 80px;
  margin: 1rem 0;
}

.about-cta h2 {
  font-size: 26px;
  margin-bottom: 10px;
  color: var(--black);
}

.about-cta p {
  color: var(--white);
  margin-bottom: 26px;
}

/* BUTTON */
.btn {
  padding: 14px 32px;
  border-radius: var(--radius);
  font-weight: 700;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  border: none;
  cursor: pointer;
  transition: var(--transition);
}

.btn-primary {
  background: var(--accent);
  color: var(--black);
}

.btn-primary:hover {
  background: #ff9d32;
  transform: translateY(-2px);
}

/* MOBILE */
@media (max-width:720px) {
  .story-grid {
    grid-template-columns: 1fr;
    gap: 28px;
  }

  .approach-grid {
    grid-template-columns: 1fr;
  }

  .about-hero {
    padding: 7rem 1rem;
  }

  main p {
    text-align: justify;
  }

  .story-text h2 {
    text-align: center;
  }
}

/* BACK TO TOP */
#back-to-top {
  background: var(--accent);
  transition: var(--transition);
}

#back-to-top:hover {
  background: var(--white);
}

#back-to-top svg {
  stroke: var(--black);
}
</style>
</head>

<body>


  <main>


    <!-- ============ STORY ============ -->

    <section class="story-section" id="about">
      <div class="wrap" style="display: flex; justify-content: center;">
        <span class="label reveal-left">About Me</span>

      </div>
      <div class="wrap story-grid reveal">
        <div>
          <div class="photo-pair">
            <div class="photo-box reveal">
              <img src="assets/images/dh.webp"
                alt="Samira Omar working as an OFW domestic helper before her career in IT">
            </div>

            <div class="photo-box reveal">
              <img src="assets/images/grad.webp" alt="Samira Omar at her IT diploma graduation photoshoot">
            </div>
          </div>
          <p class="caption reveal">From OFW domestic helper to IT — and now building modern websites.</p>
        </div>
        <div class="story-text reveal">
          <h2 class="reveal">My Journey</h2>
          <p>I'm Samira Omar, I started my career as an overseas Filipino worker, and along the way I made the decision
            to
            build a future in tech. While working full-time, I completed a UK Diploma in Information Technology
            — studying late nights with a clear goal in mind.</p>

          <p>Today, I design and build custom websites for businesses that want to improve their online presence and
            stand out from the competition. I focus on clean, functional, and user-friendly websites that support real
            business needs.</p>

        </div>
      </div>
    </section>

    <!-- ============ WHAT I DO DIFFERENTLY ============ -->
    <section class="different">
      <div class="wrap">
        <h2 class="reveal">What I Do Differently</h2>
        <p class="reveal">I'm a full-stack web developer, handling everything from design and frontend development to
          backend development, database integration, and deployment. You work directly with one developer, ensuring
          clear communication, consistent quality, and a seamless process from start to finish.</p>
      </div>
    </section>

    <!-- ============ APPROACH ============ -->
    <section class="approach">
      <div class="wrap">
        <h2 class="reveal">My Approach</h2>
        <div class="approach-grid reveal">
          <div class="approach-item"><span class="check">✔</span>
            <p>Clean, modern design tailored to your brand — not a template</p>
          </div>
          <div class="approach-item"><span class="check">✔</span>
            <p>Fast-loading, mobile-friendly websites built with best practices</p>
          </div>
          <div class="approach-item"><span class="check">✔</span>
            <p>Honest pricing and clear timelines — no hidden costs</p>
          </div>
          <div class="approach-item"><span class="check">✔</span>
            <p>Open communication so you always know your project progress</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ LOCATION ============ -->
    <section class="location">
      <div class="wrap reveal">
        <h3>Based in Kuwait</h3>
        <p>
          I work with clients locally and internationally — from small business owners to startups and personal brands —
          helping them stand out online with websites designed to build trust, generate leads, and support business
          growth.
        </p>
      </div>
    </section>

    <!-- ============ TRUST LINE ============ -->
    <section class="trust-line">
      <p class="reveal">Every project comes with a clear timeline agreed upfront — so you’ll always know exactly what to
        expect from the start to the final launch.</p>
    </section>

  </main>
  <!-- ============ CTA (uses your existing site-wide Calendly script) ============ -->
  <section class="about-cta reveal">
    <div class="wrap">
      <h2>Let's build something that actually works for your business.</h2>
      <p>Got a project in mind? Let's talk.</p>

      <div class="hero-buttons reveal" style="display: flex; justify-content: center;">
        <a href="index.php#contact" class="btn btn-primary reveal-left">Let's Work Together</a>
      </div>
    </div>
  </section>

  <button id="back-to-top" aria-label="Back to top">
    <svg viewBox="0 0 24 24">
      <polyline points="18 15 12 9 6 15" />
    </svg>
  </button>