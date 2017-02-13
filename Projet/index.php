<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>form</title>

    <link rel="stylesheet" href="css/screen.css">

</head>
<body>
<main class="container-fluid">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <header class="header">
                    <a class="navbar-brand" href="#">Analyse Multicritères -SkyRankHotel</a>
                </header>
            </div>
        </div>
    </nav>
    <div class="row">
        <div id="content" class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-12">
                    <form id="form" class="form-group" action="php/formthing.php" method="POST">
                        <div class="row inputs">
                            <div class="col-md-2">
                                <h3>Poids</h3>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-placeholder">
                                    <label for="prix" class="control-label">Poids du prix</label>
                                    <input id="prix" class="form-control" name="prix" required="" value="" aria-describedby="addon1" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-placeholder">
                                    <label for="distance" class="control-label">Poids de la distance </label>
                                    <input id="distance" class="form-control" name="distance" required="" value="" aria-describedby="addon2"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-placeholder">
                                    <label for="etoiles" class="control-label">Poids des étoiles</label>
                                    <input id="etoiles" class="form-control" name="etoiles" required="" value="" aria-describedby="addon3"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h3>Preferences</h3>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input id="prix_max" type="radio" name="prix_radio" value="MAX"> Max
                                        </label>
                                        <label>
                                            <input id="prix_min" type="radio" name="prix_radio" value="MIN"> Min
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input id="distance_max" type="radio" name="distance_radio" value="MAX"> Max
                                        </label>
                                        <label>
                                            <input id="distance_min" type="radio" name="distance_radio" value="MIN"> Min
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input id="nbet_max" type="radio" name="nbet_radio" value="MAX"> Max
                                        </label>
                                        <label>
                                            <input id="nbet_min" type="radio" name="nbet_radio" value="MIN"> Min
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="text-center center-block">
                                    <input id="formSubmit" type="submit" value="envoyer" class="btn btn-raised btn-primary btn-lg">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="result_contain">
                        <div id="result"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!--Scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
<script src="js/index.js" type="text/javascript"></script>
</body>
</html>
