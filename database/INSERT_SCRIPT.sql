/*==============================================================*/
/* Database name:  iproject2                                    */
/* Script:		   INSDRT                                       */
/* Created on:     13-05-2019		                            */
/*==============================================================*/

USE iproject2
GO

/*==============================================================*/
/* RubriekFotos                                                 */
/*==============================================================*/
INSERT INTO RubriekFotos VALUES
(1, 'verzamelfoto.jpeg'),
(160,'computerfoto.jpg'),
(220,'speelgoedfoto.jpg'),
(260,'postzegelfoto.jpg'),
(267,'boekenstripfoto.jpg'),
(281,'sierraadenhorlogefoto.jpg'),
(293,'elektronicafoto.png'),
(353,'kunstfoto.jpg'),
(888,'sportfoto.jpg'),
(1188,'modelbouwfoto.jpg'),
(8423,'hobbyfoto.jpg'),
(9800,'vervoerfoto.jpg'),
(11116,'geldfoto.png'),
(11232,'filmfoto.jpg'),
(11233,'instrumentenfoto.jpg'),
(114500,'kledingfoto.jpg'),
(11700,'tuinfoto.jpg'),
(12081,'babyfoto.jpg'),
(12155,'verzorgingfoto.jpg'),
(12576,'industriefoto.jpg'),
(14616,'gamefoto.jpg'),
(14675,'telecomfoto.jpg')


/*==============================================================*/
/* Bestand                                                      */
/*==============================================================*/
INSERT Vraag VALUES ('Wat is de naam van je geboorteplaats?')
INSERT Vraag VALUES ('Wat is de naam van je eerste huisdier?')
INSERT Vraag VALUES ('Wat is de naam van moeder?')
INSERT Vraag VALUES ('Wat is de naam van je favoriete band?')
INSERT Vraag VALUES ('Wat is je favoriete game?')

/*==============================================================*/
/* Voorwerp                                                     */
/*==============================================================*/
INSERT INTO Voorwerp 
 (Titel, beschrijving, Startprijs, betalingswijze, Betalingsinstructie, Plaatsnaam, Land, Looptijd, Verzendkosten, Verzendinstructies, Verkoper, Koper)
VALUES
('mooie boot', 'hele mooie boot net nieuw maar toch al genoeg van gehad, toe aan een ander avontuur.', 3500.00, 'Ideal', 'Container', 'Apeldoorn', 'Nederland',  1, 3.95, 'komt zonder aanhanger', 'test', 'test'),
('mooie auto', 'dikke volkswagen golf GTI, met onderhoudshistorie.', 40000.00, 'Ideal', 'Persoonlijk', 'Arnhem', 'Nederland',  1, 2.00, 'met een lege tank', 'test', 'test'),
('mooi vliegtuig', 'oude Boeing 747, snel apparaat kan maximaal 1100kmh.', 950000.00, 'Amex', 'container', 'Amsterdam', 'Nederland',  1, 1.00, 'komt zonder motoren,', 'test', 'test'),
('mooie laptop', 'Nieuwe laptop, pas 5 jaar in gebruik! erg snel voor toen der tijd!', 295.00, 'ideal', 'PostNL', 'Groningen', 'Nederland',  1, 1.95, 'met kartonnen doos', 'test', 'test'),
('mooie telefoon', 'De nieuwe iphone X', 10000.00, 'afterpay', 'PostNL', 'Utrecht', 'Nederland',  1, 2.95, 'komt zonder aanhanger', 'test', 'test'),
('mooi huis', 'Dit huis is gelegen in Rotterdam, ajax wordt kampioen dus ik ga naar Amsterdam',350000.00 , 'Luchtpost', 'Ideal', 'Rotterdam', 'Nederland',  1, 1.95, 'komt zonder aanhanger', 'test', 'test'),
('oplader', 'Voor Iphone en samsung!', 3.95, 'Amex', 'met de boot', 'Den Haag', 'Nederland',  1, 9.95, 'komt zonder aanhanger', 'test', 'test'),
('ruitenwissers', 'Met deze ruitenwissers kan je wat zien in de regen met je auto!', 20.00, 'Ideal', 'met de boot', 'Breda', 'Nederland',  1, 6.95, 'komt zonder aanhanger', 'test', 'test'),
('antieke klok', 'Klok uit het stenen tijdperk.', 22000.00, 'Handje contantje', 'met de boot', 'Maastricht', 'Nederland',  1, 9.95, 'komt zonder aanhanger', 'test', 'test'),
('regenjas', 'De beste regenjas op de markt, houdt je droog als het een beetje regent.', 15.00, 'Ideal', 'met de boot', 'Middelburg', 'Nederland',  1, 1.95, 'komt zonder aanhanger', 'test', 'test'),
('tandenborstel', 'Kan je eindelijk je tanden weer poetsen', 100.00, 'afterpay', 'met de boot', 'Haarlem', 'Nederland',  1, 10.00, 'komt zonder aanhanger', 'test', 'test'),
('strijkijzer', 'Mooi strijkijzer, zorgt ervoor dat je je kleren weer recht strijkt!', 60.00, 'Amex', 'met de boot', 'Spakenburg', 'Nederland',  1, 9.99, 'komt zonder aanhanger', 'test', 'test'),
('wasmachine', 'Grote wasmachine 20KG trommel!', 950.00, 'Amex', 'PostNL', 'Almere', 'Nederland',  1, 2.50, 'komt zonder aanhanger', 'test', 'test'),
('strijkplank', 'Mooie strijkplank van de Blokker, meerwaarde omdat deze winkel failliet is!', 25.00, 'Afterpay', 'PostNL', 'Leeuwarden', 'Nederland',  1, 6.00, 'komt zonder aanhanger', 'test', 'test'),
('koffiezetapparaat', 'Siemens EQ9-S900 WIfi editie, mooi apparaat niet te geloven!', 1399.99, 'Ideal', 'PostNL', 'Den Helder', 'Nederland',  1, 5.00, 'komt zonder aanhanger', 'test', 'test'),
('Pan met vet', 'Mooie pan met gebruikt frituurvet, kan makkelijk nog een rondje of 20!', 50000.00, 'iDeal', 'PostNL', 'Arnhem', 'Nederland', 1, 5.00, null, 'test', 'test')


/*==============================================================*/
/* Bestand                                                      */
/*==============================================================*/
INSERT INTO  Bestand VALUES
('mooieboot.jpg', 8),
('golfgti.jpg', 9),
('mooievliegtuig.jpg', 10),
('mooielaptop.jpg', 11),
('mooietelefoon.jpg', 12),
('mooihuis.jpg', 13),
('mooieoplader.jpg',16),
('ruitenwissers.jpg',17),
('horloge.jpg', 18),
('mooieregenjas.jpg',19), 
('mooietandenborstel.jpg', 20),
('mooistrijkijzer.jpg', 21),
('mooiewasmachine.jpg', 22),
('mooiestrijkplank.jpg',23),
('mooikoffieding.jpg',24), 
('mooiepanvet.jpg',25)