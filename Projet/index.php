<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>form</title>

  <link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>
<div class="container-fluid">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <header class="header">Analyse Multicritères -SkyRankHotel</header>
      </div>
    </div>
  </nav>
  <div class="row">
    <div class="col-md-12">
      <form class="form-group" action="formthing.php" method="get">
        <div class="row">
          <div class="col-md-2">
            <strong>Poids :</strong>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon" id="addon1">Prix</span> <input class="form-control" name="poids" required="" value="Poids du prix" aria-describedby="addon1" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon" id="addon2">Distance</span> <input class="form-control" name="distance" required="" value="Poids de la distance" aria-describedby="addon2"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon" id="addon3">Étoiles</span> <input class="form-control" name="nbet" required="" value="Poids des étoiles" aria-describedby="addon3"/>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <strong>Preferences :</strong>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="custom-radio">
                <input type="radio" name="prixRadio" value="MAX"> <label for="prix">Max</label>
                <input type="radio" name="prixRadio" value="MIN"> <label for="prix">Min</label>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="custom-radio">
                <input type="radio" name="distanceRadio" value="MAX"> <label for="distance_max">Max</label>
                <input type="radio" name="distanceRadio" value="MIN"> <label for="distance_min">Min</label>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="custom-radio">
                <input type="radio" name="nbetRadio" value="MAX"> <label for="nbet_max">Max</label>
                <input type="radio" name="nbetRadio" value="MIN"> <label for="nbet_min">Min</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input class="btn btn-default" type="submit" value="Envoyer">
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="row" id="result">

  </div>
</div>

<!--Scripts-->
<script src="js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
