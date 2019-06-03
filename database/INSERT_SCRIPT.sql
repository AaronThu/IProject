/*==============================================================*/
/* Database name:  iproject2                                    */
/* Script:		   INSDRT                                       */
/* Created on:     13-05-2019		                            */
/*==============================================================*/

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
(11450,'kledingfoto.jpg'),
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
/* Betalingswijzen                                              */
/*==============================================================*/
INSERT Betalingswijzen VALUES('iDeal')

/*==============================================================*/
/* Banken                                                       */
/*==============================================================*/
INSERT Banken VALUES('ABN_Amro')
INSERT Banken VALUES('Rabobank')
INSERT Banken VALUES('ING')
INSERT Banken VALUES('SNS')
INSERT Banken VALUES('Knab')
INSERT Banken VALUES('ASN')
INSERT Banken VALUES('Triodos')

/*
/*==============================================================*/
/* Gebruiker                                                    */
/*==============================================================*/
INSERT Gebruiker VALUES('testgebruiker', 'Voornaam', 'Achternaam', 'Adres1', 'Adres2', 'Postcode', 'Plaatsnaam', 'Nederland', '14-may-2010', 'Emailadres', 'Wachtwoord', 1, 'AntwoordTekst', 'ver')

/*==============================================================*/
/* Verkoper                                                     */
/*==============================================================*/
INSERT Verkoper VALUES(1, 'Bank', 'Rekeningnummer', 'Creditcard', 'Creditcard')

/*==============================================================*/
/* Voorwerp                                                     */
/*==============================================================*/
INSERT INTO Voorwerp 
 (Titel, beschrijving, Startprijs, betalingswijze, Betalingsinstructie, Plaatsnaam, Land, Looptijd, Verzendkosten, Verzendinstructies, VerkopersID)
VALUES
('mooie boot', 'hele mooie boot net nieuw maar toch al genoeg van gehad, toe aan een ander avontuur.', 3500.00, 'iDeal', 'Container', 'Apeldoorn', 'Nederland',  1, 3.95, 'komt zonder aanhanger', 1),
('mooie auto', 'dikke volkswagen golf GTI, met onderhoudshistorie.', 40000.00, 'iDeal', 'Persoonlijk', 'Arnhem', 'Nederland',  1, 2.00, 'met een lege tank', 1),
('mooi vliegtuig', 'oude Boeing 747, snel apparaat kan maximaal 1100kmh.', 950000.00, 'iDeal', 'container', 'Amsterdam', 'Nederland',  1, 1.00, 'komt zonder motoren,', 1),
('mooie laptop', 'Nieuwe laptop, pas 5 jaar in gebruik! erg snel voor toen der tijd!', 295.00, 'iDeal', 'PostNL', 'Groningen', 'Nederland',  1, 1.95, 'met kartonnen doos', 1),
('mooie telefoon', 'De nieuwe iphone X', 10000.00, 'iDeal', 'PostNL', 'Utrecht', 'Nederland',  1, 2.95, 'komt zonder aanhanger', 1),
('mooi huis', 'Dit huis is gelegen in Rotterdam, ajax wordt kampioen dus ik ga naar Amsterdam',350000.00 , 'iDeal', 'iDeal', 'Rotterdam', 'Nederland',  1, 1.95, 'komt zonder aanhanger', 1),
('oplader', 'Voor Iphone en samsung!', 3.95, 'iDeal', 'met de boot', 'Den Haag', 'Nederland',  1, 9.95, 'komt zonder aanhanger', 1),
('ruitenwissers', 'Met deze ruitenwissers kan je wat zien in de regen met je auto!', 20.00, 'iDeal', 'met de boot', 'Breda', 'Nederland',  1, 6.95, 'komt zonder aanhanger', 1),
('antieke klok', 'Klok uit het stenen tijdperk.', 22000.00, 'iDeal', 'met de boot', 'Maastricht', 'Nederland',  1, 9.95, 'komt zonder aanhanger', 1),
('regenjas', 'De beste regenjas op de markt, houdt je droog als het een beetje regent.', 15.00, 'iDeal', 'met de boot', 'Middelburg', 'Nederland',  1, 1.95, 'komt zonder aanhanger', 1),
('tandenborstel', 'Kan je eindelijk je tanden weer poetsen', 100.00, 'iDeal', 'met de boot', 'Haarlem', 'Nederland',  1, 10.00, 'komt zonder aanhanger', 1),
('strijkijzer', 'Mooi strijkijzer, zorgt ervoor dat je je kleren weer recht strijkt!', 60.00, 'iDeal', 'met de boot', 'Spakenburg', 'Nederland',  1, 9.99, 'komt zonder aanhanger', 1),
('wasmachine', 'Grote wasmachine 20KG trommel!', 950.00, 'iDeal', 'PostNL', 'Almere', 'Nederland',  1, 2.50, 'komt zonder aanhanger', 1),
('strijkplank', 'Mooie strijkplank van de Blokker, meerwaarde omdat deze winkel failliet is!', 25.00, 'iDeal', 'PostNL', 'Leeuwarden', 'Nederland',  1, 6.00, 'komt zonder aanhanger', 1),
('koffiezetapparaat', 'Siemens EQ9-S900 WIfi editie, mooi apparaat niet te geloven!', 1399.99, 'iDeal', 'PostNL', 'Den Helder', 'Nederland',  1, 5.00, 'komt zonder aanhanger', 1),
('Pan met vet', 'Mooie pan met gebruikt frituurvet, kan makkelijk nog een rondje of 20!', 50000.00, 'iDeal', 'PostNL', 'Arnhem', 'Nederland', 1, 5.00, null, 1)

/*==============================================================*/
/* Bestand                                                      */
/*==============================================================*/
INSERT INTO  Bestand VALUES
('mooieboot.jpg', 1),
('golfgti.jpg', 2),
('mooievliegtuig.jpg', 3),
('mooielaptop.jpg', 4),
('mooietelefoon.jpg', 5),
('mooihuis.jpg', 6),
('mooieoplader.jpg',7),
('ruitenwissers.jpg',8),
('horloge.jpg', 9),
('mooieregenjas.jpg',10), 
('mooietandenborstel.jpg', 11),
('mooistrijkijzer.jpg', 12),
('mooiewasmachine.jpg', 13),
('mooiestrijkplank.jpg',14),
('mooikoffieding.jpg',15), 
('mooiepanvet.jpg',16)
*/
