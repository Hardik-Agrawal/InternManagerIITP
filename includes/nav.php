<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Intern Manager</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active"><a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a></li>
      <li class="nav-item"><a class="nav-link" href="project.php">Projects</a></li>
      <?php if (logged_in()) : ?>
        <?php if ($_SESSION['type'] == 1) : ?>
          <li class='nav-item'><a class='nav-link' href='prof_profile.php'>Profile</a></li>
        <?php else : ?>
          <li class='nav-item'><a class='nav-link' href='stud_profile.php'>Profile</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      <?php else : ?>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>