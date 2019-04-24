    use EenmaalAndermaal


    alter table Bestand
        add constraint FK_BESTAND_REF_VOORWERP foreign key (VoorwerpNummer)
            references Voorwerp (VoorwerpNummer)
            on update cascade on delete no action
    go

    alter table Bod
        add constraint FK_BOD_REF_VOORWERP foreign key (VoorwerpNummer)
            references Voorwerp (VoorwerpNummer)
            on update cascade on delete no action
    go

    -- alter table Bod
    --     add constraint FK_BOD_REF_GEBRUIKER foreign key (Gebruikersnaam)
    --         references Gebruiker (Gebruikersnaam)
    --         on update cascade on delete no action
    -- go

    alter table Feedback 
        add constraint FK_FEEDBACK_REF_VOORWERP foreign key (VoorwerpNummer)
            references Voorwerp (VoorwerpNummer)
            on update cascade on delete no action
    go

    alter table Gebruiker
        add constraint FK_GEBRUIKER_REF_VRAAG foreign key (Vraagnummer)
            references Vraag (Vraagnummer)
            on update cascade on delete no action
    go
            
    alter table Gebruikerstelefoon
        add constraint FK_GEBRUIKERSTELEFOON_REF_GEBRUIKER foreign key (Gebruikersnaam)
            references Gebruiker (Gebruikersnaam)
            on update cascade on delete no action
    go

    alter table Rubriek
        add constraint FK_RUBRIEK_REF_RUBRIEK foreign key (Rubriek) 
            references Rubriek (rubrieknummer)
            on update no action on delete no action
    go

    alter table Verkoper
        add constraint FK_VERKOPER_REF_GEBRUIKER foreign key (Gebruikersnaam)
            references Gebruiker (Gebruikersnaam)
            on update cascade on delete no action
    go
    
    -- alter table Voorwerp
    --     add constraint FK_VOORWERP_REF_VERKOPER foreign key (Verkoper) 
    --     references Verkoper (Gebruikersnaam)
    --     on update cascade on delete no action
    -- go    

    alter table Voorwerp
        add constraint FK_VOORWERP_REF_GEBRUIKER foreign key (Koper)
        references Gebruiker (Gebruikersnaam)
        on update cascade on delete no action
    go
   
    alter table VoorwerpInRubriek
        add constraint FK_VOORWERPINRUBRIEK_REF_VOORWERP foreign key (Voorwerpnummer)
        references Voorwerp (Voorwerpnummer)
        on update cascade on delete no action
    go

    alter table VoorwerpInRubriek
        add constraint FK_VOORWERKINRUBRIEK_REF_RUBRIEK foreign key (RubriekNummer)
        references Rubriek (Rubrieknummer)
        on update cascade on delete no action
    go