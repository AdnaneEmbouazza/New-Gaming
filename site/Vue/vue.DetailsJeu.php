<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($jeu->getNomJeu()); ?></title>
    <link rel="stylesheet" href="css/detailsJeu.css">
    <script> // Javascript pour afficher/masquer le formulaire de modification
        function afficherModification(note, commentaire) {
            document.getElementById('form-modification-' + commentaire).style.display = 'block';
        }

        function cacherModification(commentaire) {
            document.getElementById('form-modification-' + commentaire).style.display = 'none';
        }
    </script>
</head>
<body>
<?php include_once __DIR__ . "/header.php"; ?>
<div class="presentation-container">
    <?php if (isset($_SESSION['message'])): // Pour l'affichage du message de confirmation ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['message']) ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['erreur'])): // Pour l'affichage du message d'erreur ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['erreur']) ?>
            <?php unset($_SESSION['erreur']); ?>
        </div>
    <?php endif; ?>

    <div class="jeu-header">
        <div class="jeu-images">
            <h1 class="jeu-titre"><?php echo htmlspecialchars($jeu->getNomJeu()); ?></h1>
            <?php
            $premierMedia = true;
            foreach($mediaImages as $media) { // Gere l'affichage de l'image principale, le booleen $premierMedia permet de ne pas afficher plusieurs fois la même image
                if($media->getIdJeu() == $jeu->getIdJeu() && $premierMedia) {
                    echo '<img src="' . htmlspecialchars($media->getCheminMedia()) . '" class="image-principale" alt="Image principale">';
                    $premierMedia = false;
                }
            }
            ?>
            <div class="miniatures">
                <?php foreach($mediaImages as $media) { // Affiche les miniatures des images
                    if($media->getIdJeu() == $jeu->getIdJeu()) { ?>
                        <img src="<?php echo htmlspecialchars($media->getCheminMedia()); ?>"
                             class="miniature"
                             alt="Miniature du jeu"
                             onclick="document.querySelector('.image-principale').src=this.src"> <?php // Change l'image principale ?>
                    <?php }
                } ?>
            </div>
        </div>

        <div class="jeu-info">
            <?php if (isset($mediaAffiches[$jeu->getIdJeu()])) {  // Gere l'affichage des affiches ?>
                <img src="<?php echo htmlspecialchars($mediaAffiches[$jeu->getIdJeu()]->getCheminMedia()); ?>"
                     class="affiche-jeu"
                     alt="Affiche du jeu">
            <?php } ?>

            <div class="info-detail"> <?php // Affiche les informations du jeu ?>
                <p>Développeur : <?php echo htmlspecialchars($jeu->getDeveloppeur()); // le Dev ?></p>
                <p>Éditeur : <?php echo htmlspecialchars($jeu->getEditeur()); // l'editeur ?></p>
                <p>Date de parution : <?php echo htmlspecialchars($jeu->getDateParution()); // la date de parution ?></p>
                <?php if (!empty($jeu->getMesTypes())) : ?>
                    <p>Tags : <?php // les Types de jeux auquel est affilié le jeu en question
                        $types = array_map(function($type) {
                            return htmlspecialchars($type->getNomTypeJeu());
                        }, $jeu->getMesTypes());
                        echo implode(', ', $types);
                        ?></p>
                <?php endif; ?>
            </div>

            <div class="restriction-age">
                <?php echo htmlspecialchars($jeu->getRestrictionAge()); // la restriction age ?>+
            </div>

            <div class="prix">
                <?php echo htmlspecialchars($jeu->getPrix()); // le prix ?> €
            </div>

            <p class="description">
                <?php echo htmlspecialchars($jeu->getDescriptionJeu()); // le description du jeu ?>
            </p>
            <?php if (isset($_SESSION['mailU'])) : ?>
                <a href="index.php?action=monPanier&id=<?php echo htmlspecialchars($jeu->getIdJeu()); // pour ajouter le jeu au panier par son id?>" class="btn-action">
                    Ajouter au panier
                </a>
            <?php endif; ?>
            <a href="index.php?action=listeJeu" class="btn-retour">← Retour à la boutique</a>
        </div>
    </div>

    <div class="critiques-section">
        <h2>Avis des joueurs</h2>
        <?php if (!empty($critiques)): // Pour gérer l'affichage des critiques ?>
            <?php
            $totalNotes = 0;
            foreach ($critiques as $critique) {
                $totalNotes += $critique['note']; // le nbre total de notes
            }
            $moyenneNotes = count($critiques) > 0 ? round($totalNotes / count($critiques), 1) : 0; // la note moyenne
            ?>
            <div class="moyenne-notes">
                <p>Note moyenne : <?= $moyenneNotes // La note Moyenne ?>/20 (<?= count($critiques) // Le nbre d'avis ?> avis)</p>
            </div>

            <?php foreach ($critiques as $critique): ?>
                <div class="critique">
                    <div class="critique-header">
                        <div class="critique-info">
                            <span class="auteur"><?= htmlspecialchars($critique['pseudou']) //recupe le pseudo de l'auteur de la critique et l'affiche?></span>
                            <span class="date"><?= date('d/m/Y', strtotime($critique['datecritique'])) // la date ?></span>
                            <span class="note"><?= $critique['note'] // la note ?>/20</span>
                        </div>
                        <?php if (isset($_SESSION['mailU']) && $critique['mailu'] === $_SESSION['mailU']): // s'assure que le mail de la critique et de la session sont les meme si l'utilisateur veut modifier/supprimer sa critique?>
                            <div class="critique-actions">
                                <button onclick="afficherModification(<?= $critique['note'] ?>, '<?= $critique['commentaire'] ?>')" class="btn-modifier">
                                    Modifier
                                </button>
                                <form action="index.php?action=supprimerCritique" method="POST" style="display: inline;">
                                    <input type="hidden" name="idJeu" value="<?= htmlspecialchars($jeu->getIdJeu()) //Formulaire pour la suppression ?>">
                                    <button type="submit" class="btn-supprimer" onclick="return confirm('Voulez-vous vraiment supprimer votre avis ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p class="commentaire"><?= nl2br(htmlspecialchars($critique['commentaire'])) ?></p>

                    <?php if (isset($_SESSION['mailU']) && $critique['mailu'] === $_SESSION['mailU']): // Formulaire pour modifier une critique sur le jeu?>
                        <div id="form-modification-<?= $critique['commentaire'] ?>" style="display: none;" class="form-modification">
                            <form action="index.php?action=modifierCritique" method="POST" class="critique-form">
                                <input type="hidden" name="idJeu" value="<?= htmlspecialchars($jeu->getIdJeu()) ?>">
                                <div class="form-group">
                                    <label for="note">Note sur 20 :</label>
                                    <input type="number" name="note" min="0" max="20" value="<?= $critique['note'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="commentaire">Votre commentaire :</label>
                                    <textarea name="commentaire" required><?= htmlspecialchars($critique['commentaire']) ?></textarea>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn-action">Enregistrer</button>
                                    <button type="button" onclick="cacherModification('<?= $critique['commentaire'] ?>')" class="btn-annuler">Annuler</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-critiques">Aucun avis pour ce jeu.</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['mailU'])): ?>
            <?php
            $dejaCommente = false;
            foreach ($critiques as $critique) { // s'assure que l'utilisateur n'a pas deja commenté le jeu
                if ($critique['mailu'] === $_SESSION['mailU']) {
                    $dejaCommente = true;
                    break;
                }
            }
            if (!$dejaCommente): //si aucune critique de l'utilisateur n'est présente ?>
                <div class="ajouter-critique">
                    <h3>Donner votre avis</h3>
                    <form action="index.php?action=ajouterCritique" method="POST" class="critique-form">
                        <input type="hidden" name="idJeu" value="<?= htmlspecialchars($jeu->getIdJeu()) ?>">
                        <div class="form-group">
                            <label for="note">Note sur 20 :</label>
                            <input type="number" id="note" name="note" min="0" max="20" required>
                        </div>
                        <div class="form-group">
                            <label for="commentaire">Votre commentaire :</label>
                            <textarea id="commentaire" name="commentaire" required></textarea>
                        </div>
                        <button type="submit" class="btn-action">Publier</button>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>