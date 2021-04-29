<?php 

          class Vue {

                    private $fichier;
                    public function __construct($controleur = "") {
                              // La convention de nommage des fichiers vues est : Vue/<$controleur>/index.php
                              $fichier = "Vue/";
                              if ($controleur != "") {
                                        $fichier = $fichier . $controleur . "/";
                              }
                              $this->fichier = $fichier . "index.php";
                    }
                    
                    //affichage du contenu
                    public function generer($donnees) {
                              $vue = $this->genererFichier($this->fichier, $donnees);
                              //var_dump($donnees);
                             print $vue;
                    }
                    
                    // temporisation
                    private function genererFichier($fichier, $donnees) {
                              if (file_exists($fichier)) {
                                        extract($donnees);
                                        //var_dump($action);
                                        ob_start();
                                        require $fichier;
                                        return ob_get_clean();
                              }
                              else {
                                        throw new Exception("Fichier '$fichier' introuvable");
                              }
                    }

          }

?>