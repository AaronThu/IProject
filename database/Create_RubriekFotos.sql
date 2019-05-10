CREATE TABLE RubriekFotos(
Rubrieknummer      INT         NOT NULL,
RubriekFoto        VARCHAR(100) NOT NULL
CONSTRAINT PK_RUBRIEKFOTOS PRIMARY KEY (Rubrieknummer)
)



Insert into RubriekFotos values
(1, 'verzamelfoto.jpeg'),--gedaan
(160,'computerfoto.jpg'),-- gedaan
(220,'speelgoedfoto.jpg'),--gedaan
(260,'postzegelfoto.jpg'),-- gedaan
(267,'boekenstripfoto.jpg'),--gedaan
(281,'sierraadenhorlogefoto.jpg'),--gedaan
(293,'elektronicafoto.png'),--gedaan
(353,'kunstfoto.jpg'),-- gedaan
(888,'sportfoto.jpg'),--gedaan
(1188,'modelbouwfoto.jpg'),--gedaan
(8423,'hobbyfoto.jpg'),--gedaan
(9800,'vervoerfoto.jpg'),--gedaan
(11116,'geldfoto.png'),--gedaan
(11232,'filmfoto.jpg'),--gedaan
(11233,'instrumentenfoto.jpg'),--gedaan
(114500,'kledingfoto.jpg'),--gedaan
(11700,'tuinfoto.jpg'),--gedaan
(12081,'babyfoto.jpg'),--gedaan
(12155,'verzorgingfoto.jpg'),--gedaan
(12576,'industriefoto.jpg'),--gedaan
(14616,'gamefoto.jpg'),--gedaan
(14675,'telecomfoto.jpg')--gedaan

select * from RubriekFotos
