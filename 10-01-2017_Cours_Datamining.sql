SELECT IdH, Prix, Distance, NbEt
FROM Hotel h1
WHERE NOT EXISTS (SELECT * FROM Hotel h2
					WHERE h2.Prix <= h1.Prix AND h2.Distance <= h1.Distance AND h2.nbEt >= h1.nbEt
					AND ( h2.Prix < h1.Prix OR h2.Distance < h1.Distance OR h2.nbEt > h1.nbEt)
				);

CREATE VIEW Min_Prix AS SELECT MIN(Prix) Min_Prix FROM hotel_sky;
CREATE VIEW Min_Distance AS SELECT MIN(Distance) Min_Distance FROM hotel_sky;
CREATE VIEW Max_NbEt AS SELECT MAX(NbEt) Max_NbEt FROM hotel_sky;

CREATE VIEW Max_Prix AS SELECT MAX(Prix) Min_Prix FROM hotel_sky;
CREATE VIEW Max_Distance AS SELECT MAX(Distance) Min_Distance FROM hotel_sky;
CREATE VIEW Min_NbEt AS SELECT MIN(NbEt) Max_NbEt FROM hotel_sky;

CREATE VIEW hotel_norm AS SELECT IdH,
Min_Prix / Prix Prix_norm,
Min_Distance / Distance Distance_norm,
NbEt/Max_NbEt  NbEt_norm
FROM hotel_sky, Min_Prix, Min_Distance, Max_NbEt;

CREATE VIEW hotel_pond AS
SELECT IdH, TRUNCATE(0.5*Prix_norm, 3) Prix_pond, TRUNCATE(0.25*Distance_norm, 2) Distance_pond,
TRUNCATE(0.25*NbEt_norm, 3) NbEt_pond
FROM hotel_norm;

CREATE VIEW hotel_score AS
SELECT IdH, Prix_pond, Distance_pond, NbEt_pond,
TRUNCATE((Prix_pond+Distance_pond+NbEt_pond), 3) Score
FROM hotel_pond;

SELECT Hotel.IdH, Hotel.Prix, Hotel.NbEt, hotel_score.Score
FROM Hotel, hotel_score
WHERE Hotel.IdH = hotel_score.IdH
ORDER BY hotel_score.Score DESC;

ALTER VIEW hotel_sky AS SELECT IdH, Prix, Distance, NbEt
                        FROM Hotel h1
                        WHERE NOT EXISTS (SELECT * FROM Hotel h2
                        WHERE h2.Prix <= h1.Prix AND h2.Distance <= h1.Distance AND h2.nbEt >= h1.nbEt
                              AND ( h2.Prix < h1.Prix OR h2.Distance < h1.Distance OR h2.nbEt > h1.nbEt)
                        );

CREATE VIEW The_Prix AS SELECT MIN(Prix) The_Prix FROM hotel_sky;
CREATE VIEW The_Distance AS SELECT MIN(Distance) The_Distance FROM hotel_sky;
CREATE VIEW The_NbEt AS SELECT MAX(NbEt) The_NbEt FROM hotel_sky;

ALTER VIEW hotel_norm AS SELECT IdH,
                           The_Prix / Prix Prix_norm,
                           The_Distance / Distance Distance_norm,
                           NbEt/The_NbEt  NbEt_norm
                         FROM hotel_sky, The_Prix, The_Distance, The_NbEt;

SELECT * FROM hotel_norm;

