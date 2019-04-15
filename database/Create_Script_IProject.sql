use EenmaalAndermaal



create table Bestand			(
File_Name			varchar(13)		not null,
VoorwerpNummer		numeric(10)		not null,

primary key (File_Name)
) 

create table Bod		(
VoorwerpNummer		numeric(10)			not null,
Gebruikersnaam		varchar(255)		not null,
Bod_Bedrag			varchar(5)		not null,
Bod_Datum			varchar(10)		not null,
Bod_Tijdstip		varchar(8)		not null,

Primary key (VoorwerpNummer)
)

create table Feedback			(
VoorwerpNummer		numeric(10)		not null,
Soort_Gebruiker		varchar(8)		not null,
Feedback_Soort		varchar(8)		not null,
Feedback_Datum		date			not null,
Feedback_Tijdstip	varchar(8)		not null,
Commentaar			varchar(12)		null,

primary key (Voorwerpnummer),

)



create table Gebruiker			(
Gebruikersnaam		varchar(255)	not null,
Voornaam			varchar(10)		not null,
Achternaam			varchar(10)		not null,
AdresNaam			varchar(10)		not null,
Adresregel			varchar(15)		not null,
Postcode			varchar(15)		not null,
Plaatsnaam			varchar(15)		not null,
Land				varchar(10)		not null,
GeboorteDatum		date			not null,
Emailadres			varchar(255)	not null,
Wachtwoord			varchar(255)	not null,
Vraagnummer			numeric(3)		not null,
Antwoord_tekst		varchar(255)	not null,
Verkoper			char(3)			not null,

primary key (Gebruikersnaam),
)


create table Gebruikerstelefoon	(
Volgnr				numeric(2)		not null,
Gebruikersnaam		varchar(255)	not null,
Telefoonnummer		char(11)		not null,

primary key (volgnr),
)


create table Rubriek			(
Rubrieknummer		numeric(3)			not null,
Rubrieknaam			varchar(24)			not null,
Rubriek				numeric(3)				null,
Volgnr				numeric(2)			not null,

primary key (Rubrieknummer),
)

create table Verkoper			(
Gebruikersnaam		varchar(255)	 not null,
Bank				varchar(255)		 null,
Rekeningnummer		varchar(255)		 null,
Controleoptienaam	varchar(255)	 not null,
Creditcardnummer	varchar(255)		 null,

primary key (gebruikersnaam),
)


create table Voorwerp			(
Voorwerpnummer		numeric(10)		not null,
Titel				varchar(255)	not null,
Beschrijving		varchar(255)	not null,
Startprijs			numeric(10)		not null,
Betalingswijze		varchar(9)		not null,
Betalingsinstructie	varchar(23)		not null,
Plaatsnaam			varchar(20)		not null,
Landnaam			varchar(20)		not null,
Looptijd			numeric(1)			not null,
LooptijdBeginDag	date			not null,
LooptijdBeginTijdstip time			not null,
Verzendkosten		numeric(10)				null,
Verzendinstructies	varchar(30)			null,
Verkoper			varchar(255)	not null, --Gebruikersnaam
Koper				varchar(255)		null, --Gebruikersnaam	
LooptijdeindeDag	date			not null,
LooptijdeindeTijdstip time			not null,
VeilingGesloten		char(3)			not null,
Verkoopprijs		char(5)				null, --In euro

primary key (voorwerpnummer),
)


create table VoorwerpInRubriek	(
Voorwerpnummer		numeric(10)			not null,
Rubrieknummer		numeric(3)			not null,

primary key (Voorwerpnummer),
)

create table Vraag				(
Vraagnummer			numeric(3)		not null,
Vraag				varchar(255)	not null,

primary key (vraagnummer)
)


