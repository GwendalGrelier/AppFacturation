#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


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
        liste_devis          Int NOT NULL ,
        nom_societe          Varchar (255) NOT NULL
	,CONSTRAINT client_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: devis
#------------------------------------------------------------

CREATE TABLE devis(
        id              Int  Auto_increment  NOT NULL ,
        articles        Int NOT NULL ,
        remise_com      Float NOT NULL ,
        taux_retard     Float NOT NULL ,
        date_echeance   Date NOT NULL ,
        num_facture     Int NOT NULL ,
        date_creation   Date NOT NULL ,
        statut_valider  Bool NOT NULL ,
        date_validation Date NOT NULL ,
        id_client       Int NOT NULL
	,CONSTRAINT devis_PK PRIMARY KEY (id)

	,CONSTRAINT devis_client_FK FOREIGN KEY (id_client) REFERENCES client(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: facture
#------------------------------------------------------------

CREATE TABLE facture(
        id       Int  Auto_increment  NOT NULL ,
        id_devis Int NOT NULL
	,CONSTRAINT facture_PK PRIMARY KEY (id)

	,CONSTRAINT facture_devis_FK FOREIGN KEY (id_devis) REFERENCES devis(id)
	,CONSTRAINT facture_devis_AK UNIQUE (id_devis)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: article
#------------------------------------------------------------

CREATE TABLE article(
        id     Int  Auto_increment  NOT NULL ,
        nom    Varchar (255) NOT NULL ,
        qty    Int NOT NULL ,
        prix_u Float NOT NULL
	,CONSTRAINT article_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: liste_article
#------------------------------------------------------------

CREATE TABLE liste_article(
        id         Int NOT NULL ,
        id_article Int NOT NULL
	,CONSTRAINT liste_article_PK PRIMARY KEY (id,id_article)

	,CONSTRAINT liste_article_devis_FK FOREIGN KEY (id) REFERENCES devis(id)
	,CONSTRAINT liste_article_article0_FK FOREIGN KEY (id_article) REFERENCES article(id)
)ENGINE=InnoDB;

