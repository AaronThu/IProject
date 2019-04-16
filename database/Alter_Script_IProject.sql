use EenmaalAndermaal

alter table Bestand
add foreign key (VoorwerpNummer) references Voorwerp(VoorwerpNummer);


alter table bod
add foreign key (VoorwerpNummer) references Voorwerp(VoorwerpNummer);

alter table bod
add foreign key (Gebruikersnaam) references Gebruiker(Gebruikersnaam);


alter table Feedback 
ADD foreign key (VoorwerpNummer) references Voorwerp(VoorwerpNummer);

alter table Gebruiker
add foreign key  (Vraagnummer) references Vraag(vraagnummer);

alter table gebruiker
add foreign key  (Gebruikersnaam) references Gebruikerstelefoon(Gebruikersnaam);

Alter table Gebruikerstelefoon
add foreign key (Gebruikersnaam) references Gebruiker(Gebruikersnaam);


Alter table rubriek
add foreign key (Rubriek) references Rubriek(rubrieknummer);


alter table verkoper
add foreign key (gebruikersnaam) references gebruiker(gebruikersnaam);
alter table verkoper
add foreign key (gebruikersnaam)	references Voorwerp(verkoper);


alter table Voorwerp
add foreign key (verkoper) references verkoper(gebruikersnaam);
alter table Voorwerp
add foreign key (koper) references gebruiker(gebruikersnaam);
alter table Voorwerp
add foreign key (voorwerpnummer) references VoorwerpInRubriek(voorwerpnummer);


Alter table voorwerpinRubriek
add foreign key (voorwerpnummer) references voorwerp(voorwerpnummer)
Alter table voorwerpinRubriek
add foreign key (RubriekNummer) references rubriek(rubrieknummer);
