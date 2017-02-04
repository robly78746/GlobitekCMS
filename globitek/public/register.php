<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  
  $first_name = (isset($_POST['first_name'])) ? $_POST['first_name'] : '';
  $last_name = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';
  $email = (isset($_POST['email'])) ? $_POST['email'] : ''; 
  $username = (isset($_POST['username'])) ? $_POST['username'] : ''; 
  $password = (isset($_POST['password'])) ? $_POST['password'] : '';  
  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database

      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);

      //   TODO redirect user to success page

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
	function isValidForm() {
		$errors = [];
		$fields = ["first_name", "last_name", "email", "username", "password"];
		
		$allFieldsPresent = true;
		$allFieldLengthsValid = true;
		foreach($fields as $field) {
			//check all fields are present and filled
			if(is_blank($_POST[$field])) {
				$allFieldsPresent = false;
			}
			
			//check all fields are less than 255 chars long
			if(!has_length($_POST[$field], ['max' => 255])) {
				$allFieldLengthsValid = false;
			}
		}
		
		if($allFieldsPresent === false) {
			array_push($errors, "All fields must be present.");
		}
		
		if($allFieldLengthsValid === false) {
			array_push($errors, "All fields must be no longer than 255 characters long.");
		}
		
		//first and last name should have at least 2 characters
		if(!has_length($_POST["first_name"], ['min' => 2])) {
			array_push($errors, "The first name must be at least 2 characters long.");
		}
		//separate just in case we need to differentiate between the two later
		if(!has_length($_POST["last_name"], ['min' => 2])) {
			array_push($errors, "The last name must be at least 2 characters long.");
		}
		
		//username should have at least 8 characters
		if(!has_length($_POST["username"], ['min' => 8])) {
			array_push($errors, "The username must be at least 8 characters long.");
		}
		
		//email should contain "@"
		if(!has_valid_email_format($_POST["email"])) {
			array_push($errors, "The email must contain \"@\"");
		}
		
		return $errors;
	}
  ?>

  <?php 
  if(is_post_request()) {?>
	  post
  <?php
    $errorList = isValidForm();
	if(empty($errorList)){ ?>
	valid form submitted
	<?php } else { 
		echo display_errors($errorList);
	}
  } ?>
  <!-- TODO: HTML form goes here -->
  <form action="register.php" method="post">
  <label for="firstname">First Name</label>
  <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="firstname" />
  <label for="lastname">Last Name</label>
  <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="lastname"/><br />
  <label for="email">E-mail</label>
  <input type="text" name="email" value="<?php echo $email; ?>" id="email"/><br />
  <label for="username">Username</label>
  <input type="text" name="username" value="<?php echo $username; ?>" id="username"/><br />
  <label for="password">Password</label>
  <input type="password" name="password" value="<?php echo $password; ?>" id="password"/><br />
  <br />
  <input type="submit" name="submit" value="Submit" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
