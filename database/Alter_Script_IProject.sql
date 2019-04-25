USE EenmaalAndermaal
GO

ALTER TABLE Bestand
    ADD CONSTRAINT FK_BESTAND_REF_VOORWERP FOREIGN KEY (VoorwerpNummer)
        REFERENCES Voorwerp (VoorwerpNummer)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE Bod
    ADD CONSTRAINT FK_BOD_REF_VOORWERP FOREIGN KEY (VoorwerpNummer)
        REFERENCES Voorwerp (VoorwerpNummer)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE Bod
    ADD CONSTRAINT FK_BOD_REF_GEBRUIKER FOREIGN KEY (Gebruikersnaam)
        REFERENCES Gebruiker (Gebruikersnaam)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE Feedback
    ADD CONSTRAINT FK_FEEDBACK_REF_VOORWERP FOREIGN KEY (VoorwerpNummer)
        REFERENCES Voorwerp (VoorwerpNummer)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE Gebruiker
    ADD CONSTRAINT FK_GEBRUIKER_REF_VRAAG FOREIGN KEY (Vraagnummer)
        REFERENCES Vraag (Vraagnummer)
        ON UPDATE CASCADE ON DELETE NO ACTION
GO

ALTER TABLE Gebruikerstelefoon
    ADD CONSTRAINT FK_GEBRUIKERSTELEFOON_REF_GEBRUIKER FOREIGN KEY (Gebruikersnaam)
        REFERENCES Gebruiker (Gebruikersnaam)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE Rubriek
    ADD CONSTRAINT FK_RUBRIEK_REF_RUBRIEK FOREIGN KEY (Rubriek)
        REFERENCES Rubriek (Rubrieknummer)
        ON UPDATE NO ACTION ON DELETE NO ACTION
GO

ALTER TABLE Verkoper
    ADD CONSTRAINT FK_VERKOPER_REF_GEBRUIKER FOREIGN KEY (Gebruikersnaam)
        REFERENCES Gebruiker (Gebruikersnaam)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE Voorwerp
    ADD CONSTRAINT FK_VOORWERP_REF_BETALINGSWIJZEN FOREIGN KEY (Betalingswijze)
        REFERENCES Betalingswijzen (BTW_Wijze)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE Voorwerp
    ADD CONSTRAINT FK_VOORWERP_REF_VERKOPER FOREIGN KEY (Verkoper)
        REFERENCES VERKOPER (Gebruikersnaam)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE Voorwerp
    ADD CONSTRAINT FK_VOORWERP_REF_GEBRUIKER FOREIGN KEY (Koper)
        REFERENCES Gebruiker (Gebruikersnaam)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE VoorwerpInRubriek
    ADD CONSTRAINT FK_VOORWERPINRUBRIEK_REF_VOORWERP FOREIGN KEY (VoorwerpNummer)
        REFERENCES Voorwerp (VoorwerpNummer)
        ON UPDATE CASCADE ON DELETE CASCADE
GO

ALTER TABLE VoorwerpInRubriek
    ADD CONSTRAINT FK_VOORWERPINRUBRIEK_REF_RUBRIEK FOREIGN KEY (Rubrieknummer)
        REFERENCES Rubriek (Rubrieknummer)
        ON UPDATE CASCADE ON DELETE CASCADE
GO