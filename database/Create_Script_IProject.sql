/*==============================================================*/
/* Database name:  EenmaalAndermaal                             */
/* Script:		   DDL                                          */
/* Created on:     23-04-2019		                            */
/*==============================================================*/


use master
go

drop database if exists EenmaalAndermaal
go

/*==============================================================*/
/* Database: EenmaalAndermaal                                   */
/*==============================================================*/
create database EenmaalAndermaal
go

use EenmaalAndermaal
go


/*==============================================================*/
/* Bestand                                                      */
/*==============================================================*/
create table Bestand (
    FileNaam                varchar(255)        not null,       -- naam van de afbeelding
    VoorwerpNummer		    numeric(10)		    not null,       -- het voorwerpnummer
    constraint PK_BESTAND primary key (FileNaam)
)
go


/*==============================================================*/
/* Bod                                                          */
/*==============================================================*/
create table Bod (
    VoorwerpNummer		    numeric(10)		    not null,       -- het voorwerpnummer
    Gebruikersnaam		    varchar(255)	    not null,       -- de gebruikersnaam van de bieder
    Bod_Bedrag			    numeric(7,2)	    not null,       -- het bedrag van het bod
    Bod_Datum			    date			    not null,       -- de datum dat het bod geplaatst is
    Bod_Tijdstip		    time			    not null,       -- het tijdstip dat het bod geplaatst is
    constraint PK_BOD primary key (VoorwerpNummer, Bod_Bedrag)
)
go


/*==============================================================*/
/* Feedback                                                     */
/*==============================================================*/
create table Feedback (
    VoorwerpNummer		    numeric(10)		    not null,       -- het voorwerpnummer
    Soort_Gebruiker		    varchar(2)		    not null,		-- Het type gebruiker dat feedback heeft geplaatst
    Feedback_Soort		    varchar(2)		    not null,		-- De soort feedback
    Feedback_Datum		    date			    not null,		-- De datum dat de feedback is geplaatst
    Feedback_Tijdstip	    time    		    not null,		-- Het tijdstip dat de feedback is geplaatst
    Commentaar			    varchar(max)		    null,		-- Het geplaatste commentaar
    constraint PK_FEEDBACK primary key (Voorwerpnummer,Soort_Gebruiker)
)
go


/*==============================================================*/
/* Gebruiker                                                    */
/*==============================================================*/
create table Gebruiker (
    Gebruikersnaam		    varchar(255)        not null,       -- De gebruikersnaam van koper/verkoper
    Voornaam			    varchar(255)	    not null,	    -- De voornaam van de gebruiker
    Achternaam			    varchar(255)	    not null,	    -- De achternaam van de gebruiker
    Adres_1				    varchar(255)	    not null,	    -- Het eerste adres
    Adres_2				    varchar(255)	        null,	    -- het tweede adres
    Postcode			    varchar(7)          not null,	    -- De postcode van de gebruiker
    Plaatsnaam			    varchar(255)	    not null,	    -- De plaats waar de gebruiker woont
    Land				    varchar(255)	    not null,   	-- Het land waar de gebruiker woont
    Geboortedatum		    date			    not null,       -- De geboortedatum van de gebruiker
    Emailadres			    varchar(255)	    not null,       -- Het e-mailadres van de gebruiker
    Wachtwoord			    varchar(255)	    not null,	    -- Het wachtwoord van de gebruiker
    Vraagnummer			    numeric(2)		    not null,	    -- De geheime vraag als dubbele authenticatie
    Antwoord_Tekst		    varchar(max)	    not null,	    -- Het antwoord op de geheime vraag 
    Verkoper			    bit     		    not null,	    -- Is een gebruiker koper/verkoper
    constraint PK_GEBRUIKER primary key (Gebruikersnaam)
)
go

/*==============================================================*/
/* Gebruikerstelefoon                                           */
/*==============================================================*/
create table Gebruikerstelefoon (
    Volgnr				    numeric(2)		    not null,       -- Het volgnr van telefoonnummer van gebruikers
    Gebruikersnaam		    varchar(255)	    not null,	    -- De koppeling aan gebruiker
    Telefoonnummer		    varchar(255)	    not null,	    -- Het telefoonnummer van een gebruiker
    constraint PK_GEBRUIKERSTELEFOON primary key (Volgnr,Gebruikersnaam)
)
go

/*==============================================================*/
/* Rubriek                                                      */
/*==============================================================*/
create table Rubriek (
    Rubrieknummer		    numeric(10)         not null,       -- Het rubrieknummer voor voorwerpen
    Rubrieknaam			    varchar(255)        not null,	    -- De naam van het rubrieknummer
    Rubriek				    numeric(10)             null,       -- De rubriek waarin dit valt
    Volgnr				    numeric(2)          not null,	    -- Het volgnr van het rubriek
    primary key (Rubrieknummer)
)
go


/*==============================================================*/
/* Verkoper                                                     */
/*==============================================================*/
create table Verkoper (
    Gebruikersnaam		    varchar(255)        not null,       -- De gebruikersnaam van de verkoper
    Bank				    varchar(255)            null,	    -- De bank van de verkoper
    Rekeningnummer		    varchar(255)		    null,	    -- Het rekeningnummer van de verkoper
    Controleoptienaam	    varchar(255)        not null,	    -- De verschillende opties om de verkoper te controleren
    Creditcardnummer	    varchar(255)            null,	    -- Het creditcardnummer van de verkoper
    constraint PK_VERKOPER primary key (Gebruikersnaam)
)
go


/*==============================================================*/
/* Voorwerp                                                     */
/*==============================================================*/
create table Voorwerp (
    Voorwerpnummer		    numeric(10)         not null,       -- Het voorwerpnummer 
    Titel				    varchar(255)	    not null,	    -- De titel van een voorwerpnummer
    Beschrijving		    varchar(max)	    not null,	    -- De beschrijving van een product
    Startprijs			    numeric(7,2)	    not null,	    -- De startprijs waarmee het voorwerp is begonnen
    Betalingswijze		    varchar(255)	    not null,	    -- De betalingswijze waarop een voorwerp gekocht kan worden
    Betalingsinstructie	    varchar(max)	        null,	    -- Instructie over de manier hoe een klant kan betaling
    Plaatsnaam			    varchar(255)	    not null,	    -- De plaats van het voorwerp
    Landnaam			    varchar(255)	    not null,   	-- Het land waar het voorwerp zich bevindt
    Looptijd			    numeric(3)		    not null,	    -- De looptijd in dagen
    LooptijdBeginDag	    date			    not null,	    -- De datum dat de looptijd is begonnen
    LooptijdBeginTijdstip   time			    not null,	    -- Het tijdstip dat de looptijd is begonnen
    Verzendkosten		    numeric(2,2)	        null,	    -- De verzendkosten die aan het voorwerp verbonden zijn
    Verzendinstructies	    varchar(max)	        null,	    -- De instructie voor het verzenden van een voorwerp
    Verkoper			    varchar(255)	    not null,	    -- Gebruikersnaam
    Koper				    varchar(255)	        null,	    -- Gebruikersnaam	
    LooptijdeindeDag	    date			    not null,	    -- De datum van het einde van de looptijd van een voorwerp
    LooptijdeindeTijdstip   time			    not null,	    -- Het tijdstip van het einde van de looptijd van een voorwerp
    VeilingGesloten		    bit			        not null,	    -- Een ja/nee vraag of de veiling gesloten is
    Verkoopprijs		    numeric(7,2)		    null,       -- De prijs waarvoor een voorwerp verkocht is, in euros.
    constraint PK_VOORWERP primary key (Voorwerpnummer),
)


/*==============================================================*/
/* VoorwerpInRubriek                                            */
/*==============================================================*/
create table VoorwerpInRubriek (
    Voorwerpnummer		    numeric(10)		    not null,	    -- Het voorwerpnummer.
    Rubrieknummer		    numeric(10)		    not null,	    -- Het rubrieknummer van het voorwerp.
    constraint PK_VOORWERPINRUBRIEK primary key (Voorwerpnummer,Rubrieknummer)
)


/*==============================================================*/
/* Vraag                                                        */
/*==============================================================*/
create table Vraag (
    Vraagnummer             numeric(2)		    not null,		-- Het nummer van de vraag die aan de verkoper is gevraagd
    Vraag                   varchar(255)	    not null,		-- De vraag die een koper heeft gesteld
    constraint PK_VRAAG primary key (Vraagnummer)
)