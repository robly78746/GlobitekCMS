<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  
  $first_name = (isset($_POST['first_name'])) ? h($_POST['first_name']) : '';
  $last_name = (isset($_POST['last_name'])) ? h($_POST['last_name']) : '';
  $email = (isset($_POST['email'])) ? h($_POST['email']) : ''; 
  $username = (isset($_POST['username'])) ? h($_POST['username']) : ''; 
  $password = (isset($_POST['password'])) ? h($_POST['password']) : '';  
  
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
			array_push($errors, "All fields must be no longer than 255 characters.");
		}
		
		//first and last name should have at least 2 characters
		if(!has_length($_POST["first_name"], ['min' => 2])) {
			array_push($errors, "First name must be at least 2 characters.");
		}
		//separate just in case we need to differentiate between the two later
		if(!has_length($_POST["last_name"], ['min' => 2])) {
			array_push($errors, "Last name must be at least 2 characters.");
		}
		
		//username should have at least 8 characters
		if(!has_length($_POST["username"], ['min' => 8])) {
			array_push($errors, "Username must be at least 8 characters.");
		}
		
		//email should contain "@"
		if(!has_valid_email_format($_POST["email"])) {
			array_push($errors, "The email must be a valid format.");
		}
		
		return $errors;
	}
	
	function submitFormDataToDB($data) {
		$conn = db_connect();
		$fields = '('. implode(',', array_keys($data)). ')';
		$quotedValues = [];
		foreach(array_values($data) as $value) {
			array_push($quotedValues, "'".$value."'");
		}
		$values = " VALUES (". implode(',', $quotedValues) . ');';
		$sql_query = 'INSERT INTO users '. $fields.$values;
		db_query($conn, $sql_query);
		db_close($conn);
	}
  if(is_post_request()) {
    $errorList = isValidForm();
	if(empty($errorList)){ 
		$currentDateTime = date("Y-m-d H:i:s");
		$formFields = ['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'username' => $username, 'created_at' => $currentDateTime];
		submitFormDataToDB($formFields);
		redirect_to("registration_success.php");
	} else { 
		echo display_errors($errorList);
	}
  } ?>
  <!-- TODO: HTML form goes here -->
  <form action="register.php" method="post">
  <label for="firstname">First Name:</label><br />
  <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="firstname" /><br />
  <label for="lastname">Last Name:</label><br />
  <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="lastname"/><br />
  <label for="email">E-mail:</label><br />
  <input type="text" name="email" value="<?php echo $email; ?>" id="email"/><br />
  <label for="username">Username:</label><br />
  <input type="text" name="username" value="<?php echo $username; ?>" id="username"/><br />
  <label for="password">Password:</label><br />
  <input type="password" name="password" value="<?php echo $password; ?>" id="password"/><br />
  <br />
  <input type="submit" name="submit" value="Submit" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
