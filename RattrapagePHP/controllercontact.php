<?php
use Doctrine\ORM\EntityManagerInterface;// Fictif
use App\Entity\Contact; // Fictif


// src/controllers/contactcontroller.php
class ContactController {
    private $entityManager;
    private $uploadService;

    public function __construct(EntityManagerInterface $entityManager, UploadService $uploadService) {
        $this->entityManager = $entityManager;
        $this->uploadService = $uploadService;
    }

    public function traiterFormulaireContact() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Récupération des données du formulaire
            $titre = $_POST['titre'];
            $email = $_POST['email'];
            $commentaire = $_POST['commentaire'];
    
            // Traitement de l'upload de la pièce jointe
            $nomFichier = $this->uploadService->upload($_FILES['piece_jointe'], "uploads/");
    
            if ($nomFichier !== null) {
                // Création de l'entité Contact
                $contact = new Contact();
                $contact->setTitre($titre);
                $contact->setEmail($email);
                $contact->setCommentaire($commentaire);
                $contact->setAttachment($nomFichier);
    
                // Persistance de l'entité Contact
                $this->entityManager->persist($contact);
                $this->entityManager->flush();
    
                // Redirection vers une page de confirmation
                header("Location: confirmation.php");
                exit();
            } else {
                // Gestion des erreurs d'upload de fichier
                echo "Une erreur s'est produite lors du téléchargement du fichier.";
            }
        }
    }   
}

