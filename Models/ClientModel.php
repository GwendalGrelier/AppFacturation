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

        /**
         * Get all Devis of clientID from the DB
         * 
         * @param int $clientID
         * @return array $clientDevis
         */
        public function getDevisFromClient($clientID)
        {
            $request = $this->connexion->prepare("SELECT d.*, l.id_article, 
                            a.nom as nom_article, a.qty, a.prix_u, 
                            c.nom_societe as nom_client, c.id as id_client, c.adresse_postale, c.adresse_electronique, 
                            c.n_tva, c.siret, c.notes 
                            FROM `devis` as d 
                            JOIN liste_article as l ON d.id = l.id 
                            JOIN client as c ON d.`id_client` = c.id 
                            JOIN article as a ON a.id = l.id_article 
                            WHERE id_client = :id");    

            
            $request->bindParam(':id', $clientID);
            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            var_dump($request->errorInfo());
            var_dump($result);
            
            $devisList = [];
            $devisIdList = array_unique(array_column($result, "id"));
            foreach ($devisIdList as $id) {
                foreach ($result as $line) {
                    if ($line["id"] == $id) {
                            $devisList[$id]['devis']['id'] = $id; 
                            $devisList[$id]['devis']['remise_com'] = $line['remise_com']; 
                            $devisList[$id]['devis']['taux_retard'] = $line['taux_retard']; 
                            $devisList[$id]['devis']['num_facture'] = $line['num_facture']; 
                            $devisList[$id]['devis']['date_echeance'] = $line['date_echeance']; 
                            $devisList[$id]['devis']['date_creation'] = $line['date_creation']; 
                            $devisList[$id]['devis']['date_validation'] = $line['date_validation']; 
                            $devisList[$id]['devis']['statut_valider'] = $line['statut_valider']; 

                            $devisList[$id]['client']['id_client'] = $line['id_client'];
                            $devisList[$id]['client']['nom_client'] = $line['nom_client'];
                            $devisList[$id]['client']['adresse_postale'] = $line['adresse_postale'];
                            $devisList[$id]['client']['adresse_electronique'] = $line['adresse_electronique'];
                            $devisList[$id]['client']['n_tva'] = $line['n_tva'];
                            $devisList[$id]['client']['siret'] = $line['siret'];
                            $devisList[$id]['client']['notes'] = $line['notes'];

                            $devisList[$id]['liste_articles'][$line['nom_article']] = [ "qty" => $line['qty'],
                                                                                "prix_u" => $line['prix_u']];
                        }                    
                    }
                }
                return $devisList;
        }
    }