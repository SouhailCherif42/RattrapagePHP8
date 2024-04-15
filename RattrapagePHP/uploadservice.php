<?php

// src/Model/Service/uploadservice.php
class UploadService {
    private $uploadDirectory;

    public function __construct($uploadDirectory) {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function upload($file) {
        $targetFile = $this->uploadDirectory . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Vérification du fichier
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "pdf") {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG, GIF et PDF sont autorisés.";
            $uploadOk = 0;
        }

        // Vérification du dl
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";
            return null;
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return basename($file["name"]);
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                return null;
            }
        }
    }
}

// Utilisation de la classe UploadService
$uploadService = new UploadService("uploads/");
$nomFichier = $uploadService->upload($_FILES['piece_jointe']);
if ($nomFichier !== null) {
    echo "Le fichier a été téléchargé avec succès et enregistré sous le nom : " . $nomFichier;
}

