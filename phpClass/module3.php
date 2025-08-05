<!-- 
  Created by: Tommaso Nicholas Boggia
  On: July 27, 2020
  For: PHP Assignment 1
 -->
<?php 
  $pageTitle = 'Module 3 Playpen';
  include (dirname(__DIR__) . '/phpClass/common/constants.inc.php');
  include (ROOT_PATH . 'common/header.inc.php');
?>
<section class="section">
  <div class="container">
    <h1 class="title"><?php echo $pageTitle;?></h1>
    <?php 
      $ourFileName = "test.txt";
      // r - read (if it exists)
      // r+ read (if it exists); written to (if it exists) (new data writes over existing data)
      // a appended with new data; created if it doesn't exist
      // a+ appended with new data; created if it doesn't exist; read
      // w written to (new data writes over existing data); created if it doesn't exist
      // w+ written to (new data writes over existing data); created if it doesn't exist; read
      $ourFileHandle = fopen($ourFileName, 'a') or die("Can't Open File");
      $stringData = "\nWhat in the worlds\n";
      fwrite($ourFileHandle, $stringData);
      $stringData = "Purple trees\n";
      fwrite($ourFileHandle, $stringData);
      fclose($ourFileHandle);
      $DB_host  = "localhost";
      $DB_user = "admin";
      $DB_pass = "admin";
      $DB_name = "example";
      $DB_connection = mysql_connect($DB_host, $DB_user, $DB_pass) or die(mysql_error());
        echo "Connected to MySQL<br />"; 
      mysql_close($DB_connnection);
    ?>
    <?php include(ROOT_PATH . "test.txt"); ?> 
  </div>
</section>
<?php include (ROOT_PATH . 'common/footer.inc.php'); ?> 
