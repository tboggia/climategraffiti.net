<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
  <!--https://bulma.io/documentation/helpers/typography-helpers/-->
  <title>Venmo</title>
</head>
<body>
  <section class="section">
    <div class="container">
    <h1 class="title">Who owes Patrick Money?</h1>
    <p>Hi <?php echo htmlspecialchars($_POST['name']); ?>.</p>
    <p>You have owed Patrick $30 for <?php echo (int)$_POST['age']/2; ?> years.</p>
    </form>
  </section>
</body>
</html>