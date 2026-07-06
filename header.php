<?php
$pageTitle = $pageTitle ?? "Samira Omar";
$pageDescription = $pageDescription ?? "Website Developer";
$pageKeywords = $pageKeywords ?? "";
$pageCanonical = $pageCanonical ?? "https://samiraomar.com/";
$pageOgImage = $pageOgImage ?? "https://samiraomar.com/assets/images/preview.webp";
$pageOgAlt = $pageOgAlt ?? "Samira Omar website preview";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic Meta -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">

  <meta name="keywords" content="<?= htmlspecialchars($pageKeywords) ?>">

  <meta name="author" content="Samira Omar">
  <meta name="robots" content="index, follow">

  <link rel="canonical" href="<?= htmlspecialchars($pageCanonical) ?>">

  <!-- Theme -->
  <meta name="theme-color" content="#fe8d14">
  <meta name="google-site-verification" content="kkU2fzg6VLTK-mb749d8i36G4OS4fut-8gJIe4NU4tE" />

  <!-- Open Graph -->
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta property="og:site_name" content="Samira Omar">
  <meta property="og:url" content="<?= htmlspecialchars($pageCanonical) ?>">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_US">
  <meta property="og:image" content="<?= htmlspecialchars($pageOgImage) ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="Samira Omar web developer portfolio preview">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($pageOgImage) ?>">
  <meta name="twitter:site" content="Sam_dev88">

  <!-- Structured Data -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Person",
      "name": "Samira Omar",
      "url": "https://samiraomar.com/",
      "jobTitle": "Website Developer",
      "image": "https://samiraomar.com/assets/images/image.jpeg",
      "sameAs": [
        "https://www.linkedin.com/in/samira-omar/"
      ]
    }
    </script>

  <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Samira Omar",
        "url": "https://samiraomar.com/",
        "logo": "https://samiraomar.com/assets/images/navlogo.webp",
        "description": "Website Developer crafting clean, modern, and responsive websites for businesses and personal brands."
      }
      </script>

  <!-- Favicons -->
  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="icon" type="image/svg+xml" href="/assets/icons/favicon.svg">

  <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/icon_32.png">
  <link rel="icon" type="image/png" sizes="192x192" href="/assets/icons/icon_192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="/assets/icons/icon_512.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/icon_180.png">

  <!-- PWA -->
  <link rel="manifest" href="/manifest.json">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">

  <!-- Performance -->
  <link rel="preload" as="image" href="/assets/images/hero-image.webp">

  <!-- CSS -->
  <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="/css/style.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="js/script.js" defer></script>
</head>

<body>
  <!-- HEADER -->
  <header class="header">
    <nav class="navbar container">

      <a href="#hero" class="brand">
        <img src="assets/images/navlogo.webp" class="navlogo" alt="Samira Omar logo" />
        <span class="brand-name">sam<span style="color: #fff;">ira</span>omar</span>

      </a>

      <div id="burger" class="burger">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <ul class="nav-links" id="nav-links">
        <li><a href="index.php#hero" class="active">Home</a></li>
        <li><a href="about.php#about" class="active">About</a></li>
        <li><a href="index.php#services">Services</a></li>
        <li><a href="index.php#projects">Projects</a></li>
        <li><a href="index.php#process">Process</a></li>
        <li><a href="index.php#faq">FAQs</a></li>
        <li><a href="index.php#contact" class="btn btn-secondary">Contact</a></li>
      </ul>

    </nav>
  </header>
