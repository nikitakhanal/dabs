<?php
include('./includes/connection.php');
include('./includes/header.php');
?>

<title>Doctor's Appointment Booking System</title>
</head>
<body>
<main class="wrapper">
  <section class="cover">
    <div class="cover-left">
      <h1 class="tagline"><span class="opacity-8">Koshi Zonal Hospital's</span> Doctor's Appointment Booking System</h1>
      <p class="subtitle">Making the appointment booking process quick, efficient and hassle free.</p>
      <a href="views/patientSignup.php" class="CTA">Sign up</a>
      <a href="views/signin.php" class="CTA">Sign in</a>
    </div>
    <div class="cover-img-container">
      <img class="cover-img" src="images/koshi1.jpg" alt="Koshi Zonal Hospital">
  </div>
  </section>
  
</main>
<footer>
  <p class="copyright">Copyright @ Koshi Zonal Hospital <span id="year"></span> </p>
</footer>

<script>
    document.querySelector("#year").textContent = new Date().getFullYear();
</script>
</body>
</html>