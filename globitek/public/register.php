<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

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
		$fields = ["first_name", "last_name", "email", "username", "password"];
		
		foreach($fields as $field) {
			//check all fields are present and filled
			if(is_blank($_POST[$field])) {
				return false;
			}
			
			//check all fields are less than 255 chars long
			if(!has_length($_POST[$field], ['max' => 255])) {
				return false;
			}
		}
		
		//first and last name should have at least 2 characters
		if(!has_length($_POST["first_name"], ['min' => 2])) {
			return false;
		}
		//separate just in case we need to differentiate between the two later
		if(!has_length($_POST["last_name"], ['min' => 2])) {
			return false;
		}
		
		//username should have at least 8 characters
		if(!has_length($_POST["username"], ['min' => 8])) {
			return false;
		}
		
		//email should contain "@"
		if(!has_valid_email_format($_POST["email"])) {
			return false;
		}
		
		return true;
	}
  ?>

  <?php 
  if(is_post_request()) {?>
	  post
  <?php
	if(isValidForm()){ ?>
	valid form submitted
	<?php }
  } ?>
  <!-- TODO: HTML form goes here -->
  <form action="register.php" method="post">
  <label for="firstname">First Name</label>
  <input type="text" name="first_name" value="" id="firstname" />
  <label for="lastname">Last Name</label>
  <input type="text" name="last_name" value="" id="lastname"/><br />
  <label for="email">E-mail</label>
  <input type="text" name="email" value="" id="email"/><br />
  <label for="username">Username</label>
  <input type="text" name="username" value="" id="username"/><br />
  <label for="password">Password</label>
  <input type="password" name="password" value="" id="password"/><br />
  <br />
  <input type="submit" name="submit" value="Submit" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
