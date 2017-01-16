<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>form</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    
  </head>
  <body>
  <div class="container">
    <header class="header">Analyse Multicritères -SkyRankHotel</header>
    <form class="daForm" action="formthing.php" method="post">
      <label for="poids">Poids</label> <input name="poids" required="" />
    </form>

    <table id="formResult">
      <tr>
        <thead>
        IdH
        </thead>
        <thead>
        Prix
        </thead>
        <thead>
        Distance
        </thead>
        <thead>
        NbEt
        </thead>
        <thead>
        Score
        </thead>
      </tr>
    </table>
  </div>

  <!--Scripts-->
  <script src="js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>
