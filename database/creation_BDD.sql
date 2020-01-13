#------------------------------------------------------------
# Table: client
#------------------------------------------------------------

CREATE TABLE client(
        id                   Int  Auto_increment  NOT NULL ,
        adresse_postale      Varchar (255) NOT NULL ,
        adresse_electronique Varchar (255) NOT NULL ,
        n_tva                Varchar (255) NOT NULL ,
        siret                Varchar (255) NOT NULL ,
        notes                Varchar (255) NOT NULL ,
        ca_annuel            Int NOT NULL ,
        liste_devis          Int NOT NULL
	,CONSTRAINT client_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: devis
#------------------------------------------------------------

CREATE TABLE devis(
        id            Int  Auto_increment  NOT NULL ,
        articles      Int NOT NULL ,
        remise_com    Float NOT NULL ,
        taux_retard   Float NOT NULL ,
        date_echeance Date NOT NULL ,
        num_facture   Int NOT NULL ,
        id_client     Int NOT NULL
	,CONSTRAINT devis_PK PRIMARY KEY (id)

	,CONSTRAINT devis_client_FK FOREIGN KEY (id_client) REFERENCES client(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: facture
#------------------------------------------------------------

CREATE TABLE facture(
        id               Int  Auto_increment  NOT NULL ,
        data_acceptation Date NOT NULL ,
        id_devis         Int NOT NULL
	,CONSTRAINT facture_PK PRIMARY KEY (id)

	,CONSTRAINT facture_devis_FK FOREIGN KEY (id_devis) REFERENCES devis(id)
	,CONSTRAINT facture_devis_AK UNIQUE (id_devis)
)ENGINE=InnoDB;
