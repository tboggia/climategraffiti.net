<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
  <!--https://bulma.io/documentation/helpers/typography-helpers/-->
  <title>Module 1 Notes</title>
</head>
<body>
  <section class="section">
    <div class="container">
      <h1 class="title">Module 1 Notes</h1>
      <ol>
        <li><a href="#manual">PHP Manual</a></li>
      </ol>
      <h2 id="manual">PHP Manual</h2>
      <h3>Simple prints</h3>
      <p><code>php echo $_SERVER['HTTP_USER_AGENT'];</code></p>
      <p><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
      <p><a href="https://www.php.net/manual/en/reserved.variables.php">Other Reserved Variables</a></p>
      <h3>Simple if block</h3>
      <p>
        <code>
          if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {<br />
          &nbsp;&nbsp;&nbsp;&nbsp;echo 'You are using Internet Explorer.&lt;br /&gt;';<br />
          } else { echo 'You are not using Internet Explorer.&lt;br /&gt;'; }<br />
        </code>
      </p>
      <p>
      <?php 
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
          echo 'You are using Internet Explorer.<br />';
        } else { echo 'You are not using Internet Explorer.<br />'; }
      ?>
      </p>
      <h3>Simple form</h3>
      <form action="action.php" method="post">
        <div class="field">
          <label class="label">Your name: </label>
          <div class="control">
            <input class="input" type="text" name="name"placeholder="Your Name">
          </div>
        </div>
        <div class="field">
          <label class="label">Your age: </label>
          <div class="control">
            <input class="input" type="text" name="age" placeholder="Your Age">
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="button is-link" type="submit" />
          </div>
        </div>
      </form>
      <h3>Variables</h3>
      <code>
        $a_bool = TRUE;   // a boolean<br />
        $a_str  = "foo";  // a string<br />
        $a_str2 = 'foo';  // a string<br />
        $an_int = 12;     // an integer<br />
        <a href="https://www.php.net/manual/en/language.types.array.php">$an_arr</a> = array('1', 2, "$a_bool"); // an indexed array<br />
        $a_map = ["number" => '1',"integer" => 2, "String" => "$a_bool"]; // an associative array <br />
        $restructured_array = array_values($a_map); // a restructured array  <br />
        $nested_array = [$a_map, $an_arr]; // a nested array  <br />
        <br />
        <?php
          error_reporting(E_ALL);
          $a_bool = TRUE;
          $a_str  = "foo";
          $a_str2 = 'foo';
          $an_int = 12;
          $an_arr = ['1', 2, "$a_bool", 'Hello World'];
          $a_map = ["number" => '1',"integer" => 2, "boolean" => "$a_bool", "string" => 'Hello World'];
          $restructured_array = array_values($a_map);
          $nested_array = [$a_map, $an_arr];
        ?>
        echo gettype($a_bool); // prints out: <?php echo gettype($a_bool); ?><br />
        echo var_dump($a_str);  // prints out: <?php echo var_dump($a_str); ?><br />
        echo gettype($an_arr);  // prints out: <?php echo gettype($an_arr); ?><br />
        echo var_dump($an_arr);  // prints out: <?php echo var_dump($an_arr); ?><br />
        echo var_dump($a_map);  // prints out: <?php echo var_dump($a_map); ?><br />
        echo var_dump($restructured_array);  // prints out: <?php echo var_dump($restructured_array); ?><br />
        echo var_dump($nested_array);  // prints out: <?php echo var_dump($nested_array); ?><br />
      </code>
    </div>
  </section>
</body>
</html>