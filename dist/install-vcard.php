<?php
/***
Installer File for vcard package

sources:
  - Form with multiple steps: https://www.w3schools.com/howto/howto_js_form_steps.asp
  - Unzip file with php: https://stackoverflow.com/questions/8889025/unzip-a-file-with-php
  - Using PHP_SELF in the action field of a form: http://form.guide/php-form/php-form-action-self.html
  - Web-Installer for CMS - Config: https://stackoverflow.com/questions/7858858/web-installer-for-cms-config
  - Style of installer based on wordpress installer
***/

// assuming file.zip is in the same directory as the executing script.
$file = 'vcard_archive.zip';

// get the absolute path to $file
$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

$zip = new ZipArchive;

$res = $zip->open($file);
if ($res === TRUE) {

// extract it to the path we determined above
$zip->extractTo($path);
$zip->close();
$unzipSuccess = 'Your file ' . $file . ' has been extracted to ' . $path . 'woot!';
} else {
$unzipFailed = "Doh! I couldn't open $file";
};

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Install v-card</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <style>
    *:focus {
      outline: none;
    }

    body {
      background-color: #f1f1f1;
      color: #222;
    }

    header {
      text-align: center;
      padding: 16px;
    }

    /* Style the form */
    .card-body {
      background-color: #ffffff;
      margin: 36px auto;
      padding: 40px;
      width: 60%;
      min-width: 300px;
      box-shadow: 0 1px 3px rgba(0,0,0,.13);
    }

    /* Style the input fields */
    input {
      padding: 10px;
      width: 100%;
      font-size: 17px;
      font-family: Raleway;
      border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
      background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
      display: none;
    }

    .row {
      margin-top: 16px;
      /* margin-bottom: 16px; */
    }

    /* Make circles that indicate the steps of the form: */
    .step {
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #222;
      border: none
      border-radius: 50%;
      display: inline-block;
      opacity: 0.5;
    }

    /* Mark the active step: */
    .step.active {
      opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
      background-color: #4CAF50;
    }

    #success {
      display: none;
    }

    #dbsuccess {
      margin: 0 auto;
      text-align: center;
    }

    input[type="submit"] {
      width: auto;
      padding: 0;
      font-family: inherit;
      font-size: inherit;
      line-height: inherit;
    }

    .modal {
      display: block;
      max-width: 790px;
      z-index: 1;
      background: #FFFFFF;
      padding: 45px;
      box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
      /* place vertically center */
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) !important;
    }

    .modal-container {
      z-index: 4;
      display: block;
      padding-top: 100px;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.8);
      box-shadow: 10px 10px 16px 0 rgba(0, 0, 0, 0.1);
    }

    .modal h2 {
      border-bottom: 1px solid #222;
      padding-bottom: 16px;
      margin-bottom: 16px;
    }

    .modal span {
      display: block;
      padding-bottom: 16px;
    }

    .modal .row {
      margin-bottom: 16px;
    }

    .link-theme:hover { opacity: 0.8; text-decoration: none; color: #dfb948;}

    .link-theme:after { display: inline-block; content: '\a0'; position: relative; left: 8px; top: 8px; width: 16px; height: 7px; border-bottom: 1px solid #dfb948; -webkit-transition: width 0.5s ease; transition: width 0.5s ease; }

    .link-theme:hover:after { width: 32px; -webkit-transition: all 0.5s ease; transition: all 0.5s ease; }

    .link-theme { color: #dfb948; cursor: pointer; }

    /* animation */
    .animate-opacity {
    	animation: opac 0.5s
    }

    @keyframes opac {
    	from {
    		opacity: 0
    	}
    	to {
    		opacity: 1
    	}
    }

  </style>

</head>

<body>

  <header>
    <h1>Install V-card</h1>
  </header>

  <div class="card">
    <div class="card-body">

      <!-- Introduction message -->
      <div class="tab intro">
        <p>Welcome to the vcard template. Before getting started, we need some information on the database. You will need to know the following items before proceeding. Create a database on your web host</p>

        <ol>
          <li>Database name</li>
          <li>Database username</li>
          <li>Database password</li>
          <li>Database host</li>
        </ol>

        <p>
          We’re going to use this information to create a database.php file.	If for any reason this automatic file creation doesn’t work, don’t worry. All this does is fill in the database information. You may also simply open database-sample.php in a text editor, fill in your information, and save it as database.php.
        </p>
        <p>
          In all likelihood, these items were supplied to you by your Web Host. If you don’t have this information, then you will need to contact them before you can continue. If you’re all ready…
        </p>
      </div><!-- tab intro -->

      <!-- This is the form that will gather all the informations needed to create the database for the user -->
      <form id="regForm" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <!-- htmlentities() is used to avoid Cross Site Scripting (XSS) commands to be executed. -->

        <!-- STEP 1: Getting the database credentials -->
        <div class="tab">
          <p>Below you should enter your database connection details. If you’re not sure about these, contact your host.</p>

          <div class="row">
            <div class="col-md-4 col-sm-12">
              <label for="dbname">Database Name</label>
            </div>
            <div class="col-md-4 col-sm-12">
              <input name="dbname" id="dbname" type="text" size="25" value="vcard">
            </div>
            <div class="col-md-4 col-sm-12">
              <p>
                The name of the database you want to use with your vcard.
              </p>
            </div>
          </div><!-- end row -->

          <div class="row">
            <div class="col-md-4 col-sm-12">
              <label for="uname">Username</label>
            </div>
            <div class="col-md-4 col-sm-12">
              <input name="uname" id="uname" type="text" size="25" value="username">
            </div>
            <div class="col-md-4 col-sm-12">
              <p>
                Your database username.
              </p>
            </div>
          </div><!-- end row -->

          <div class="row">
            <div class="col-md-4 col-sm-12">
              <label for="dbpwd">Password</label>
            </div>

            <div class="col-md-4 col-sm-12">
              <input name="dbpwd" id="dbpwd" type="text" size="25" value="password" autocomplete="off">
            </div>

            <div class="col-md-4 col-sm-12">
              <p>
                Your database password.
              </p>
            </div>
          </div><!-- end row -->

          <div class="row">
            <div class="col-md-4 col-sm-12">
              <label for="dbhost">Database Host</label>
            </div>
            <div class="col-md-4 col-sm-12">
              <input name="dbhost" id="dbhost" type="text" size="25" value="localhost">
            </div>
            <div class="col-md-4 col-sm-12">
              <p>
                You should be able to get this info from your web host, if <code>localhost</code> doesn’t work.
              </p>
            </div>
          </div><!-- end row -->

        </div>

        <!-- STEP 2: creating admin -> firstname, lastname, email, password) -->
        <!-- <div class="tab">

          <div class="row">
            <div class="col-md-4 col-sm-12">
              <label for="firstName">First Name</label>
            </div>
            <div class="col-md-4 col-sm-12">
              <input name="firstName" id="firstName" type="text" size="25" value="First Name">
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-sm-12">
              <label for="lastName">Last Name</label>
            </div>
            <div class="col-md-4 col-sm-12">
              <input name="lastName" id="lastName" type="text" size="25" value="Last Name">
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-sm-12">
              <label for="email">Your email</label>
            </div>
            <div class="col-md-4 col-sm-12">
              <input name="email" id="email" type="text" size="25" value="email">
            </div>
            <div class="col-md-4 col-sm-12">
              <p>
                Double Check your email address before continuing
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-sm-12">
              <label for="password">Password</label>
            </div>
            <div class="col-md-4 col-sm-12">
              <input name="password" id="password" type="text" size="25" value="password">
            </div>
            <div class="col-md-4 col-sm-12">
              <p>
                Set up the password for your vcard. Please store it in a secure location.
              </p>
            </div>
          </div>

        </div> -->

        <!-- Circles which indicates the steps of the form: -->
        <div style="overflow:auto;">
          <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            <input type="submit" id="js-submit-form" name="submit" value="Submit Form" style="display: none;">
          </div>
        </div><!-- buttons next and previous -->

        <div style="text-align:center;margin-top:40px;">
          <span class="step"></span>
          <span class="step"></span>
          <span class="step"></span>
        </div><!-- dots at the bottom -->

        </form>

      </div><!-- card-body -->
  </div><!-- .card -->

<script>
  var currentTab = 0; // Current tab is set to be the first tab (0)
  showTab(currentTab); // Display the current tab

  function showTab(n) {
    // This function will display the specified tab of the form ...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    // ... and fix the Previous/Next buttons:
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }

    if (n == (x.length - 1)) {
      document.getElementById("nextBtn").style.display = "none";
      document.getElementById("js-submit-form").style.display = "inline";
    } else {
      document.getElementById("nextBtn").style.display = "inline";
      document.getElementById("js-submit-form").style.display = "none";
      document.getElementById("nextBtn").innerHTML = "Next";
    }
    // ... and run a function that displays the correct step indicator:
    fixStepIndicator(n)
  }

  function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
    if (currentTab >= x.length) {
      //...the form gets submitted:
      document.getElementById("regForm").submit();

      return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
  }

  function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
      // If a field is empty...
      if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false:
        valid = false;
      }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
      document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
  }

  function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class to the current step:
    x[n].className += " active";
  }

</script>

</body>
</html>

<?php

if(isset($_POST['submit'])) {

  //Database related
  $dbname     = $_POST['dbname'];
  $uname      = $_POST['uname'];
  $dbpwd      = $_POST['dbpwd'];
  $dbhost     = $_POST['dbhost'];

  //user related
  // $firstName  = $_POST['firstName'];
  // $lastName  = $_POST['lastName'];
  // $email     = $_POST['email'];
  // $password  = $_POST['password'];

  // Creating the tables of database
  try {
      $pdo = new PDO("mysql:host=$dbhost", $uname, $dbpwd);
      // set the PDO error mode to exception
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // $sql = "CREATE DATABASE $dbname;";
      // use exec() because no results are returned
      // $pdo->exec($sql);
      // echo "<span id='dbsuccess'>Database created successfully</span><br>";

      error_reporting(E_ALL);

      $configPage = 'database';

      $newFileName = './application/config/'.$configPage.".php";
      $newFileContent = '<?php /*
       * Database configuration settings used by PDO.
       * This file was automatically created by the install-vcard.php
       */

      $config["dsn"]      = "mysql:host=localhost;dbname=' . $dbname . '";
      $config["password"] = "' . $dbpwd .'";
      $config["user"]     = "' . $uname .'";?>';

      if (file_put_contents($newFileName, $newFileContent) !== false) {
          echo "File created (" . basename($newFileName) . ")";
      } else {
          echo "Cannot create file (" . basename($newFileName) . ")";
      }

  }

  catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'about' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $about = "CREATE TABLE about (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_short varchar(800) NOT NULL,
    content_long varchar(800) NOT NULL,
    residence varchar(40) NOT NULL,
    email varchar(50) NOT NULL,
    job_type varchar(50) NOT NULL,
    job_availability tinyint(1) NOT NULL,
    portfolio_url varchar(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($about);
    // echo "Table about created successfully";
  }

  catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'cover' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $cover = "CREATE TABLE cover (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cover_img varchar(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($cover);
    // echo "</br>Table cover created successfully";
  }

  catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'password_reset' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $passwordReset = "CREATE TABLE password_reset (
      Id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      email varchar(255) DEFAULT NULL,
      selector char(16) DEFAULT NULL,
      token char(64) DEFAULT NULL,
      expires datetime DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($passwordReset);
    // echo "</br>Table password_reset created successfully";
  }

  catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'profile' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $profile = "CREATE TABLE profile (
      id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      profile_img varchar(50) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($profile);
    // echo "</br>Table profile created successfully";
  }

  catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'quotes' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $quotes = "CREATE TABLE quotes (
      id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      quote_content varchar(30) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($quotes);
    // echo "</br>Table quotes created successfully";
  }

  catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'site_description' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $siteDescription = "CREATE TABLE site_description (
      id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      first_name varchar(50) NOT NULL,
      last_name varchar(50) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($siteDescription);
    // echo "</br>Table site_description created successfully";
  }

  catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'social_media' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $socialMedia = "CREATE TABLE social_media (
      id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      social_name varchar(40) NOT NULL,
      social_url varchar(50) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($socialMedia);
    // echo "</br>Table social_media created successfully";
  }

  catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'User' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $user = "CREATE TABLE User (
      Id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `FirstName` varchar(40) NOT NULL,
      `LastName` varchar(20) NOT NULL,
      `Email` varchar(50) NOT NULL,
      `Password` varchar(64) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($user);
    // echo "</br>Table User created successfully";
  }

  catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  // Creating the 'meta' table
  try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $uname, $dbpwd);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $user = "CREATE TABLE meta (
      id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `site_title` varchar(60) NOT NULL,
      `site_description` varchar(300) NOT NULL,
      `site_icon` varchar(50) NOT NULL,
      `google_analytics` varchar(300) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $pdo->exec($user);
    // echo "</br>Table meta created successfully";
  }

  catch(PDOException $e){
      echo $sql . "<br>" . $e->getMessage();
  }

  $pdo = null;

  echo '
    <div class="modal-container">
      <div class="modal animate-opacity">

        <h2>Success</h2>
        <span>Vcard has been installed.</span>
        <ol>
          <li>
            Delete "install-vcard.php" and "vcard_archive.zip" from your directory.
          </li>
          <li>
            Create your administrator account and fill in your content by clicking on the link below.
          </li>
        </ol>

        <a href="./index.php/user" class="link-theme">Create account</a>

      </div>

    </div>';
};

?>
