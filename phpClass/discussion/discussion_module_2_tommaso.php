<!-- 
  Created by: Tommaso Nicholas Boggia
  On: July 27, 2020
  For: PHP Assignment 1
 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
  <!--https://bulma.io/documentation/helpers/typography-helpers/-->
  <link rel="stylesheet" href="css/custom.css">
  <title>Regex Sample Code</title>
</head>
<body>
<section class="section" aria-label="Enter your trip data">
  <div class="container">
    <h1 class="title">Regex Sample Code</h1>
<?php
  // validateSSN checks the value against social security number patterns
  function validateSSN($value) {
    // Used https://regexr.com/, one of my favorite sites, for help
    return preg_match('/(?!(000-000-0000))([0-9]{3}-[0-9]{3}-[0-9]{4})/', $value);
  }
  $ssn = $_POST['ssn'];
  // Set the message depending on whether $ssn validates
  $message = validateSSN($ssn) ? "The number you submitted, " . $ssn . " validates." : "The number you submitted, " . $ssn . " does not validate.";
?>

<div class="columns">
  <form method="post" class="column is-half" id="regex">
    <div class="field">
      <label for="ssn" class="label">Social Security Number</label>
      <div class="control">
        <input class="input" id="ssn" name="ssn" type="text" value="<?php echo $_POST['ssn'];?>" required/>
      </div>
    </div>
    <div class="field has-text-right">
      <div class="control">
        <input class="button is-link" type="submit" value="Calculate your impact" id="trip_submit">
      </div>
    </div>
    <input type="hidden" name="submitted" value="TRUE" required/>
  </form>
</div>


  <?php if(isset($_POST['submitted'])):?>
  <div class="column is-half">
    <p class=""><?php echo $message; ?></p>
  </div>
  <?php endif;?>
  </div>
  </div>
</section>

</body>
</html>

<?php 
/** 
Discussion answer:
<p>In Topic 2.9 lecture, it says to use <span class="inlineCode">ereg_replace()<span>&nbsp;</span></span><span>and&nbsp;</span><span class="inlineCode">eregi_replace(), but <a title="ereg_replace PHP docs" href="https://www.php.net/manual/en/function.ereg-replace.php">PHP documentation says they are deprecated and no longer work</a>.</span></p>
<p>&nbsp;</p>
 * 
 */
?>