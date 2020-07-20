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
    <form action="you.php" method="post">
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
  </section>
</body>
</html>