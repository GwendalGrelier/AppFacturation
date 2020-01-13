<?php
    
    class DevisModel extends Model {

       public function getDevis($devisID)
       {
           $request = $this->connexion->prepare("SELECT * FROM devis WHERE id=:id");
           $request->bindParam(':id', $devisID);
           
           $result = $request->execute();
           $devis = $request->fetch(PDO::FETCH_ASSOC);
           return $devis;
       }

       public function deleteDevis($devisID)
       {
           $request = $this->connexion->prepare("DELETE FROM devis WHERE id=:id");
           $request->bindParam(':id', $devisID);
           
           $result = $request->execute();
       }
    }