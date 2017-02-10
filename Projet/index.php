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
            <form class="form-group" action="formthing.php" method="GET">
                <div class="row">
                    <div class="col-md-2">
                        <strong>Poids :</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon" id="addon1">Prix</span> <input id="prix" class="form-control" name="prix" required="" value="Poids du prix" aria-describedby="addon1" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon" id="addon2">Distance</span> <input id="distance" class="form-control" name="distance" required="" value="Poids de la distance" aria-describedby="addon2"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon" id="addon3">Étoiles</span> <input id="etoiles" class="form-control" name="nbet" required="" value="Poids des étoiles" aria-describedby="addon3"/>
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
                                <input type="radio" name="prix_radio" value="MAX"> <label for="prix_max">Max</label>
                                <input type="radio" name="prix_radio" value="MIN"> <label for="prix_min">Min</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="custom-radio">
                                <input type="radio" name="distance_radio" value="MAX"> <label for="distance_max">Max</label>
                                <input type="radio" name="distance_radio" value="MIN"> <label for="distance_min">Min</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="custom-radio">
                                <input type="radio" name="nbet_radio" value="MAX"> <label for="nbet_max">Max</label>
                                <input type="radio" name="nbet_radio" value="MIN"> <label for="nbet_min">Min</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input id="formSubmit" type="submit" value="envoyer" class="btn btn-default">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row" id="result">

    </div>
</div>

<!--Scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/scripts.js" type="text/javascript"></script>
</body>
</html>
