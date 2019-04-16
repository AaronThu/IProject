-- create database EenmaalAndermaal

use EenmaalAndermaal

--drop database EenmaalAndermaal


create table Bestand			(
File_Name			varchar(13)		not null,	 --naam van de afbeelding
VoorwerpNummer		numeric(10)		not null,		 -- het voorwerpnummer

primary key (File_Name)
) 

create table Bod		(
VoorwerpNummer		numeric(10)		not null,		-- het voorwerpnummer
Gebruikersnaam		varchar(255)	not null,		--de gebruikersnaam van de bieder
Bod_Bedrag			varchar(5)		not null,		-- het bedrag van het bod
Bod_Datum			date			not null,		-- de datum dat het bod geplaatst is
Bod_Tijdstip		time			not null,		-- het tijdstip dat het bod geplaatst is

Primary key (VoorwerpNummer,Bod_Bedrag)

)

create table Feedback			(
VoorwerpNummer		numeric(10)		not null,		-- het voorwerpnummer
Soort_Gebruiker		varchar(8)		not null,		-- Het type gebruiker dat feedback heeft geplaatst
Feedback_Soort		varchar(8)		not null,		-- De soort feedback
Feedback_Datum		date			not null,		-- De datum dat de feedback is geplaatst
Feedback_Tijdstip	varchar(8)		not null,		-- Het tijdstip dat de feedback is geplaatst
Commentaar			varchar(max)		null,		-- Het geplaatste commentaar

primary key (Voorwerpnummer,Soort_Gebruiker)


)



create table Gebruiker			(
Gebruikersnaam		varchar(255)		not null,	-- De gebruikersnaam van koper/verkoper
Voornaam			varchar(10)			not null,	-- De voornaam van de gebruiker
Achternaam			varchar(10)			not null,	-- De achternaam van de gebruiker
Adres_1				varchar(10)			not null,	-- Het eerste adres
Adres_2				varchar(15)				null,	-- het tweede adres
Postcode			varchar(15)			not null,	-- De postcode van de gebruiker
Plaatsnaam			varchar(15)			not null,	-- De plaats waar de gebruiker woont
Land				varchar(10)			not null,	-- Het land waar de gebruiker woont
GeboorteDatum		date				not null,	-- De geboortedatum van de gebruiker
Emailadres			varchar(255)		not null,	-- Het e-mailadres van de gebruiker
Wachtwoord			varchar(255)		not null,	-- Het wachtwoord van de gebruiker
Vraagnummer			numeric(3)			not null,	-- De geheime vraag als dubbele authenticatie
Antwoord_tekst		varchar(max)		not null,	-- Het antwoord op de geheime vraag 
Verkoper			char(3)				not null,	-- Is een gebruiker koper/verkoper

primary key (Gebruikersnaam),
)


create table Gebruikerstelefoon	(
Volgnr				numeric(2)			not null,	-- Het volgnr van telefoonnummer van gebruikers
Gebruikersnaam		varchar(255)		not null,	-- De koppeling aan gebruiker
Telefoonnummer		char(11)			not null,	-- Het telefoonnummer van een gebruiker

primary key (volgnr,gebruikersnaam)

)


create table Rubriek			(
Rubrieknummer		numeric(3)			not null,	-- Het rubrieknummer voor voorwerpen
Rubrieknaam			varchar(24)			not null,	-- De naam van het rubrieknummer
Rubriek				numeric(3)				null,	-- De rubriek waarin dit valt
Volgnr				numeric(2)			not null,	-- Het volgnr van het rubriek

primary key (Rubrieknummer),
)

create table Verkoper			(
Gebruikersnaam		varchar(255)		not null,	-- De gebruikersnaam van de verkoper
Bank				varchar(255)			null,	-- De bank van de verkoper
Rekeningnummer		varchar(255)			null,	-- Het rekeningnummer van de verkoper
Controleoptienaam	varchar(255)		not null,	-- De verschillende opties om de verkoper te controleren
Creditcardnummer	varchar(255)			null,	-- Het creditcardnummer van de verkoper

primary key (gebruikersnaam),
)


create table Voorwerp			(
Voorwerpnummer		numeric(10)		not null,		-- Het voorwerpnummer 
Titel				varchar(255)	not null,		-- De titel van een voorwerpnummer
Beschrijving		varchar(max)	not null,		-- De beschrijving van een product
Startprijs			numeric(10)		not null,		-- De startprijs waarmee het voorwerp is begonnen
Betalingswijze		varchar(9)		not null,		-- De betalingswijze waarop een voorwerp gekocht kan worden
Betalingsinstructie	varchar(max)	not null,		-- Instructie over de manier hoe een klant kan betaling
Plaatsnaam			varchar(20)		not null,		-- De plaats van het voorwerp
Landnaam			varchar(20)		not null,		-- Het land waar het voorwerp zich bevindt
Looptijd			numeric(3)		not null,		-- De looptijd in dagen
LooptijdBeginDag	date			not null,		-- De datum dat de looptijd is begonnen
LooptijdBeginTijdstip time			not null,		-- Het tijdstip dat de looptijd is begonnen
Verzendkosten		numeric(10)			null,		-- De verzendkosten die aan het voorwerp verbonden zijn
Verzendinstructies	varchar(max)		null,		-- De instructie voor het verzenden van een voorwerp
Verkoper			varchar(255)	not null,		-- Gebruikersnaam
Koper				varchar(255)		null,		-- Gebruikersnaam	
LooptijdeindeDag	date			not null,		-- De datum van het einde van de looptijd van een voorwerp
LooptijdeindeTijdstip time			not null,		-- Het tijdstip van het einde van de looptijd van een voorwerp
VeilingGesloten		char(3)			not null,		-- Een ja/nee vraag of de veiling gesloten is
Verkoopprijs		char(5)				null,		-- De prijs waarvoor een voorwerp verkocht is, in euros.

primary key (voorwerpnummer),
)


create table VoorwerpInRubriek	(
Voorwerpnummer		numeric(10)			not null,	-- Het voorwerpnummer.
Rubrieknummer		numeric(3)			not null,	-- Het rubrieknummer van het voorwerp.

primary key (Voorwerpnummer,rubrieknummer)

)

create table Vraag				(
Vraagnummer			numeric(3)		not null,		-- Het nummer van de vraag die aan de verkoper is gevraagd
Vraag				varchar(255)	not null,		-- De vraag die een koper heeft gesteld

primary key (vraagnummer)
)

