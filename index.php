<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <input type="checkbox" id="checkbox">
  <header class="header">
    <h2 class="u-name"><i>SPRINTS</i></h2>

    <?php 
        $User = "admin";
        if ($User !== "employee") {
    ?>
    <!-- Admin NavBar Code Below -->
    <nav class="navigation-icons-bar">
        <ul>
          <li><a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
          <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Manage Users</span></a></li>
          <li><a href="#"><i class="fa fa-plus" aria-hidden="true"></i><span>Create Tasks</span></a></li>
          <li><a href="#"><i class="fa fa-tasks" aria-hidden="true"></i><span>All Tasks</span></a></li>
          <li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span></a></li>
          <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
          <li><div class="user-p"> <img src="./user.jpg"> <h4>Aniket</h4> </div> </li>
        </ul>
    </nav>
    <?php } else { ?>
    <!-- Employee NavBar Code Below -->
    <nav class="navigation-icons-bar">
        <ul>
          <li><a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
          <li><a href="#"><i class="fa fa-tasks" aria-hidden="true"></i><span>Tasks</span></a></li>
          <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Profile</span></a></li>
          <li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span></a></li>
          <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
          <li><div class="user-p"> <img src="./user.jpg"> <h4>Aniket</h4> </div> </li>
        </ul>
    </nav>
    <?php } ?>

    <label for="checkbox">
      <i id="navbtn" class="fa fa-expand" aria-hidden="true"></i>
    </label>
  </header>

  <div class="body">
  </div>

</body>
</html>
