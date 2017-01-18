<?php

    $database = new PDO('mysql:host=localhost;dbname=tryoout;port=3306;charset=utf8', 'root', '');

    $database->exec('DROP VIEW IF EXISTS hotel_sky, hotel_norm, The_Prix, The_Distance, The_NbEt;');

    $database->exec('CREATE VIEW hotel_sky AS SELECT IdH, Prix, Distance, NbEt
                        FROM Hotel h1
                        WHERE NOT EXISTS (SELECT * FROM Hotel h2
                        WHERE h2.Prix <= h1.Prix AND h2.Distance <= h1.Distance AND h2.nbEt >= h1.nbEt
                              AND ( h2.Prix < h1.Prix OR h2.Distance < h1.Distance OR h2.nbEt > h1.nbEt)
                        );');

    $theQuery = $database->prepare('CREATE VIEW The_Prix AS SELECT MIN(Prix) The_Prix FROM hotel_sky;
                                    CREATE VIEW The_Distance AS SELECT MIN(Distance) The_Distance FROM hotel_sky;
                                    CREATE VIEW The_NbEt AS SELECT MAX(NbEt) The_NbEt FROM hotel_sky;');

    $database->exec('CREATE VIEW hotel_norm AS SELECT IdH,
                           The_Prix / Prix Prix_norm,
                           The_Distance / Distance Distance_norm,
                           NbEt/The_NbEt  NbEt_norm
                         FROM hotel_sky, The_Prix, The_Distance, The_NbEt;')

 ?>
<table id="formResult" class="table table-bordered">
    <thead>
        <tr>
            <th>
            IdH
            </th>
            <th>
            Prix
            </th>
            <th>
            Distance
            </th>
            <th>
            NbEt
            </th>
            <th>
            Score
            </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>