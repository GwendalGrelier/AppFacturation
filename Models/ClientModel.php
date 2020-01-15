<?php
    
    class ClientModel extends Model {

        /**
         * Ajout d'un client à la BDD
         *
         * @return void
         */
        public function addClientToDB() {
            $id = $_POST['id'];
            $adresse_postale = $_POST['adresse_postale'];
            $adresse_electronique = $_POST['adresse_electronique'];
            $n_tva = $_POST['n_tva'];
            $siret = $_POST['siret'];
            $notes = $_POST['notes'];
            $nom_societe = $_POST['nom_societe'];

            $requete = $this->connexion->prepare("INSERT INTO client VALUES (NULL, :adresse_postale, :adresse_electronique, :n_tva, :siret, :notes, :nom_societe)");
            $requete->bindParam(':adresse_postale', $adresse_postale);
            $requete->bindParam(':adresse_electronique', $adresse_electronique);
            $requete->bindParam(':n_tva', $n_tva);
            $requete->bindParam(':siret', $siret);
            $requete->bindParam(':notes', $notes);
            $requete->bindParam(':nom_societe', $nom_societe);
            $result = $requete->execute();
        }

    /**
         * Suppression d'un client de la BDD à partir de son id
         *
         * @return void
         */
        public function deleteClientFromDB() {
            
            // suppression du client
            $id = $_GET['id'];

            $requete = $this->connexion->prepare("DELETE FROM client WHERE id = :id");
            $requete->bindParam(':id', $id);
            $result = $requete->execute();
            
        } 
        
        /**
         * Mise à jour du client dans la table
         *
         * @return void
         */
        public function updateClientToDB() {
            
            // mise à jour du client
            $id = $_POST['id'];
            $adresse_postale = $_POST['adresse_postale'];
            $adresse_electronique = $_POST['adresse_electronique'];
            $n_tva = $_POST['n_tva'];
            $siret = $_POST['siret'];
            $notes = $_POST['notes'];
            $nom_societe = $_POST['nom_societe'];

            $requete = $this->connexion->prepare("UPDATE client 
            SET adresse_postale = :adresse_postale, adresse_electronique = :adresse_electronique, n_tva = :n_tva, siret = :siret, notes = :notes, nom_societe = :nom_societe
            WHERE id = :id");
            
            $requete->bindParam(':id', $id);
            $requete->bindParam(':adresse_postale', $adresse_postale);
            $requete->bindParam(':adresse_electronique', $adresse_electronique);
            $requete->bindParam(':n_tva', $n_tva);
            $requete->bindParam(':siret', $siret);
            $requete->bindParam(':notes', $notes);
            $requete->bindParam(':nom_societe', $nom_societe);
            $result = $requete->execute();
            
            // var_dump($requete->errorInfo());
            // var_dump($result);
        }

        /**
         * Extraction d'un client de la table
         *
         * @return void
         */
        public function getClient() {
            $id = $_GET['id'];
            
            $requete = $this->connexion->prepare("SELECT * FROM client WHERE id = :id");
            $requete->bindParam(':id', $id);
            $result = $requete->execute();
            $client = $requete->fetch(PDO::FETCH_ASSOC);

            // var_dump($client);

            return $client;
        }
    }