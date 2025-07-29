
CREATE DATABASE aembouazza_APprojet;

create table Utilisateur (
    MailU varchar(70) primary key ,
    PseudoU varchar(30) , 
    ageU int ,
    MdpU varchar(30),
    admin boolean
);

create table JeuVideo(
    IdJeu varchar (30) primary key ,
    NomJeu varchar (50) ,
    DateParution date ,
    NomDev varchar (50),
    NomEditeur varchar (50) , 
    DescriptionJeu varchar (350) ,
    Prix float ,
    RestrictionAge int 
);

create table TypeJeu(
    IdTypeJeu varchar (20) primary key ,
    NomTypeJeu varchar (50)
);

create table Commande(
    IdCommande varchar (50) primary key ,
    DateCommande date ,
    MailU varchar (70) ,
    constraint fk_Commande foreign key (MailU) REFERENCES Utilisateur(MailU)
);

create table MediaJeu(
    IdMedia varchar(50) primary key , 
    CheminMedia varchar(250) ,
    IdJeu varchar (30) ,
    constraint fk_MediaJeu foreign key (IdJeu) REFERENCES JeuVideo(IdJeu)
);

create table Contenir(
    IdCommande varchar (50) ,
    IdJeu varchar (30) ,
    constraint pk_contenir primary key (IdCommande, IdJeu),
    constraint fk_Contenir_Commande foreign key (IdCommande) REFERENCES Commande(IdCommande),
    constraint fk_Contenir_Jeu foreign key (IdJeu) REFERENCES JeuVideo(IdJeu)
);

create table Determiner(
    IdJeu varchar (30) ,
    IdTypeJeu varchar (20) , 
    constraint pk_Determiner primary key ( IdJeu , IdTypeJeu ),
    constraint fk_Determiner_Jeu foreign key (IdJeu) REFERENCES JeuVideo(IdJeu),
    constraint fk_Determiner_TypeJeu foreign key (IdTypeJeu) REFERENCES TypeJeu(IdTypeJeu)
);

create table Critiquer(
    MailU varchar (70) ,
    IdJeu varchar (30) ,
    note int ,
    commentaire varchar (150),
    DateCritique date ,
    constraint pk_Critiquer primary key ( MailU , IdJeu ),
    constraint fk_Critiquer_MailU foreign key (MailU) REFERENCES Utilisateur(MailU),
    constraint fk_Critiquer_Jeu foreign key (IdJeu) REFERENCES JeuVideo(IdJeu)
);


insert into JeuVideo values('LjljxdDXQ73NiRee8GDq' , 'Signalis' , '27/10/2022' , 'rose-engine' , 'Humble Games' , 'Une expérience d''horreur et survie dans un futur dystopique déshumanisé. Percez un mystère cosmique, échappez à de terrifiantes créatures et survivez sur une planète inconnue en tant qu''Elster, une technicienne Replika à la recherche de ses rêves oubliés.' , 19.99 , 16);
insert into JeuVideo values('eZt9rL3CbnytFhlK2vOT' , 'Dark Souls 3' , '11/04/2016' , 'FromSoftware' , 'Bandai Namco Entertainement' , 'Dark Souls repousse une fois de plus ses limites avec un nouveau chapitre ambitieux de la série légendaire et encensée par la critique. Préparez-vous à embrasser les ténèbres !' , 59.99 , 16);
insert into JeuVideo values('mVOXuqg6VNWezAPxkg7z' , 'Persona 5 Royal' , '21/10/2022' , 'ATLUS' , 'SEGA' , 'Enfilez le masque des Voleurs fantômes de cœurs, montez de gros coups, infiltrez l''esprit des corrompus et poussez-les à changer !' , 59.99 , 12);
insert into JeuVideo values('oJMVrFVRmTQkLh6NcIIB' , 'The Witcher 3: Wild Hunt' , '18/05/2015' , 'CD PROJEKT RED' , 'CD PROJEKT RED' , 'Vous incarnez Geralt de Riv, un tueur de monstres. Devant vous s''étend un continent en guerre, infesté de monstres, à explorer à votre guise. Votre contrat actuel ? Retrouver Ciri, l''enfant de la prophétie, une arme vivante capable de changer le monde' , 29.99 , 16);
insert into JeuVideo values('sopyoeIr9ppHbRmbfx9h' , 'Detroit Become Human' , '18/06/2020' , 'Quantic Dream' , 'Quantic Dream' , 'Detroit: Become Human met le destin de l''humanité et des androïdes entre vos mains, dans un futur proche où les machines sont devenues plus intelligentes que les hommes. Tous vos choix ont une incidence sur la suite du jeu, dans l''une des narrations les plus élaborées jamais écrites.' , 39.99 , 12);
insert into JeuVideo values('xz8nFPx5COvM0kULpvan' , 'Elden Ring' , '25/02/2022' , 'FromSoftware' , 'Bandai Namco Entertainement' , 'Levez-vous, Sans-éclat, et puisse la grâce guider vos pas. Brandissez la puissance du Cercle d''Elden. Devenez Seigneur de l''Entre-terre.' , 59.99 , 16);
insert into JeuVideo values('WlyfWB86GtArhbOSfyRH' , 'Celeste' , '25/01/2018' , 'Maddy Makes Games' , 'Maddy Makes Games' , 'Aidez Madeline à survivre à ses démons intérieurs au mont Celeste, dans ce jeu de plateformes ultra relevé, réalisé par les créateurs du classique TowerFall. Relevez des centaines de défis faits à la main, découvrez tous les secrets et dévoilez le mystère de la montagne.' , 19.50 , 8);
insert into JeuVideo values('SXIPi9vrlgTmgDT7jJxT' , 'Hollow Knight' , '24/02/2017' , 'Team Cherry' , 'Team Cherry' , 'Choisissez votre destin dans Hollow Knight ! Une aventure épique et pleine d''action, qui vous plongera dans un vaste royaume en ruine peuplé d''insectes et de héros. Dans un monde en 2D classique, dessiné à la main.' , 14.79 , 12);
insert into JeuVideo values('sb81kaC3mTSoDfWX7S8B' , 'Final Fantasy 7 Remake Intergrade' , '17/06/2022' , 'Square Enix' , 'Square Enix' , 'Vivez l''histoire passionnante de Cloud Strife à Midgar dans cette renaissance de l''emblématique FINAL FANTASY VII à travers des graphismes de pointe, des combats épiques mêlant action et commandes classiques, et un épisode bonus consacré à Yuffie Kisaragi.' , 39.99 , 12);
insert into JeuVideo values('F7DGfpdZkYmf0nZ5AseD' , 'Katana Zero' , '18/04/2019' , 'Askiisoft' , 'Devolver Digital' , 'Katana ZERO est un jeu de plate-formes à l''ambiance très noire, bourré d''action et de combats mortels. Faites parler votre lame et manipulez le temps pour découvrir votre passé dans un éblouissant ballet acrobatique et brutal.' , 14.79 , 12);
insert into JeuVideo values('hvkPbXizm7XwRXVLL2vq' , 'Nier Automata' , '17/03/2017' , 'Platinium Games' , 'Square Enix' , 'NieR: Automata raconte l''histoire des androïdes 2B, 9S et A2 et leur combat féroce contre une dystopie régie par de puissantes machines.' , 39.99 , 16);
insert into JeuVideo values('brTujYkf4IQdXIiprFJq' , 'Monster Hunter Wilds' , '28/02/2025' , 'Capcom' , 'Capcom' , 'Arpentez des environnements qui se transforment radicalement d''un moment à l''autre sous l''effet de la force indomptable d''une nature sans cesse déchaînée. Plongez dans une histoire de monstres et d''humains luttant pour vivre en harmonie dans un monde de dualités.' , 69.99 , 16);
insert into JeuVideo values('NT9SVOO7kxj5VFJTBGPz' , 'Hades' , '17/09/2020' , 'SuperGiant Games' , 'SuperGiant Games' , 'Défiez le dieu des morts et frayez-vous un chemin hors des Enfers dans ce rogue-like en mode dungeon crawler développé par les créateurs de Bastion, Transistor et Pyre.' , 24.50 , 16);
insert into JeuVideo values('y7PqkTkap1KW6BZnGKMN' , 'Resident Evil 4' , '24/03/2023' , 'Capcom' , 'Capcom' , 'La survie n''est que le début. Avec un gameplay modernisé, une histoire revisitée et des graphismes ultra détaillés, Resident Evil 4 signe la renaissance d''un monstre de l''industrie. Replongez dans le cauchemar qui a révolutionné les jeux d''horreur et de survie.' , 39.99 , 16);
insert into JeuVideo values('vWDCGeP8eWZlTpob3zD5' , 'Star Renegades' , '08/09/2020' , 'Massive Damage' , 'Raw Fury' , 'Star Renegades est un RPG stratégique de type rogue-lite se déroulant dans plusieurs dimensions. Triomphez d''adversaires uniques générés par le système, créez des liens entre vos différents héros et mettez fin au cycle!' , 24.99 , 12);
insert into JeuVideo values('PXyLnN6PMgF3Pl2yP4wr' , 'Portal 2' , '19/04/2011' , 'Valve' , 'Valve' , 'L''« initiative de tests perpétuels » a été étendue pour vous permettre de concevoir des casse-têtes coopératifs pour vous et vos contacts !' , 9.75 , 12);
insert into JeuVideo values('tRYaCGwneSL57FHhGlLH' , 'Darkest Dungeon' , '19/01/2016' , 'Red Hook Studio' , 'Red Hook Studio' , 'Darkest Dungeon est un JdR rogue-like au tour par tour, gothique et sans pitié, sur le stress psychologique de partir à l''aventure. Recrute, entraîne et mène une équipe d''anti-héros au travers de forêts déformées, de tanières oubliées, de cryptes en ruines et au-delà.' , 24.50 , 16);
insert into JeuVideo values('RYPpaPmCLzYi6wH3Zi1U' , 'CyberPunk 2077' , '10/12/2020' , 'CD PROJEKT RED' , 'CD PROJEKT RED' , 'Cyberpunk 2077 est un JDR d''action-aventure en monde ouvert, qui se déroule à Night City, une mégalopole futuriste et sombre, obsédée par le pouvoir, la séduction et les modifications corporelles.' , 59.99 , 16);
insert into JeuVideo values('GMaMDHJfTzyv6SsWnkgn' , 'Dead Cells' , '06/08/2018' , 'Motion Twin' , 'Motion Twin' , 'Dead Cells est un jeu d''action/plateforme rogue-lite intégrant des éléments de Metroidvania. Explorez un château tentaculaire en perpétuelle évolution… Pas de points de contrôle. Tuer, mourir, apprendre, recommencer.' , 24.99 , 12);
insert into JeuVideo values('BvzSYkv8yKCic7flJlp0' , 'Little Nightmare 2' , '11/02/2021' , 'Tarsier Studio' , 'Bandai Namco' , 'Little Nightmares II est un jeu d''aventure plein de suspens dans lequel vous incarnez Mono, un petit garçon pris au piège dans un monde dénaturé par une transmission maléfique. Il part à la recherche de la source de cette transmission avec sa nouvelle amie, Six.' , 24.50 , 16);
insert into JeuVideo values('ZzXaxJhR3osrph4fH9q9' , 'Guilty Gear Strive' , '11/06/2021' , 'Arc System Works' , 'Arc System Works' , 'Vivez le frisson du combat grâce aux mécaniques approfondies et aux superbes animations de Guilty Gear -Strive-, le dernier-né de la série révolutionnaire Guilty Gear !' , 39.99 , 12);

insert into TypeJeu values('3w04oVT84i' , 'MetroidVania');
insert into TypeJeu values('Np7rjhM4Wo' , 'RPG');
insert into TypeJeu values('bWdiYbrtCy' , 'Plateformer');
insert into TypeJeu values('vUbNyBuxCH' , '2D');
insert into TypeJeu values('XAL2OWr8kU' , 'Soulslike');
insert into TypeJeu values('sHnOtBDJsm' , '3D');
insert into TypeJeu values('fEJnkXAC0t' , 'Fantasy');
insert into TypeJeu values('oupupXYQpC' , 'Science Fiction');
insert into TypeJeu values('rEsTW9dI2i' , 'Film Interactif');
insert into TypeJeu values('GbxqfbpwBP' , 'Anime');
insert into TypeJeu values('nFnYqWurw7' , 'Open World');
insert into TypeJeu values('ShgBsWOeaS' , 'Horreur');
insert into TypeJeu values('vDvBcNY9on' , 'Aventure');
insert into TypeJeu values('ggBivQTVKo' , 'Action');
insert into TypeJeu values('R4dfAh7FK8' , 'Enigmes');
insert into TypeJeu values('6AhyohAs0S' , 'Jeu de Combat');
insert into TypeJeu values('KlRtVL0URR' , 'Roguelike');
insert into TypeJeu values('pysVSNMYT3' , 'MultiJoueur');
insert into TypeJeu values('bojLgXCBEb' , 'Survival');
insert into TypeJeu values('fZeVXdHN4K' , 'Tour par Tour');


insert into Determiner values('LjljxdDXQ73NiRee8GDq' , 'vUbNyBuxCH');
insert into Determiner values('LjljxdDXQ73NiRee8GDq' , 'oupupXYQpC');
insert into Determiner values('LjljxdDXQ73NiRee8GDq' , 'ShgBsWOeaS');
insert into Determiner values('LjljxdDXQ73NiRee8GDq' , 'R4dfAh7FK8');
insert into Determiner values('LjljxdDXQ73NiRee8GDq' , 'bojLgXCBEb');

insert into Determiner values('eZt9rL3CbnytFhlK2vOT' , 'XAL2OWr8kU');
insert into Determiner values('eZt9rL3CbnytFhlK2vOT' , 'sHnOtBDJsm');
insert into Determiner values('eZt9rL3CbnytFhlK2vOT' , 'vDvBcNY9on');
insert into Determiner values('eZt9rL3CbnytFhlK2vOT' , 'ggBivQTVKo');
insert into Determiner values('eZt9rL3CbnytFhlK2vOT' , 'pysVSNMYT3');
insert into Determiner values('eZt9rL3CbnytFhlK2vOT' , 'fEJnkXAC0t');

insert into Determiner values('mVOXuqg6VNWezAPxkg7z' , 'Np7rjhM4Wo');
insert into Determiner values('mVOXuqg6VNWezAPxkg7z' , 'sHnOtBDJsm');
insert into Determiner values('mVOXuqg6VNWezAPxkg7z' , 'GbxqfbpwBP');
insert into Determiner values('mVOXuqg6VNWezAPxkg7z' , 'ggBivQTVKo');

insert into Determiner values('oJMVrFVRmTQkLh6NcIIB' , 'Np7rjhM4Wo');
insert into Determiner values('oJMVrFVRmTQkLh6NcIIB' , 'sHnOtBDJsm');
insert into Determiner values('oJMVrFVRmTQkLh6NcIIB' , 'fEJnkXAC0t');
insert into Determiner values('oJMVrFVRmTQkLh6NcIIB' , 'nFnYqWurw7');
insert into Determiner values('oJMVrFVRmTQkLh6NcIIB' , 'vDvBcNY9on');
insert into Determiner values('oJMVrFVRmTQkLh6NcIIB' , 'ggBivQTVKo');

insert into Determiner values('sopyoeIr9ppHbRmbfx9h' , 'sHnOtBDJsm');
insert into Determiner values('sopyoeIr9ppHbRmbfx9h' , 'oupupXYQpC');
insert into Determiner values('sopyoeIr9ppHbRmbfx9h' , 'rEsTW9dI2i');

insert into Determiner values('xz8nFPx5COvM0kULpvan' , 'Np7rjhM4Wo');
insert into Determiner values('xz8nFPx5COvM0kULpvan' , 'XAL2OWr8kU');
insert into Determiner values('xz8nFPx5COvM0kULpvan' , 'sHnOtBDJsm');
insert into Determiner values('xz8nFPx5COvM0kULpvan' , 'fEJnkXAC0t');
insert into Determiner values('xz8nFPx5COvM0kULpvan' , 'nFnYqWurw7');
insert into Determiner values('xz8nFPx5COvM0kULpvan' , 'vDvBcNY9on');
insert into Determiner values('xz8nFPx5COvM0kULpvan' , 'ggBivQTVKo');

insert into Determiner values('WlyfWB86GtArhbOSfyRH' , 'bWdiYbrtCy');
insert into Determiner values('WlyfWB86GtArhbOSfyRH' , 'vUbNyBuxCH');
insert into Determiner values('WlyfWB86GtArhbOSfyRH' , 'GbxqfbpwBP');
insert into Determiner values('WlyfWB86GtArhbOSfyRH' , 'R4dfAh7FK8');


insert into Determiner values('SXIPi9vrlgTmgDT7jJxT' , '3w04oVT84i');
insert into Determiner values('SXIPi9vrlgTmgDT7jJxT' , 'bWdiYbrtCy');
insert into Determiner values('SXIPi9vrlgTmgDT7jJxT' , 'vUbNyBuxCH');
insert into Determiner values('SXIPi9vrlgTmgDT7jJxT' , 'XAL2OWr8kU');
insert into Determiner values('SXIPi9vrlgTmgDT7jJxT' , 'GbxqfbpwBP');
insert into Determiner values('SXIPi9vrlgTmgDT7jJxT' , 'nFnYqWurw7');
insert into Determiner values('SXIPi9vrlgTmgDT7jJxT' , 'vDvBcNY9on');
insert into Determiner values('SXIPi9vrlgTmgDT7jJxT' , 'ggBivQTVKo');

insert into Determiner values('sb81kaC3mTSoDfWX7S8B' , 'Np7rjhM4Wo');
insert into Determiner values('sb81kaC3mTSoDfWX7S8B' , 'fEJnkXAC0t');
insert into Determiner values('sb81kaC3mTSoDfWX7S8B' , 'sHnOtBDJsm');
insert into Determiner values('sb81kaC3mTSoDfWX7S8B' , 'GbxqfbpwBP');
insert into Determiner values('sb81kaC3mTSoDfWX7S8B' , 'ggBivQTVKo');


insert into Determiner values('F7DGfpdZkYmf0nZ5AseD' , 'bWdiYbrtCy');
insert into Determiner values('F7DGfpdZkYmf0nZ5AseD' , 'vUbNyBuxCH');
insert into Determiner values('F7DGfpdZkYmf0nZ5AseD' , 'oupupXYQpC');
insert into Determiner values('F7DGfpdZkYmf0nZ5AseD' , 'ggBivQTVKo');

insert into Determiner values('hvkPbXizm7XwRXVLL2vq' , 'Np7rjhM4Wo');
insert into Determiner values('hvkPbXizm7XwRXVLL2vq' , 'sHnOtBDJsm');
insert into Determiner values('hvkPbXizm7XwRXVLL2vq' , 'oupupXYQpC');
insert into Determiner values('hvkPbXizm7XwRXVLL2vq' , 'GbxqfbpwBP');
insert into Determiner values('hvkPbXizm7XwRXVLL2vq' , 'ggBivQTVKo');


insert into Determiner values('brTujYkf4IQdXIiprFJq' , 'Np7rjhM4Wo');
insert into Determiner values('brTujYkf4IQdXIiprFJq' , 'sHnOtBDJsm');
insert into Determiner values('brTujYkf4IQdXIiprFJq' , 'fEJnkXAC0t');
insert into Determiner values('brTujYkf4IQdXIiprFJq' , 'nFnYqWurw7');
insert into Determiner values('brTujYkf4IQdXIiprFJq' , 'ggBivQTVKo');

insert into Determiner values('NT9SVOO7kxj5VFJTBGPz' , 'vUbNyBuxCH');
insert into Determiner values('NT9SVOO7kxj5VFJTBGPz' , 'GbxqfbpwBP');
insert into Determiner values('NT9SVOO7kxj5VFJTBGPz' , 'ggBivQTVKo');
insert into Determiner values('NT9SVOO7kxj5VFJTBGPz' , 'KlRtVL0URR');

insert into Determiner values('y7PqkTkap1KW6BZnGKMN' , 'sHnOtBDJsm');
insert into Determiner values('y7PqkTkap1KW6BZnGKMN' , 'ShgBsWOeaS');
insert into Determiner values('y7PqkTkap1KW6BZnGKMN' , 'ggBivQTVKo');
insert into Determiner values('y7PqkTkap1KW6BZnGKMN' , 'R4dfAh7FK8');
insert into Determiner values('y7PqkTkap1KW6BZnGKMN' , 'bojLgXCBEb');

insert into Determiner values('vWDCGeP8eWZlTpob3zD5' , 'Np7rjhM4Wo');
insert into Determiner values('vWDCGeP8eWZlTpob3zD5' , 'vUbNyBuxCH');
insert into Determiner values('vWDCGeP8eWZlTpob3zD5' , 'oupupXYQpC');
insert into Determiner values('vWDCGeP8eWZlTpob3zD5' , 'ggBivQTVKo');
insert into Determiner values('vWDCGeP8eWZlTpob3zD5' , 'fZeVXdHN4K');

insert into Determiner values('PXyLnN6PMgF3Pl2yP4wr' , 'bWdiYbrtCy');
insert into Determiner values('PXyLnN6PMgF3Pl2yP4wr' , 'sHnOtBDJsm');
insert into Determiner values('PXyLnN6PMgF3Pl2yP4wr' , 'oupupXYQpC');
insert into Determiner values('PXyLnN6PMgF3Pl2yP4wr' , 'R4dfAh7FK8');

insert into Determiner values('tRYaCGwneSL57FHhGlLH' , 'fZeVXdHN4K');
insert into Determiner values('tRYaCGwneSL57FHhGlLH' , 'Np7rjhM4Wo');
insert into Determiner values('tRYaCGwneSL57FHhGlLH' , 'vUbNyBuxCH');
insert into Determiner values('tRYaCGwneSL57FHhGlLH' , 'fEJnkXAC0t');
insert into Determiner values('tRYaCGwneSL57FHhGlLH' , 'GbxqfbpwBP');
insert into Determiner values('tRYaCGwneSL57FHhGlLH' , 'ShgBsWOeaS');

insert into Determiner values('RYPpaPmCLzYi6wH3Zi1U' , 'sHnOtBDJsm');
insert into Determiner values('RYPpaPmCLzYi6wH3Zi1U' , 'oupupXYQpC');
insert into Determiner values('RYPpaPmCLzYi6wH3Zi1U' , 'nFnYqWurw7');
insert into Determiner values('RYPpaPmCLzYi6wH3Zi1U' , 'ggBivQTVKo');

insert into Determiner values('GMaMDHJfTzyv6SsWnkgn' , '3w04oVT84i');
insert into Determiner values('GMaMDHJfTzyv6SsWnkgn' , 'bWdiYbrtCy');
insert into Determiner values('GMaMDHJfTzyv6SsWnkgn' , 'vUbNyBuxCH');
insert into Determiner values('GMaMDHJfTzyv6SsWnkgn' , 'ggBivQTVKo');
insert into Determiner values('GMaMDHJfTzyv6SsWnkgn' , 'KlRtVL0URR');
insert into Determiner values('GMaMDHJfTzyv6SsWnkgn' , 'GbxqfbpwBP');

insert into Determiner values('BvzSYkv8yKCic7flJlp0' , 'bWdiYbrtCy');
insert into Determiner values('BvzSYkv8yKCic7flJlp0' , 'vUbNyBuxCH');
insert into Determiner values('BvzSYkv8yKCic7flJlp0' , 'ShgBsWOeaS');
insert into Determiner values('BvzSYkv8yKCic7flJlp0' , 'R4dfAh7FK8');

insert into Determiner values('ZzXaxJhR3osrph4fH9q9' , 'Np7rjhM4Wo');
insert into Determiner values('ZzXaxJhR3osrph4fH9q9' , 'vUbNyBuxCH');
insert into Determiner values('ZzXaxJhR3osrph4fH9q9' , 'GbxqfbpwBP');
insert into Determiner values('ZzXaxJhR3osrph4fH9q9' , 'ggBivQTVKo');
insert into Determiner values('ZzXaxJhR3osrph4fH9q9' , '6AhyohAs0S');
insert into Determiner values('ZzXaxJhR3osrph4fH9q9' , 'pysVSNMYT3');

insert into MediaJeu values('MDLcbG9lgF' , 'image/Signalis_image/signalis_affiche' , 'LjljxdDXQ73NiRee8GDq');
insert into MediaJeu values('M52rqkLcNK' , 'image/Signalis_image/signalis1' , 'LjljxdDXQ73NiRee8GDq');
insert into MediaJeu values('GEC4hM4tDx' , 'image/Signalis_image/signalis2' , 'LjljxdDXQ73NiRee8GDq');
insert into MediaJeu values('2U1kfcaRWf' , 'image/Signalis_image/signalis3' , 'LjljxdDXQ73NiRee8GDq');
insert into MediaJeu values('EGeKVYPfIC' , 'image/Signalis_image/signalis4' , 'LjljxdDXQ73NiRee8GDq');
insert into MediaJeu values('oc7VXofRG8' , 'image/Signalis_image/signalis5' , 'LjljxdDXQ73NiRee8GDq');

insert into MediaJeu values('3Y7DpPe37u' , 'image/DarkSouls3_image/DS3_affiche' , 'eZt9rL3CbnytFhlK2vOT');
insert into MediaJeu values('AIQKgBOGOF' , 'image/DarkSouls3_image/DS3_1' , 'eZt9rL3CbnytFhlK2vOT');
insert into MediaJeu values('jP7WdGhM7W' , 'image/DarkSouls3_image/DS3_2' , 'eZt9rL3CbnytFhlK2vOT');
insert into MediaJeu values('rqHfnOWYo0' , 'image/DarkSouls3_image/DS3_3' , 'eZt9rL3CbnytFhlK2vOT');
insert into MediaJeu values('36UazMUhfm' , 'image/DarkSouls3_image/DS3_4' , 'eZt9rL3CbnytFhlK2vOT');
insert into MediaJeu values('GMqTsmVy2w' , 'image/DarkSouls3_image/DS3_5' , 'eZt9rL3CbnytFhlK2vOT');

insert into MediaJeu values('UB4VcgsAC4' , 'image/P5_image/P5_affiche' , 'mVOXuqg6VNWezAPxkg7z');
insert into MediaJeu values('i50QcF322U' , 'image/P5_image/P5_1' , 'mVOXuqg6VNWezAPxkg7z');
insert into MediaJeu values('O1N94UJztf' , 'image/P5_image/P5_2'  , 'mVOXuqg6VNWezAPxkg7z');
insert into MediaJeu values('KgWHAgGaN5' , 'image/P5_image/P5_3'  , 'mVOXuqg6VNWezAPxkg7z');
insert into MediaJeu values('5oNIvVcprT' , 'image/P5_image/P5_4'  , 'mVOXuqg6VNWezAPxkg7z');

insert into MediaJeu values('ndO2aBTGpx' , 'image/TheWitcher3_image/TheWitcher3_affiche' , 'oJMVrFVRmTQkLh6NcIIB');
insert into MediaJeu values('KpgfFxx7EI' , 'image/TheWitcher3_image/TheWitcher3_1'  , 'oJMVrFVRmTQkLh6NcIIB');
insert into MediaJeu values('Lwif25fzkG' , 'image/TheWitcher3_image/TheWitcher3_2'  , 'oJMVrFVRmTQkLh6NcIIB');
insert into MediaJeu values('IeBqTwopX8' , 'image/TheWitcher3_image/TheWitcher3_3'  , 'oJMVrFVRmTQkLh6NcIIB');
insert into MediaJeu values('4FnCNkZAYZ' , 'image/TheWitcher3_image/TheWitcher3_4'  , 'oJMVrFVRmTQkLh6NcIIB');

insert into MediaJeu values('RviNKYlYT3' , 'image/Detroit_image/detroit_affiche'  , 'sopyoeIr9ppHbRmbfx9h');
insert into MediaJeu values('8iU7PZfzRa' , 'image/Detroit_image/detroit_1'  , 'sopyoeIr9ppHbRmbfx9h');
insert into MediaJeu values('D4E9yhATOn' , 'image/Detroit_image/detroit_2'  , 'sopyoeIr9ppHbRmbfx9h');
insert into MediaJeu values('JociiDNrVw' , 'image/Detroit_image/detroit_3'  , 'sopyoeIr9ppHbRmbfx9h');

insert into MediaJeu values('7UyWLd2sLh' , 'image/EldenRing_image/elden_affiche'  , 'xz8nFPx5COvM0kULpvan');
insert into MediaJeu values('wex59Y7JKw' , 'image/EldenRing_image/elden_1'  , 'xz8nFPx5COvM0kULpvan');
insert into MediaJeu values('oQ1Wof48Oz' , 'image/EldenRing_image/elden_2'  , 'xz8nFPx5COvM0kULpvan');
insert into MediaJeu values('SrOe67CVYP' , 'image/EldenRing_image/elden_3'  , 'xz8nFPx5COvM0kULpvan');
insert into MediaJeu values('IW7BoVLFaL' , 'image/EldenRing_image/elden_4'  , 'xz8nFPx5COvM0kULpvan');

insert into MediaJeu values('XIjx6E3yGA' , 'image/Celeste_image/celeste_affiche'  , 'WlyfWB86GtArhbOSfyRH');
insert into MediaJeu values('om7CHoI5uI' , 'image/Celeste_image/celeste_1'  , 'WlyfWB86GtArhbOSfyRH');
insert into MediaJeu values('bcRcC4qEFM' , 'image/Celeste_image/celeste_2'  , 'WlyfWB86GtArhbOSfyRH');
insert into MediaJeu values('LBbn9ZF974' , 'image/Celeste_image/celeste_3'  , 'WlyfWB86GtArhbOSfyRH');
insert into MediaJeu values('WnqpQO04rn' , 'image/Celeste_image/celeste_4'  , 'WlyfWB86GtArhbOSfyRH');

insert into MediaJeu values('dIO00JquH9' , 'image/HollowKnight_image/hollow_affiche'  , 'SXIPi9vrlgTmgDT7jJxT');
insert into MediaJeu values('ZCjWrcBZo5' , 'image/HollowKnight_image/hollow_1'  , 'SXIPi9vrlgTmgDT7jJxT');
insert into MediaJeu values('8Spb7n56Wj' , 'image/HollowKnight_image/hollow_2'  , 'SXIPi9vrlgTmgDT7jJxT');
insert into MediaJeu values('um3xM2sFpW' , 'image/HollowKnight_image/hollow_3'  , 'SXIPi9vrlgTmgDT7jJxT');
insert into MediaJeu values('uWlXwf8RJc' , 'image/HollowKnight_image/hollow_4'  , 'SXIPi9vrlgTmgDT7jJxT');

insert into MediaJeu values('vNfCKgHEa5' , 'image/FF7_image/ff7_affiche'  , 'sb81kaC3mTSoDfWX7S8B');
insert into MediaJeu values('iPW691dtDE' , 'image/FF7_image/ff7_1'  , 'sb81kaC3mTSoDfWX7S8B');
insert into MediaJeu values('lm7hY0tTjM' , 'image/FF7_image/ff7_2'  , 'sb81kaC3mTSoDfWX7S8B');
insert into MediaJeu values('mB7gxkXkR4' , 'image/FF7_image/ff7_3'  , 'sb81kaC3mTSoDfWX7S8B');
insert into MediaJeu values('N6vCjvsCb4' , 'image/FF7_image/ff7_4'  , 'sb81kaC3mTSoDfWX7S8B');

insert into MediaJeu values('6qCuk3rJDB' , 'image/KatanaZero_image/katana_affiche'  , 'F7DGfpdZkYmf0nZ5AseD');
insert into MediaJeu values('6ZDvqabtd2' , 'image/KatanaZero_image/katana_1'  , 'F7DGfpdZkYmf0nZ5AseD');
insert into MediaJeu values('kTPyShsbj1' , 'image/KatanaZero_image/katana_2'  , 'F7DGfpdZkYmf0nZ5AseD');
insert into MediaJeu values('1rmV6FPzxP' , 'image/KatanaZero_image/katana_3'  , 'F7DGfpdZkYmf0nZ5AseD');
insert into MediaJeu values('hwAdGs7HJR' , 'image/KatanaZero_image/katana_4'  , 'F7DGfpdZkYmf0nZ5AseD');

insert into MediaJeu values('Oiro4l4hmS' , 'image/NierAutomata_image/nierAutomata_affiche'  , 'hvkPbXizm7XwRXVLL2vq');
insert into MediaJeu values('4JRblTDAfM' , 'image/NierAutomata_image/nierAutomata_1'  , 'hvkPbXizm7XwRXVLL2vq');
insert into MediaJeu values('4xwXCvOwSI' , 'image/NierAutomata_image/nierAutomata_2'  , 'hvkPbXizm7XwRXVLL2vq');
insert into MediaJeu values('bYTUtKYgrn' , 'image/NierAutomata_image/nierAutomata_3'  , 'hvkPbXizm7XwRXVLL2vq');
insert into MediaJeu values('YpfXCQz4Jr' , 'image/NierAutomata_image/nierAutomata_4'  , 'hvkPbXizm7XwRXVLL2vq');

insert into MediaJeu values('b3PcOyT9x3' , 'image/MonsterHunter_image/Monster_affiche'  , 'brTujYkf4IQdXIiprFJq');
insert into MediaJeu values('W0ulUwOyBI' , 'image/MonsterHunter_image/Monster_1'  , 'brTujYkf4IQdXIiprFJq');
insert into MediaJeu values('kymUJGstwH' , 'image/MonsterHunter_image/Monster_2'  , 'brTujYkf4IQdXIiprFJq');
insert into MediaJeu values('stZXV2Owlk' , 'image/MonsterHunter_image/Monster_3'  , 'brTujYkf4IQdXIiprFJq');
insert into MediaJeu values('2NIPUhawmZ' , 'image/MonsterHunter_image/Monster_4'  , 'brTujYkf4IQdXIiprFJq');

insert into MediaJeu values('KISQ3iAUxE' , 'image/Hades_image/hades_affiche'  , 'NT9SVOO7kxj5VFJTBGPz');
insert into MediaJeu values('Agm4RryVoy' , 'image/Hades_image/hades_1'  , 'NT9SVOO7kxj5VFJTBGPz');
insert into MediaJeu values('s0qIdse1o4' , 'image/Hades_image/hades_2'  , 'NT9SVOO7kxj5VFJTBGPz');
insert into MediaJeu values('Hyu9tbv2Sy' , 'image/Hades_image/hades_3'  , 'NT9SVOO7kxj5VFJTBGPz');
insert into MediaJeu values('qc7puz1RLg' , 'image/Hades_image/hades_4'  , 'NT9SVOO7kxj5VFJTBGPz');

insert into MediaJeu values('p1VL359i2o' , 'image/Re4_image/re4_affiche'  , 'y7PqkTkap1KW6BZnGKMN');
insert into MediaJeu values('Ykdwl8F9aB' , 'image/Re4_image/re4_1'  , 'y7PqkTkap1KW6BZnGKMN');
insert into MediaJeu values('5guZ1XbvHW' , 'image/Re4_image/re4_2'  , 'y7PqkTkap1KW6BZnGKMN');
insert into MediaJeu values('YwTrmW8XR1' , 'image/Re4_image/re4_3'  , 'y7PqkTkap1KW6BZnGKMN');
insert into MediaJeu values('vAcE0rLvue' , 'image/Re4_image/re4_4'  , 'y7PqkTkap1KW6BZnGKMN');

insert into MediaJeu values('2klTqcncrn' , 'image/StarRenegades_image/starRenegades_affiche'  , 'vWDCGeP8eWZlTpob3zD5');
insert into MediaJeu values('w6kr274a64' , 'image/StarRenegades_image/starRenegades_1'  , 'vWDCGeP8eWZlTpob3zD5');
insert into MediaJeu values('efT37VYYyS' , 'image/StarRenegades_image/starRenegades_2'  , 'vWDCGeP8eWZlTpob3zD5');
insert into MediaJeu values('7SkLohu1no' , 'image/StarRenegades_image/starRenegades_3'  , 'vWDCGeP8eWZlTpob3zD5');
insert into MediaJeu values('bcHFsuZoSD' , 'image/StarRenegades_image/starRenegades_4'  , 'vWDCGeP8eWZlTpob3zD5');

insert into MediaJeu values('gVwa1hxvFM' , 'image/Portal2_image/portal2_affiche'  , 'PXyLnN6PMgF3Pl2yP4wr');
insert into MediaJeu values('LfvDoPZBRI' , 'image/Portal2_image/portal2_1'  , 'PXyLnN6PMgF3Pl2yP4wr');
insert into MediaJeu values('RU937vCEp6' , 'image/Portal2_image/portal2_2'  , 'PXyLnN6PMgF3Pl2yP4wr');
insert into MediaJeu values('TrWfZKmiKP' , 'image/Portal2_image/portal2_3'  , 'PXyLnN6PMgF3Pl2yP4wr');
insert into MediaJeu values('RU8xowP4PS' , 'image/Portal2_image/portal2_4'  , 'PXyLnN6PMgF3Pl2yP4wr');

insert into MediaJeu values('XGKqM7RjS5' , 'image/DarkestDungeon_image/darkestDungeon_affiche'  , 'tRYaCGwneSL57FHhGlLH');
insert into MediaJeu values('tw4NnSe4Ym' , 'image/DarkestDungeon_image/darkestDungeon_1'  , 'tRYaCGwneSL57FHhGlLH');
insert into MediaJeu values('SNpyvmetay' , 'image/DarkestDungeon_image/darkestDungeon_2'  , 'tRYaCGwneSL57FHhGlLH');
insert into MediaJeu values('ruCsYmQvlG' , 'image/DarkestDungeon_image/darkestDungeon_3'  , 'tRYaCGwneSL57FHhGlLH');
insert into MediaJeu values('jw4XcgXwiM' , 'image/DarkestDungeon_image/darkestDungeon_4'  , 'tRYaCGwneSL57FHhGlLH');

insert into MediaJeu values('WeW0DGz39h' , 'image/Cyberpunk2077_image/Cyberpunk_affiche'  , 'RYPpaPmCLzYi6wH3Zi1U');
insert into MediaJeu values('cYAyBPLwji' , 'image/Cyberpunk2077_image/Cyberpunk_1'  , 'RYPpaPmCLzYi6wH3Zi1U');
insert into MediaJeu values('rbNASLQNy2' , 'image/Cyberpunk2077_image/Cyberpunk_2'  , 'RYPpaPmCLzYi6wH3Zi1U');
insert into MediaJeu values('jiwLFgPd3x' , 'image/Cyberpunk2077_image/Cyberpunk_3'  , 'RYPpaPmCLzYi6wH3Zi1U');
insert into MediaJeu values('Bu7xXnebzn' , 'image/Cyberpunk2077_image/Cyberpunk_4'  , 'RYPpaPmCLzYi6wH3Zi1U');

insert into MediaJeu values('52qTGvotKZ' , 'image/DeadCells_image/deadcells_affiche'  , 'GMaMDHJfTzyv6SsWnkgn');
insert into MediaJeu values('K8L2RIi7pX' , 'image/DeadCells_image/deadcells_1'  , 'GMaMDHJfTzyv6SsWnkgn');
insert into MediaJeu values('A8bd4fU0b7' , 'image/DeadCells_image/deadcells_2'  , 'GMaMDHJfTzyv6SsWnkgn');
insert into MediaJeu values('ATMk9eAWei' , 'image/DeadCells_image/deadcells_3'  , 'GMaMDHJfTzyv6SsWnkgn');
insert into MediaJeu values('NIc6NND69m' , 'image/DeadCells_image/deadcells_4'  , 'GMaMDHJfTzyv6SsWnkgn');

insert into MediaJeu values('jRQF6ampYZ' , 'image/LittleNightmare_image/littleNightmare_affiche'  , 'BvzSYkv8yKCic7flJlp0');
insert into MediaJeu values('xKTW1lIOy8' , 'image/LittleNightmare_image/littleNightmare_1'  , 'BvzSYkv8yKCic7flJlp0');
insert into MediaJeu values('KLX4AGnnxg' , 'image/LittleNightmare_image/littleNightmare_2'  , 'BvzSYkv8yKCic7flJlp0');
insert into MediaJeu values('7uffACdNv0' , 'image/LittleNightmare_image/littleNightmare_3'  , 'BvzSYkv8yKCic7flJlp0');
insert into MediaJeu values('coveBVntws' , 'image/LittleNightmare_image/littleNightmare_4'  , 'BvzSYkv8yKCic7flJlp0');

insert into MediaJeu values('EAvV14oonj' , 'image/GuiltyGear_image/guilty_affiche'  , 'ZzXaxJhR3osrph4fH9q9');
insert into MediaJeu values('7jBv9vgjXI' , 'image/GuiltyGear_image/guilty_1'  , 'ZzXaxJhR3osrph4fH9q9');
insert into MediaJeu values('8pczP0OLjc' , 'image/GuiltyGear_image/guilty_2'  , 'ZzXaxJhR3osrph4fH9q9');
insert into MediaJeu values('8AgpmnbgbQ' , 'image/GuiltyGear_image/guilty_3'  , 'ZzXaxJhR3osrph4fH9q9');
insert into MediaJeu values('C8hpd3QCr7' , 'image/GuiltyGear_image/guilty_4'  , 'ZzXaxJhR3osrph4fH9q9');

-- insert into MediaJeu values ('123ade' , 'image/SilentHill2_image/silentHill2_affiche.jpg' , 'jeu_680042d005d5a');
-- insert into MediaJeu values ('sd53aderty' , 'image/SilentHill2_image/silentHill2_1.jpg' , 'jeu_680042d005d5a');

UPDATE mediajeu
SET cheminmedia = cheminmedia || '.jpg'
WHERE cheminmedia LIKE 'image/%' AND cheminmedia NOT LIKE '%.jpg';


-- 1. Commande → Utilisateur
ALTER TABLE Commande DROP CONSTRAINT fk_Commande;
ALTER TABLE Commande
    ADD CONSTRAINT fk_Commande FOREIGN KEY (MailU)
        REFERENCES Utilisateur(MailU)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- 2. MediaJeu → JeuVideo
ALTER TABLE MediaJeu DROP CONSTRAINT fk_MediaJeu;
ALTER TABLE MediaJeu
    ADD CONSTRAINT fk_MediaJeu FOREIGN KEY (IdJeu)
        REFERENCES JeuVideo(IdJeu)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- 3. Contenir → Commande + JeuVideo
ALTER TABLE Contenir DROP CONSTRAINT fk_Contenir_Commande;
ALTER TABLE Contenir DROP CONSTRAINT fk_Contenir_Jeu;
ALTER TABLE Contenir
    ADD CONSTRAINT fk_Contenir_Commande FOREIGN KEY (IdCommande)
        REFERENCES Commande(IdCommande)
        ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_Contenir_Jeu FOREIGN KEY (IdJeu)
        REFERENCES JeuVideo(IdJeu)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- 4. Determiner → JeuVideo + TypeJeu
ALTER TABLE Determiner DROP CONSTRAINT fk_Determiner_Jeu;
ALTER TABLE Determiner DROP CONSTRAINT fk_Determiner_TypeJeu;
ALTER TABLE Determiner
    ADD CONSTRAINT fk_Determiner_Jeu FOREIGN KEY (IdJeu)
        REFERENCES JeuVideo(IdJeu)
        ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_Determiner_TypeJeu FOREIGN KEY (IdTypeJeu)
        REFERENCES TypeJeu(IdTypeJeu)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- 5. Critiquer → Utilisateur + JeuVideo
ALTER TABLE Critiquer DROP CONSTRAINT fk_Critiquer_MailU;
ALTER TABLE Critiquer DROP CONSTRAINT fk_Critiquer_Jeu;
ALTER TABLE Critiquer
    ADD CONSTRAINT fk_Critiquer_MailU FOREIGN KEY (MailU)
        REFERENCES Utilisateur(MailU)
        ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT fk_Critiquer_Jeu FOREIGN KEY (IdJeu)
        REFERENCES JeuVideo(IdJeu)
        ON DELETE CASCADE ON UPDATE CASCADE;