<html>

<! -- Beginning of HTML form-->

<head>
<title> Contact Information </title>
</head>

<body>
<h1>Contact Information</h1>

<h4> <em>Instructions:</em> </h4>
<p>Please enter your name and phone number below for us to reach you at. <br />
<em>*Note phone number should be entered in following format: (XXX) XXX-XXXX</em></p>

<form action="REGEX_PHP_Module2_Discussion.php" method="POST">

<! -- Creating input fields-->

<p>Name: <input type="text" name="name" size="20" placeholder="Example:Bob" /></p>
<p> Phone Number: <input type="text" name="phonenumber" size="20" placeholder="Example: (XXX) XXX-XXXX"/> </p>

<p><input type="submit" name="submit" value="Submit"/> </p>

<input type="hidden" name="completed" value="TRUE"/>

<! -- End of HTML form-->

</form>
</body>
</html>

<?php

// Beginning of PHP script


// Checks for form submission
if (isset($_POST['completed'])) { 

    /* Validate form input - Check to see if name field is not empty
    and phone number matches the right format */

    if (preg_match('/^\([0-9]{3}\)\s[0-9]{3}\-[0-9]{4}$/', $_POST['phonenumber']) && ($_POST['phonenumber']!='(000) 000-0000') &&
    ($_POST['name'])) {

    // Print successful submission   
    echo '<h1>Success!</h1>
    Thank you ' . $_POST['name'] . '! We will be reaching out to you shortly at: ' . $_POST['phonenumber'];

    } else {
    /* Invalid data error shown if name field is empty and phone number doesn't match the proper format */
    echo '<h1>Error!</h1>
    <p class="error"> Please enter a valid name and ensure that your phone number is valid and follows the correct format.</p>';

    } // End of data validation IF conditional

} // End of main isset() IF


//End of PHP script
?>