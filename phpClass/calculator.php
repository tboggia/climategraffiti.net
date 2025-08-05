  <!-- 
    Created by: Tommaso Nicholas Boggia
    On: July 27, 2020
    For: PHP Assignment 1
   -->
  <?php 
    $pageTitle = 'Your calculation result';
    include (dirname(__DIR__) . '/phpClass/common/constants.inc.php');
    include (ROOT_PATH . 'common/header.inc.php');
  ?>
  <section class="section">
    <div class="container">
      <h1 class="title">Your calculation result</h1>
      <?php 
        /*
          This page adds the 10 values received from the form on calculator.html.
          The values enter via the $_POST super global variable as strings in an
          array keyed to the name of he input they originated from.

          This script loops through $_POST to add the values to a $nums array and
          add their values, typed to int type, to a $numSum variable.
          
          Weak typing allowed this to also work when values that aren't numbers
          were entered, but since error management is part of good UX, I added 
          non number values to a $notNums array so the user can be informed why 
          their entries weren't processed. 
        */
        $nums = array();
        $numSum = 0;
        $notNums = array();

        foreach ($_POST as $num) {
          // Try is_numeric()?
          if ($num == '0' || (int)$num !== 0) { 
            $nums[] = (int)$num;
            $numSum += $num;
          } else {
            $notNums[] = $num;
          }
        }
      ?>
      <p class="pb-5">Enter up to 10 numbers below, then press the button to add them up.</p>
      <form action="calculator.php" method="post" class="grid grid-calc grid-gap-1">
        <div class="field">
          <label class="label is-sr-only">Number 1: </label>
          <div class="control">
            <input class="input" type="text" name="num1" value="<?php echo $_POST['num1']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 2: </label>
          <div class="control">
            <input class="input" type="text" name="num2" value="<?php echo $_POST['num2']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 3: </label>
          <div class="control">
            <input class="input" type="text" name="num3" value="<?php echo $_POST['num3']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 4: </label>
          <div class="control">
            <input class="input" type="text" name="num4" value="<?php echo $_POST['num4']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 5: </label>
          <div class="control">
            <input class="input" type="text" name="num5" value="<?php echo $_POST['num5']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 6: </label>
          <div class="control">
            <input class="input" type="text" name="num6" value="<?php echo $_POST['num6']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 7: </label>
          <div class="control">
            <input class="input" type="text" name="num7" value="<?php echo $_POST['num7']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 8: </label>
          <div class="control">
            <input class="input" type="text" name="num8" value="<?php echo $_POST['num8']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 9: </label>
          <div class="control">
            <input class="input" type="text" name="num9" value="<?php echo $_POST['num9']; ?>">
          </div>
        </div>
        <div class="field">
          <label class="label is-sr-only">Number 10: </label>
          <div class="control">
            <input class="input" type="text" name="num10" value="<?php echo $_POST['num10']; ?>">
          </div>
        </div>
        <div class="spacer"></div>
        <div class="field has-text-right">
          <div class="control">
            <input class="button is-link" type="submit" value="Add them up">
          </div>
        </div>
      </form>
      <h2 class="title pt-6">Your answer is: <?php echo $numSum; ?></h2>
      <?php
        /* 
          This block only prints if one of the values entered is not a number.
          Interestingly, if the value begins with an integer, it does type to
          an int successfully. e.g. '4Hello' becomes 4, 'Hello4' would be added
          to $notNums.
        */
        if (count($notNums) > 0) {
          $comma = ", ";
          echo "<p>The following values were not counted because they aren't numbers: ";

          foreach ($notNums as $index => $notNum) {
            if ($index + 1 == count($notNums)) { $comma = ''; }
            echo '"'. $notNum . '"' . $comma;
          }
          echo '.</p>';
        }
      ?>
    </div>

  </section>
  <?php include (ROOT_PATH . 'common/footer.inc.php'); ?> 
