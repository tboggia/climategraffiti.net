<!-- 
  Created by: Tommaso Nicholas Boggia
  On: July 27, 2020
  For: PHP Assignment 1
 -->
<?php 
  $pageTitle = 'Vehicles and their contributions to the climate crisis';
  include (dirname(__DIR__) . '/phpClass/common/constants.inc.php');
  include (ROOT_PATH . 'common/header.inc.php');
?>
<section class="section" aria-label="Enter your trip data">
  <div class="container">
    <h1 class="title"><?php echo $pageTitle; ?></h1>
<?php
  // Returns s if numerical value is 1
  function pluralize_word($numerical) {
    return $numerical === 1 ? '' : 's';
  }
  // 0 safe fractions
  function divide_values($numerator, $denominator) {
    // echo "<p>Denominator is $denominator</p>";
    return isset($denominator) && $denominator !== 0 ? $numerator/$denominator : 0;
  }
  function check_numeric($possible_num, $false_return = 0) {
    return is_numeric($possible_num) ? $possible_num * 1 : $false_return;
  }

  $name = $_POST['name'];
  $vehicle = $_POST['vehicle'];
  $trip_dist = check_numeric($_POST['trip_dist']);
  $trip_time = check_numeric($_POST['trip_time']);
  $gallons_gas = check_numeric($_POST['gallons_gas']);
  $price_gallon_gas = check_numeric($_POST['price_gallon_gas']);

  $vehicle_mode = $vehicle === 'car' || $vehicle === 'truck' ? 'drives' : 'rides';
  $dist_multiple = pluralize_word($trip_dist);
  $time_multiple = pluralize_word($trip_multiple);
  $gas_multiple = pluralize_word($gallons_gas);
  $miles_per_gallon = divide_values($gallons_gas, $trip_dist);
  $miles_per_hour = divide_values($trip_dist, $trip_time);
  $cost_of_trip = divide_values($gallons_gas, $price_gallon_gas);
?>

<p class="lead">This program invites you to enter information about your vehicle of choice and evaluate it's impact on the climate crisis.</p>
<p>Just enter the values below, click submit, and get your results.</p>
<div class="columns">
  <form method="post" class="column is-half" id="trip_calculator">
    <div class="field">
      <label for="name" class="label">Your name</label>
      <div class="control">
        <input class="input" id="name" name="name" type="text" value="<?php echo $_POST['name'];?>" required/>
      </div>
    </div>
    <div class="field">
      <label for="vehicle" class="label">Select vehicle type: Motorcycle, Car, Truck or Bicycle</label>
      <div  class="select">
        <select id="vehicle" name="vehicle" required>
          <option disabled selected value>-Select a vehicle-</option>
          <option <?php echo $_POST['vehicle'] === 'motorcycle' ? 'selected' : ''; ?> value="motorcycle">Motorcycle</option>
          <option <?php echo $_POST['vehicle'] === 'car' ? 'selected' : ''; ?> value="car">Car</option>
          <option <?php echo $_POST['vehicle'] === 'truck' ? 'selected' : ''; ?> value="truck">Truck</option>
          <option <?php echo $_POST['vehicle'] === 'bicycle' ? 'selected' : ''; ?> value="bicycle">Bicycle</option>
        </select>
      </div>
    </div>
    <div class="field">
      <label for="trip_dist" class="label">Trip distance in miles</label>
      <div class="control">
        <input class="input" id="trip_dist" name="trip_dist" type="text" value="<?php echo $_POST['trip_dist'];?>" required/>
      </div>
    </div>
    <div class="field">
      <label for="trip_time" class="label">Trip time in hours</label>
      <div class="control">
        <input class="input" id="trip_time" name="trip_time" type="text" value="<?php echo $_POST['trip_time'];?>" required/>
      </div>
    </div>
    <div class="field">
      <label for="gallons_gas" class="label">Gallons of gasoline used</label>
      <div class="control">
        <input class="input" id="gallons_gas" name="gallons_gas" type="text" value="<?php echo $_POST['gallons_gas'];?>" required/>
      </div>
    </div>
    <div class="field">
      <label for="price_gallon_gas" class="label">Price of a gallon of gasoline</label>
      <div class="control">
        <input class="input" id="price_gallon_gas" name="price_gallon_gas" type="text" value="<?php echo $_POST['price_gallon_gas'];?>" required/>
      </div>
    </div>
    <div class="spacer"></div>
    <div class="field has-text-right">
      <div class="control">
        <input class="button is-link" type="submit" value="Calculate your impact" id="trip_submit">
      </div>
    </div>
    <input type="hidden" name="submitted" value="TRUE" required/>
  </form>


  <?php if(isset($_POST['submitted'])):?>
  <div class="column is-half">
    <!-- <p class="">Bob drove a car 100 miles in 2.0 hrs using 4 gallons at $2.50 per gallon</p> -->
    <?php echo "<img src=\"images/$vehicle.jpg\" class=\"img-responsive\">"; ?>
    <p class=""><?php echo "$name $vehicle_mode a $vehicle $trip_dist mile$dist_multiple in $trip_time hour$time_multiple using $gallons_gas gallon$gas_multiple at \$$price_gallon_gas per gallon"; ?></p>
    <p class="">Miles per gallon: <?php echo $miles_per_gallon; ?></p>
    <p class="">Miles per hour: <?php echo $miles_per_hour; ?></p>
    <p class="">Cost of trip: $<?php echo $cost_of_trip; ?></p>
  </div>
  <?php endif;?>
  </div>
  </div>
</section>

<?php include (ROOT_PATH . 'common/footer.inc.php'); ?> 

<?php 
/** 
Discussion answer:
<p>In Topic 2.9 lecture, it says to use <span class="inlineCode">ereg_replace()<span>&nbsp;</span></span><span>and&nbsp;</span><span class="inlineCode">eregi_replace(), but <a title="ereg_replace PHP docs" href="https://www.php.net/manual/en/function.ereg-replace.php">PHP documentation says they are deprecated and no longer work</a>.</span></p>
<p>&nbsp;</p>
 * 
 */
?>
<script>
  function validateTripCalc(e) {
    const tripForm = document.forms.trip_calculator;
    const validation = !Number.isNaN(Number.parseInt(tripForm.trip_dist.value))
      && !Number.isNaN(Number.parseInt(tripForm.trip_time.value))
      && !Number.isNaN(Number.parseInt(tripForm.gallons_gas.value))
      && !Number.isNaN(Number.parseInt(tripForm.price_gallon_gas.value));

    if (!validation) {
      e.preventDefault();
      if (!document.getElementById('form_error')) {
        const warning = document.createElement('div');
        warning.id = "form_error";
        warning.innerHTML = '<p class="has-background-danger-light">Please enter numerical values</p>';
        tripForm.insertBefore(warning, document.getElementById('trip_submit').parentElement.parentElement);
      }
    }

    return validation;
  }
  
  document.forms.trip_calculator.trip_submit.addEventListener('click', validateTripCalc);
</script>

