-- Pédiatres (Tunisie) importés depuis l'annuaire public Medline
-- Source : https://medline.tn/fr/specialite/pediatrie/
-- 494 fiches : nom, gouvernorat, municipalité, adresse, téléphone
-- type = 1 (pédiatre). etab : 1=hôpital, 2=clinique, 3=cabinet
-- classe laissée vide. Réimport sans doublon (même nom + même téléphone).
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO medecins (fullname, type, region, municipalite, etab, name_etab, adresse, tel, active, created_at, updated_at)
SELECT src.fullname, src.type, src.region, src.municipalite, src.etab, src.name_etab, src.adresse, src.tel, src.active, src.created_at, src.updated_at
FROM (
  SELECT CAST('Dr. Hassen Haddad' AS CHAR(190)) AS fullname, 1 AS type, CAST('Nabeul' AS CHAR(120)) AS region, CAST('Korba' AS CHAR(120)) AS municipalite, 3 AS etab, CAST(NULL AS CHAR(190)) AS name_etab, CAST('8070 Immeuble Zrelli 1er Étage Appartement N°1 Avenue de l''Environnement' AS CHAR(255)) AS adresse, CAST('99493075' AS CHAR(60)) AS tel, 1 AS active, CURRENT_TIMESTAMP AS created_at, CURRENT_TIMESTAMP AS updated_at
  UNION ALL
  SELECT 'Dr. Ahlem Lachhab', 1, 'Monastir', 'Monastir', 3, NULL, '5000 Modern Medical Center, Avenue Mohamed Mhalla', '99388804', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Henda Kachouri Ep Chakchouk', 1, 'Ben Arous', 'El Mourouj', 3, 'Centre Médical Baya au Dessus de Carrefour 2ème Étage Cabinet N°a2.15 Mourouj 5', 'Centre Médical Baya au Dessus de Carrefour 2ème Étage Cabinet N°a2.15 Mourouj 5, El Mourouj 5', '22175700', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ezzeddine Achouri', 1, 'Sousse', 'Akouda', 3, NULL, 'Rue 18 Janvier, Imm. Mourad Ben Slama, Akouda, Sousse', '98550520', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sana Abdelkefi', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, 'Bizerte Nord Centre Avicenne 28 Rue de Belgique à Coté de Star Assurances', '98124298', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lamia Attia Saafi', 1, 'Monastir', 'Monastir', 3, NULL, 'Rue des Combattants, Immeuble Ennasr 4ème Étage, Monastir', '29217551', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Romdhane Ettaieb', 1, 'Manouba', 'Jedaida', 3, NULL, '59 Avenue Habib Bourguiba, Jedaida 1124, Manouba, Tunisie', '98613655', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Faouzi Kallel', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Place du Maghreb Arabe Immeuble Nabli', '98400192', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Safa Ben Haj Hamida Chaari', 1, 'Nabeul', 'Nabeul', 3, NULL, '49 Avenue Habib Bourguiba, Nabeul', '72237337', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Amine Bel Lakhdhar', 1, 'Ben Arous', 'Ben Arous', 3, NULL, '38, Avenue de l''Environnement, 5ème Étage, Cabinet N°5-2, Hammam Lif, Ben Arous, Tunisie', '24178668', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Tahar Zaidi', 1, 'Sidi Bouzid', 'Sidi Bouzid Ouest', 3, NULL, 'Immeuble Ben Mahmoud Avenue Habib Bourguiba Route Principale, En Face de Pharmacie Debbech, 4 Ème Étage - D4, Sidi Bouzid Ouest 9100 Sidi Bouzid Tunisie', '98311769', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Souad Souissi', 1, 'Ben Arous', 'Ben Arous', 3, NULL, 'Résidence Ibn Jazar Av. Habib Thameur, El Mourouj 1', '98585919', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abir Bedoui Ghozzi', 1, 'Sousse', 'Sousse Ville', 1, 'Hôpital Farhat Hached', 'Rue Ibn Jazzar, Immeuble Avicenne, 5ème Étage, En Face de L&rsquo Hôpital Farhat Hached, Sousse', '98686093', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Haythem Bachrouche', 1, 'Nabeul', 'Korba', 3, NULL, 'Rue 2 Mars Immeuble Lotus en Face Lycée Secondaire, Korba', '40168132', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Chawki Gharbi', 1, 'Ben Arous', 'El Mourouj', 3, 'Centre Médical Al Ahmadi Avenue 7 Novembre 1er Étage Cabinet D1.1', '2074 Centre Médical Al Ahmadi Avenue 7 Novembre 1er Étage Cabinet D1.1', '92516311', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Najla Kamoun-Djemal', 1, 'Médenine', 'Houmet Essouk', 3, NULL, 'Complexe Médical Marina Bloc B N°11 Sidi Salem 4180 Houmet Souk Djerba', '98972536', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Leila Dellagi Terras', 1, 'Tunis', 'El Menzah', 3, NULL, 'Maghreb Médical, 1ère Étage, Rue Al Saoud, Manar 3, El Manar 3 2092 Tunis, Tunisie', '98306913', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Marwa Zarrad', 1, 'Ariana', 'La Marsa', 3, NULL, 'Centre Archipel Bloc E 3ème Étage Cabinet E3.4 Av. Khaled Ibn el Walid, Route Ain Zaghouan Nord, Cité les Palmeraies, L''Aouina, 2045 Tunis en Face de la Résiden', '53339888', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rim Hassouna Mtir', 1, 'Tunis', 'Le Bardo', 3, NULL, '28 Bis Bardo, Le Bardo', '92068401', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rim Zaghdoud', 1, 'Médenine', 'Midoun', 2, 'Polyclinique Arij -2éme Étage - Avenue de l''Environnement- Midoun- Djerba', 'Complexe Médical ''Arij'' à Coté de la Polyclinique Arij -2éme Étage - Avenue de l''Environnement- Midoun- Djerba', '50399414', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fayrouz Ben Radhia Nessib', 1, 'Tunis', 'El Menzah', 2, 'Centre Médical Clinique Pasteur 3ème Étage Cabinet C13', 'Centre Médical Clinique Pasteur 3ème Étage Cabinet C13, Centre Urbain Nord', '55356022', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Afef Zarrouk', 1, 'Bizerte', 'Bizerte', 3, NULL, 'Imm. Lido 3 Éme Etage Angle Rue d''Espagne, Bizerte Nord', '98243075', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hajer Ayari', 1, 'Tunis', 'Bab Bhar', 3, NULL, '9 Rue de d''Angleterre, 1ère Etage Tunis, Republique', '55588425', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Walid Chikhaoui', 1, 'Ben Arous', 'Hammam Lif', 3, 'Centre Médical Taiba 36 Avenue de l''Environnement', 'Centre Médical Taiba 36 Avenue de l''Environnement, 2e Étage, Appt. 2-3, Hammam Lif', '50797193', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wafa Fakraoui Krichi', 1, 'Monastir', 'Monastir', 3, NULL, '100 Av. du Combattant Suprême, Immeuble Monastir Médical, 4ème Étage, Monastir', '97605733', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Habib Gardabbou', 1, 'Monastir', 'Ksar Helal', 3, NULL, 'Av. Habib Bourguiba, Centre Zayati, 2ème Étage, Au-Dessus du Yoyo et Strass, Ksar Hellal, Monastir', '98960876', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Oussama Maatouk', 1, 'Monastir', 'Jemmal', 3, 'Centre Médical Bourouz', 'Rue de la Station de Transport Terrestre Bus et Louage, Centre Médical Bourouz, 2ème Étage, Bureau N°8, Jemmel 5020, Monastir', '99453845', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hamdi Guedhami', 1, 'Ben Arous', 'Ben Arous', 3, NULL, '12 Rue de Mongi Slim, Ben Arous', '55596610', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jamila Elleuch Dammak', 1, 'Gabès', 'Gabes Medina', 2, 'Clinique Bon Secours', 'Rue des Combattons Derrière Clinique Bon Secours, Gabes Medina', '22775814', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hana Tlili', 1, 'Tunis', 'El Hrairia', 3, NULL, '37 Rue 4001, Centre el Wafi, 1er Étage, Au Dessus Biat et Bh, Cité Ezzouhour 3, Tunis', '52826451', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Leila Haddad Meddeb', 1, 'Ariana', 'Ariana Ville', 3, NULL, 'Rue Cheikh Mohamed Zaghouani Centre el Farabi, El Menzah 6', '98323433', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mongia Soussou', 1, 'Sfax', 'Sfax Sud', 2, 'Clinique Errachid', 'Route Lafrane Km 3, Prés de Clinique Errachid, Centre Médical Errachid, 1er Étage, Sfax', '95855900', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Laouahedh Dekhil', 1, 'Ariana', 'Ariana', 3, NULL, 'Résidence Aziz Bloc A, 3ème Étage, App. A 33, Avenue Mongi Slim, L''Aouina', '26363739', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Heni Dridi', 1, 'Monastir', 'Moknine', 3, NULL, 'Au Dessus Pharmacie Houssem Besbess, Moknine', '55300106', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hajer Mansouri', 1, 'Tunis', 'Ariana Ville', 3, NULL, '80 Av. Ibn Khaldoun, Résidence Hamza, 2éme Étage App2b, Riadh Andalous Ariana, Cité el Ghazala', '96790495', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Raja Bahri Hadj Ali', 1, 'Ariana', 'Ariana Ville', 2, 'Centre Médical Abou el Kacem Chebbi 1ére Étage App N12- en Face Clinique Ennasr', '121 Rue l''Ère Nouvelle, Centre Médical Abou el Kacem Chebbi 1ére Étage App N12- en Face Clinique Ennasr, Cité Ennasr 2', '98515439', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Chayma Zrig Ep Zahdi', 1, 'Gabès', 'Mareth', 3, NULL, 'Rue 9 Avril 6080 Mareth', '50373170', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Karima Brahim Gardabou', 1, 'Ben Arous', 'Ben Arous', 3, NULL, 'Centre Commercial Challekh 3 Eme Étage App7 Mourouj 4 Près Terminus Metro, El Mourouj 4', '97808230', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lobna Aloui Guesmi', 1, 'Jendouba', 'Jendouba', 3, NULL, 'Complexe Medical Nourane 57 Rue Ali Belehouane 3ème Étage, Jendouba', '97729995', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Abd El Fettah Guermazi', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 - Ennasr Ii 104, Avenue Hédi Nouira Résidence Errayahine', '98380244', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Thouraya Ayari Charfi', 1, 'Ariana', 'La Marsa', 3, NULL, 'Aïcha Médical, Avenue Mongi Slim l''Aouina à Côté de Monoprix 1 Er Étage Cabinet A1.7- Tunis', '20240023', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fatma Marzouki Zaatouri', 1, 'Ben Arous', 'Rades', 3, NULL, 'Avenue Mohamed Ali, Immeuble The Blue Center, Cabinet B1-2, Radès, Ben Arous', '98318277', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Guermazi', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Dar Ettabib, 2éme Étage N°1 Route de Tunis Km 2.5, Sfax Ville', '98410359', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nizar Moulazem', 1, 'Monastir', 'Jemmal', 3, NULL, 'Kbaier Medical, Jemmal', '97957516', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. NÉJia Bellagha Ep El Inkichari', 1, 'Ben Arous', 'Hammam Lif', 3, NULL, 'Centre Ezzine Hamam Lif, 1er Étage Num A101, Hammam Lif', '98333846', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imene Lahmar Boukadida', 1, 'Sousse', 'Hammam Sousse', 3, NULL, 'Av. de la République, Immeuble Knaz, 1er Étage, El Menchia', '97769765', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ali Bouabid', 1, 'Médenine', 'Zarzis', 2, 'Centre Médical Echifa Près de Clinique Amal', 'Centre Médical Echifa Près de Clinique Amal, Zarzis', '50711957', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Samir Ben Miled', 1, 'Ariana', 'El Menzah', 2, 'Centre Médical Coral en Face de Clinique Carthagène - Avenue Zohra Faiza - 5éme Étage Bloc A', 'Centre Médical Coral en Face de Clinique Carthagène - Avenue Zohra Faiza - 5éme Étage Bloc A, Centre Urbain Nord', '98301021', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sobhi Ghanmi', 1, 'Mahdia', 'Mahdia', 3, NULL, 'Avenue Taieb Mhiri Mahdia Immeuble Galaxy 1er Étage', '25960270', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. ImÈN Riahi', 1, 'Bizerte', 'Bizerte Nord', 1, 'Hôpital Régional Habib Bougatfa', '7000 Hôpital Régional Habib Bougatfa', '24588750', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imen Ben Rhouma', 1, 'Kébili', 'Kebili Sud', 3, NULL, 'Rue Mohamed Jlidi, Cité Awled Yaacoub, Près du Laboratoire des Analyses Médicales Sonia Ben Mohamed Kébili 4200, Kebili Sud', '99155240', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Manel Bouslah Ep Guesmi', 1, 'Ariana', 'La Marsa', 3, NULL, 'Residence Farah Lake, Cabinet B1-10 Av. Feuille d''Érable Cité les Pins, Les Berges du Lac2 Tunis, Les Berges du Lac 2', '22145837', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nourchene Khelil Charfeddine', 1, 'Manouba', 'Le Bardo', 3, NULL, 'En Face Monoprix Bardo Centre 8 Av. Habib Bourguiba Imm. Medrara Medical 4 Ème Étage, Le Bardo', '20318195', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Donia Ben Ayed', 1, 'Tunis', 'Mohamadia', 3, 'Centre Médical Abroug', '03 Avenue de la Liberté, Centre Médical Abroug, En Face de la Mosquée Omar Ibn Khattab, Mhamdia, Ben Arous, Tunisie', '97608086', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Afef Ben Salah Ben Hmida', 1, 'Ben Arous', 'El Mourouj', 3, 'Centre Médical Kmar Bloc B A Cote de Carrefour Market Mourouj 5 2ème Étage', 'Centre Médical Kmar Bloc B A Cote de Carrefour Market Mourouj 5 2ème Étage, El Mourouj 5', '98699322', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Afef Fourati Ben Ayed', 1, 'Sousse', 'Sousse Ville', 3, NULL, '13, Av. Mohamed Karoui, Immeuble Meddeb, Sousse', '97622652', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amira Haoua', 1, 'Ariana', 'Nouvelle Medina', 3, NULL, 'Route de Mornag, Centre Phoenix Médical, Au Dessus de Mg, 1er Étage, El Yassminette, Nouvelle Médina, Ben Arous', '23509444', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mouna Ben Harrath Nasri', 1, 'Nabeul', 'Nabeul', 3, NULL, 'Centre el Hakim Ibn Zohr Rue 8000- 1er Étage Cabinet B2.2', '98995308', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Ben Slimen', 1, 'Sfax', 'Sfax Est', 3, NULL, '3052 Rte Mharza Km 4 Complexe Mharza Centre A206 Etg 2', '98543490', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Yassine Aissa Najjar', 1, 'Nabeul', 'Dar Chaabane Elfehri', 3, NULL, 'Avenue de la Paix en Face de la Pharmacie Fatma Guiga Dar Chaabane Fehri, Nabeul, Dar Chaabane Elfehri', '92505232', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abderraouf Chabchoub', 1, 'Ariana', 'Ariana Ville', 3, 'Centre Médical Kamoun', 'Boulevard de l''Ere Nouvelle, Centre Médical Kamoun, 3ème Étage, Cabinet B3-2, Cité Ennasr 2, Ariana', '98324262', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nada Bel Hadj Brahim', 1, 'Médenine', 'Houmet Essouk', 3, NULL, 'Complexe l''Élysée 2ème Étage, Houmet Essouk', '98940014', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Said Bibi', 1, 'Tunis', 'Cité El Khadra', 3, NULL, 'Cité el Khadra 1003 Tunis', '95526526', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hichem Feki', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Avenue la Liberté 14 Janvier, Imm. Rayen 3ème Étage App B14, Sfax el Jadida 3027, Sfax', '97533720', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Souad Belhadj Bousnina', 1, 'Ariana', 'Ezzahra', 2, 'Clinique Avicenne', 'Echifa Médical 38 Avenue Moheiddine el Klibi Prés Clinique Avicenne, El Manar 2', '98325232', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amel El Hammami Khadhraoui', 1, 'Jendouba', 'Tabarka', 3, NULL, '14, Rue Khemir-Tabarka, Tabarka 8110, Jendouba, Tunisie', '98620979', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imen Majdoub', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Route Zaghouan Km 24 Sfax Ville 3000 Sfax Tunisie', '22782982', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mariem Mahjoub Souiden', 1, 'Ben Arous', 'El Mourouj', 3, NULL, 'Elyes Médical 1ère Étage Cabinet N° 2 el Mourouj 1 2074 Ben Arous Tunisie', '99975844', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Tarek Elakkad', 1, 'Ariana', 'Ariana Ville', 3, NULL, 'Avenue de l''Ere Nouvelle Centre Kammoun Médical 2001- Cité Ennasr, Ariana, Cité Ennasr 2', '98669782', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Marouene Babay', 1, 'Sousse', 'Sousse Ville', 3, NULL, 'Imm. Panorama Sousse Ville 4000 Sousse Tunisie', '99888398', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imen Chebbi', 1, 'Ben Arous', 'El Mourouj', 3, NULL, 'Centre City Center, Iris Bloc A, 3ème Étage', '54932573', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sameh Annabi Dekhil', 1, 'Ariana', 'Ariana', 3, NULL, '65, Avenue Fethi Zouheir Route de Raoued 1er Étage App.3', '22746602', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Souhir Thraya Ellafi', 1, 'Tunis', 'La Marsa', 3, NULL, '1053 Hannibal Medical Center 4ème Étage Cabinet 4.03 Cité les Pins les Berges du Lac I Tunis', '23292524', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mtir Trabelsi', 1, 'Tunis', 'Tunis', 3, NULL, '50, Avenue Hédi Chaker Imm.mnaya App.b 201 2ème Étage', '98616261', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Walid Slama', 1, 'Tunis', 'Nouvelle Medina', 3, NULL, '2063 1, Rue de la Justice', '98676685', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Balkis Ben Salah Somrani', 1, 'Ariana', 'Ariana', 3, NULL, 'Alpha Médical 2ème Étage Cabinet B2.1- 15, Avenue Mustapha Mohsen', '98323175', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hager Dhaoui Boussetta', 1, 'Nabeul', 'Nabeul', 3, NULL, '8000 49, Avenue Hédi Chaker 1er Etage', '98309973', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Naziha Guelmami Aouadi', 1, 'Le Kef', 'Le Kef Est', 3, NULL, '7100 Avenue Mongi Slim Immeuble Magazin Général', '98350560', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. FÉRid Jaafar', 1, 'Tunis', 'Hammam Lif', 3, NULL, '2050 10, Avenue Habib Bourguiba', '98308045', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ameur Jouirou', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Bd 14 Janvier 2011 Immobilière Médicale les Oliviers', '98401909', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wafa Ben Aissia Brahem', 1, 'Ariana', 'Ariana', 3, NULL, 'Résidence l''Oasis Rue Fethi Zouheir Route Raoued 1er Étage Bureau N°4', '97420206', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Najeh Ghram', 1, 'Tunis', 'Le Bardo', 3, NULL, '2000 Immeuble Golden Queen 2ème Étage App B3 Avenue Habib Bourguiba', '98654666', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wafa Dhiab Melayah', 1, 'Sousse', 'Kalaa El Kebira', 3, NULL, '4060 Boulevard 14 Janvier 2011 Immeuble Essaada', '90765358', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sana Hamrouni Gmati', 1, 'Nabeul', 'Hammamet', 3, NULL, '8056 Immeuble Essalem 3ème Étage Bureau N°a.3-3 Route Nationale N°1 Km.61', '21221965', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sonia Khanfir Besbes', 1, 'Tunis', 'Tunis', 3, NULL, '9, Avenue Habib Thameur Imm.goddi 2ème Étage N° B1', '98636226', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Tahar Ghozzi', 1, 'Tunis', 'Ariana Ville', 3, NULL, 'Imm. Saf Ariana 2080 Ariana', '71712954', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fethi Ben Fredj', 1, 'Nabeul', 'Nabeul', 3, NULL, '14, Rue de la République', '98308635', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Jameleddine Mestaoui', 1, 'Tataouine', 'Tataouine Sud', 3, NULL, '3200 13, Rue de Carthage', '98212657', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lotfi Yacoub', 1, 'Ben Arous', 'Hammam Lif', 3, 'Centre Médical Hannibal 1er Étage 24', '2050 Centre Médical Hannibal 1er Étage 24, Boulevard de l''Environnement Hammam Lif', '92812800', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imen Ben Abdelkrim Amroussi', 1, 'Sousse', 'Msaken', 3, NULL, '4070 Avenue 20 Mars Imm. Zommit', '23524571', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Adel Wardani', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Rue Léopold Senghor Immeuble Nouira', '98684123', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sihem Rokbani Barsaoui', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2080 Avenue Taieb m''Hiri', '98293317', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sana Elloumi-Abdelkafi', 1, 'Sfax', 'Sakiet Ezzit', 3, NULL, '3041 Rte Teniour Km 6 Imm. Cristal Palace Etg 4 N°24 Sfax 3041 Rte Teniour Km 6 Imm. Cristal Palace Etg 4 N°24', '54564040', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Meriam Khelfa Amara', 1, 'Médenine', 'Ben Guerdane', 3, NULL, '4160 Complexe Médical Ibn Zohr 1er Étage', '23476109', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. M''Hamed Mehiar Harbi', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 48 Bis, Avenue Othmane Ibn Affane 1er Étage App.b-16 el Menzah 8', '98303428', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rafia Abdelwahed Kaba Mustafa', 1, 'Tunis', 'Tunis', 3, NULL, 'Immeuble Silver Tower 121, Avenue Hédi Chaker', '22598132', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdelaziz Kesraoui', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 13, Rue Espagne', '72232332', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mounira Braham Ayachi', 1, 'Monastir', 'Moknine', 3, NULL, '5050 Immeule Ezzahra Rond Point Eljara Route Teboulba', '98677438', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sonia Grati Bahloul', 1, 'Sfax', 'Sakiet Eddaier', 3, NULL, '3011 Rte Mahdia Km 7 Sakiet Eddaier Imm. Naifer Mezanine N° 12', '74890386', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mouna Sellemi', 1, 'Gabès', 'Gabes Medina', 3, 'Centre Médicale Oumayma - 2ème Étage - Bureau N°2', '6000 Avenue Mongi Slim - Centre Médicale Oumayma - 2ème Étage - Bureau N°2', '94846429', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Leila Bessioud', 1, 'Tunis', 'La Marsa', 3, NULL, '2045 Résidence Jannet Ii Avenue Mongi Slim 1er Étage Bloc B Appartement B1', '20586708', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. InÈS Ben Messaoud Razzeg', 1, 'Tunis', 'Mannouba', 3, NULL, '2010 Manouba Médical 1, Rue de l''Argentine App N°8', '97650735', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Saida Hassayoun', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Bd 14 Janvier 2011 Immobilière Médical', '98407532', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Habiba Hafsi', 1, 'Siliana', 'Siliana Sud', 3, NULL, '6100 Complexe Médical Rue Habib Thameur', '23717098', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Bassem Rabii', 1, 'Nabeul', 'Soliman', 3, NULL, '8020 Avenue Habib Bourguiba 1er Étage', '23561620', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imene Khalef Laadhari', 1, 'Sousse', 'Akouda', 3, NULL, '4022 Avenue de la République Station Gamoun', '53479216', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Charfeddine Doggaz', 1, 'Tunis', 'El Ouerdia', 3, NULL, '1009 18, Rue Mouaouia Ibn Houdaij el Ouardia', '98337393', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. M''Hamed Ali Bouaziz', 1, 'Tunis', 'Bab Bhar', 3, NULL, '1000 3, Rue des Entrepreneurs', '97328738', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khaoula Ben Cheikh', 1, 'Bizerte', 'Ras Jebel', 3, NULL, '7070 41, Avenue Habib Bourguiba 2ème Étage Bureau N°5 Ras Jebal', '54453403', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Raja Debbabi Krifa', 1, 'Manouba', 'Hammam Lif', 3, NULL, '2050 40, Avenue de l''Environnement', '98647039', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Fathi Ernez', 1, 'Sousse', 'Sousse', 3, NULL, '4002 11 Rue Dr Moreau', '98400307', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Dorra Fellah Ep Mejri', 1, 'Tunis', 'El Menzah', 3, 'Centre Médical Ibn el Haythem 2éme Étage Cabinet N°2-3 18 Rue Ali Ayari', '1013 Centre Médical Ibn el Haythem 2éme Étage Cabinet N°2-3 18 Rue Ali Ayari', '52966409', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Frej Hassen', 1, 'Monastir', 'Ksar Helal', 3, NULL, '5070 Avenue Habib Bourguiba Centre Zayati', '98514198', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Yamen Baccar', 1, 'Tunis', 'Tunis', 3, NULL, 'Elyes Center Avenue Habib Bourguiba 2ème Étage', '21075681', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Houcine Houachine', 1, 'Tunis', 'El Ouerdia', 3, NULL, '85, Avenue Bellevue el Wardia 1009 Tunis', '95404232', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wafa Ben Romdhane Aloulou', 1, 'Gabès', 'Gabes Medina', 3, NULL, '6000 Avenue Mongi Slim - Immeuble Manar Médical 3ème Étage - Place de la Gare', '55111120', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Dhekra Ben Ayed Ben Khlifa', 1, 'Le Kef', 'Le Kef Est', 1, 'Hôpital Régional le Kef', '7100 Hôpital Régional le Kef', '92727460', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Ridha Bairam', 1, 'Tunis', 'El Kram', 3, NULL, '2015 254, Avenue Habib Bourguiba', '98304061', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abderrahman Bagais', 1, 'Ariana', 'Ettadhamen', 3, NULL, '2041 l''Entilaka Médical Route de Bizerte Km3.5', '21017147', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Noureddine Cherif', 1, 'Ariana', 'Ariana Ville', 3, 'Centre Médical el Farabi Rue Cheikh Mohamed Zaghouani Cabinet A-10 3ème Étage', '2091- el Menzah Vi Centre Médical el Farabi Rue Cheikh Mohamed Zaghouani Cabinet A-10 3ème Étage', '58119219', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Habib Harki', 1, 'Tunis', 'Tunis', 3, NULL, 'Route de Kairouan', '98203637', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Noomene El Blaiech', 1, 'Tunis', 'Megrine', 3, NULL, '2033 Immeuble Mégrine Centre 58, Avenue Habib Bourguiba- Mégrine Côteaux', '98334421', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hamouda Mestiri', 1, 'Tunis', 'La Marsa', 3, NULL, '2070 11, Avenue Taieb m''Hiri', '98304244', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Issam Romdhane', 1, 'Tunis', 'Tunis', 3, NULL, '63, Avenue Habib Bougatfa', '24061441', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amel Amara Ben Ghalia', 1, 'Ben Arous', 'Ben Arous', 3, NULL, 'Immeuble el Hakim Avenue de Paris 1er Étage App.1 2013 Ben Arous', '98329945', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Salwa Thamri', 1, 'Tunis', 'Tunis', 3, NULL, 'Immeuble Essidik Avenue de la Liberté 1er Étage', '99216642', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mouldi Ouerghi', 1, 'Le Kef', 'Le Kef Est', 3, NULL, '7100 Imm. Al Izdihar 1er Étage Rue Hédi Chaker Imm. Al Izdihar', '98447038', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mondher Cheour', 1, 'Tunis', 'La Marsa', 3, NULL, '2045 Résidence Chourouk Bloc A 2ème Étage Rue Khaled Ibn el Walid', '22307140', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Moncef Ben Achour', 1, 'Tunis', 'Fouchana', 3, NULL, '2082 Rue Bechir Sfar', '98320168', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Ali Mekki', 1, 'Sfax', 'Sakiet Ezzit', 3, NULL, '3041 Rte Taniour Km 4 Imm. Fleur de Lys Etg 1 App 13', '98415470', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Raja Mehdoui Kilani', 1, 'Nabeul', 'Nabeul', 3, NULL, '8000 Avenue de la Révolution 1er Étage App.11', '95950499', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. FÈDra Bennour Jebali', 1, 'Tunis', 'Tunis', 3, NULL, 'Bardo Center Bloc N° 7 Étage 2 App. N° 8', '98357526', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rachid Besbes', 1, 'Nabeul', 'Nabeul', 3, NULL, '31, Rue Ali Belhouane', '98301141', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Atef Sayeh', 1, 'Siliana', 'Siliana Sud', 3, NULL, '6100 Avenue des Mrtyrs Immeuble Sonbola', '98813305', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Mouldi Hedoui', 1, 'Gabès', 'Gabes Medina', 3, NULL, '6000 Avenue Mongi Slim', '98420127', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mustapha Guezmir', 1, 'Bizerte', 'Bizerte', 3, NULL, 'Rue 9 Avril', '98442533', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mariem Tmar Ep Cheikh Rouhou', 1, 'Ariana', 'Raoued', 3, 'Centre Médical 05', '2083 Centre Médical 05, Avenue Asdrubal Cité la Gazelle', '51885252', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mahmoud Ben Aziza', 1, 'Monastir', 'Moknine', 3, NULL, '5050 44, Avenue Farhat Hached', '73475263', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imen Hadj Ahmed', 1, 'Tunis', 'Ariana Ville', 3, 'Centre Médical Ibn Nafiss 2ème Étage 84 Bis', '2080 Centre Médical Ibn Nafiss 2ème Étage 84 Bis, Avenue Habib Bourguiba', '28672740', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khaled Kabbous', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2080 la Perle de l''Ariana 1er Étage Cabinet N°3 Avenue Taieb m''Hiri', '22311215', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Haithem Khaskhoussi', 1, 'Sousse', 'Sousse Jaouhara', 3, NULL, '4051 Avenue des Palmiers', '96160251', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Besma Tayahi Karabibene', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 Bizerte Médicale 21, Rue d''Alger 2ème Étage', '22698454', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khaled Salhi', 1, 'Médenine', 'Houmet Essouk', 3, NULL, '4180 Complexe Médical Essalem - Avenue Boumessouer - 1er Étage - Bureau N°5', '22797639', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sahbi Karoui', 1, 'Tunis', 'El Menzah', 3, NULL, '2092 Delta Médical Rue Habib Echatty', '98301382', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Habib Kchaou', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3027 Rte Gremda Av. Carthage Imm. Olivia Bloc A2 Eme Etage Appt N1', '98550898', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Noureddine Larbi', 1, 'Monastir', 'Monastir', 3, NULL, '209, Avenue Habib Bourguiba 2ème Étage App B2-7', '22543524', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mehdi Hamed Kortas', 1, 'Jendouba', 'Jendouba', 3, NULL, '8100 Avenue Habib Bourguiba Immeuble Hassen Ochi', '96040200', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khaled Lajmi', 1, 'Monastir', 'Ksar Helal', 3, NULL, '5070 Avenue Habib Bourguiba Immeuble Helal Médical', '98623659', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lotfi Karboul', 1, 'Médenine', 'Médenine', 3, NULL, 'Complexe Médicale ''Dar el Hakim, Route Touristique - Houmt Souk - Jerba', '98214676', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. HaÏFa Slama Sellami', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2080 34, Avenue Habib Bourguiba Imm. le Petit Palais 2ème Étage A22', '98266794', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mahmoud Baraket', 1, 'Tunis', 'Mannouba', 3, NULL, '2010 Rue 13 Août Résidence Essaâda', '98333631', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samia Gaaliche-El Afrit', 1, 'Sousse', 'Msaken', 3, NULL, '4070 1 Rue Taieb Mhiri', '98400298', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hichem Ben Gara', 1, 'Bizerte', 'Menzel Jemil', 3, NULL, '7080 133, Rue des Martyrs', '98273428', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Monaem Gouader', 1, 'Gafsa', 'Gafsa Sud', 3, NULL, '2100 Rue Houcine Bouzaine Imm. Karoui 2ème Étage', '97274108', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fatma Zohra Chioukh Toumi', 1, 'Sousse', 'Sousse Jaouhara', 3, NULL, '4051 Imm. le Relais Rue Perle du Sahel Khezema Est', '20262676', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. FayÇAl Cherichi', 1, 'Tunis', 'El Menzah', 3, NULL, '2092 Résidence les Jasmins d''El Manar 2ème Étage App C11', '98301139', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samir Fejji', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 45, Rue de 2 Mars 1934', '29415283', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sameh Chouaibi Briki', 1, 'Tunis', 'El Menzah', 3, NULL, '2092 Centre Avicenne 1er Étage Cabinet N°3 Avenue Mohamed Abdelwaheb', '97788178', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Olfa Ferid', 1, 'Nabeul', 'Nabeul', 3, 'Centre Médical Aya Avenue Hédi Nouira 3ème Étage Bureau A3.2', '8000 Centre Médical Aya Avenue Hédi Nouira 3ème Étage Bureau A3.2', '98651664', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Salmen Loukil', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3032 Rte Gremda Km 2 Imm. Syphaxe Medical Etg 4 Bueau N 43', '26443335', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ali Bibi', 1, 'Tunis', 'Tunis', 3, NULL, 'Rue el Mourouj Imm.m App.m1', '98321757', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Taoufik Maalel', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Rue Ibn el Jazzar Immeuble Rouatbi', '20399053', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fedia Labidi Jeridi', 1, 'Béja', 'Mejez El Bab', 3, NULL, '9070 Avenue Habib Bourguiba Colisée Chahed', '97828873', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hadhami Ghaffari', 1, 'Tunis', 'La Marsa', 3, NULL, '2045 el Aouina Médical 1er Étage Cabinet A6 Avenue de l''Environment', '22384881', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ghaith Atallah', 1, 'Tunis', 'Carthage', 3, NULL, '2016 Résidence la Belle de Carthage 3ème Étage Bureau N°a3-6 Charthage Tunis', '98647240', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amina Ben Khalifa', 1, 'Tunis', 'Carthage', 3, NULL, '1054 07, Rue Ibn Khaldoun', '20312390', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Taoufik Jrad', 1, 'Sousse', 'Msaken', 3, NULL, '4070 Msaken Avenue Taieb Mhiri', '98581652', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Chahra Bouafsoun Mili', 1, 'Monastir', 'Jemmal', 3, NULL, '5020 Rue Hassen Borji Immeuble Sarraj Médical', '98683604', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Meziene Bouali', 1, 'Kasserine', 'Kasserine Nord', 3, NULL, '1200 10 Av. 18 Janvier', '28411941', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hayet Mokaddem', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 Avenue Ibrahim Ibn el Aghleb', '94455430', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ridha Ayache', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 Résidence Ettilel 76, Avenue Hédi Nouira Immeuble D2 2ème Étage', '98352247', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nouha Mejri', 1, 'Tunis', 'Tunis', 3, NULL, '13 Rue 4366 au-Dessus de Magoptik Kids Zahrouni. 1er Étage, Bureau Numéro 4, Denden', '94100776', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Marwen Zayani', 1, 'Nabeul', 'Soliman', 3, NULL, '8020 49, Avenue Habib Bourguiba', '98512616', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed NÉJib Raboudi', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 Résidence les Emeraudes 2ème Étage Bloc C App.7 Avenue de l''Ere Nouvelle', '98312948', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jalel Chaieb', 1, 'Sousse', 'Sousse', 3, NULL, '47 Av.l.senghor', '98400146', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hind Badri', 1, 'Tunis', 'Tunis', 3, NULL, 'Avenue Habib Bourguiba Complexe Médical Baklouti 1èr Étage N°12', '95456002', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Manel Hanafi Ep Maghrebi', 1, 'Ariana', 'La Soukra', 3, NULL, '2036 le Doyen Médical Rue Fattouma Bourguiba Route de la Soukra', '99998788', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amel Ben Ammar Debbabi', 1, 'Tunis', 'Rades', 3, NULL, '2040 Résidence Chaima Rdc Rue Mongi Slim', '22519177', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rim Bouhlel Khnissi', 1, 'Tunis', 'Tunis', 3, NULL, 'Avenue de la République Face Grande Mosquée Immeuble Habib Bouhlel', '97480047', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Sofiane Meherzi', 1, 'Tunis', 'La Marsa', 3, NULL, '2078 Résidence Ennakhil 2 Rue du Koweit Bloc B App.2', '25839391', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Adel Ben El Kadhi', 1, 'Tunis', 'Tunis', 3, NULL, 'Avenue Habib Bourguiba Imm. Mehrez Attia el Jebli', '98346542', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Bouraoui Zone', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 Mahdia Kairouan', '98831434', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rym Zardoub Achour', 1, 'Tunis', 'Tunis', 3, NULL, 'Centre Dorra Rue el Moussikar Mohamed Abdelwaheb 1er Étage App.a4', '20413334', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Taoufik Mkadmi', 1, 'Tunis', 'Tunis', 3, NULL, '50, Avenue Habib Bourguiba', '98369707', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Med El Adel Chouayekh', 1, 'Sfax', 'Sfax Ville', 3, NULL, '8 Rue Abou el Kacem Chebbi 3000 Sfax', '98564545', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Erij Boubaker', 1, 'Monastir', 'Monastir', 3, NULL, 'Avenue Habib Bourguiba', '73681650', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Faten Zayane', 1, 'Monastir', 'Monastir', 3, NULL, 'Avenue des Martyrs Lamti Center', '98339491', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Chaima Balhi', 1, 'Béja', 'Beja Nord', 3, NULL, '9000 Rue Okba Ibn Nafaa', '55047255', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ahlem Hellara Khefacha', 1, 'Monastir', 'Monastir', 3, NULL, '5000 Imm. Rachid Avenue Combattant Suprême', '53557687', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nesria Bouras', 1, 'Tunis', 'Tunis', 3, NULL, 'Avenue Habib Bourguiba Bardo Center Imm. N° 1', '98343493', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hafedh Bahloul', 1, 'Sfax', 'Sakiet Eddaier', 3, NULL, 'Rte Mahdia Km 6 Imm. Chaabane Etg 1 3011 Sakiet Eddaier Sfax', '98413709', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nassima Balhoudi', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, 'Avenue Ibn el Aghleb Immeuble Ibn Roched Kairouan 3100 Kairouan', '54760149', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amel Nadri', 1, 'Médenine', 'Medenine Sud', 3, NULL, '4100 Avenue Slaheddine Ayoubi - Cité de la Protection Civile', '98280503', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohieddine Radhouane', 1, 'Monastir', 'Monastir', 3, NULL, '5000 Rue de Leader Houmet Trabelssia', '98452750', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Anas Krichen', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3003 Rte Gremda Km 6.5 Imm. Amouri Sfax', '98656097', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samia Cherif Ben Rhaiem', 1, 'Ariana', 'La Soukra', 3, NULL, '2073 Saphir Médical Bloc A 2ème Étage App.a2-10 Avenue Mustapha Mohsen', '98266758', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed BÉChir Bouraoui', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Avenue Léopold Senghor', '98400128', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nawal Derdabi Gamra', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Immobilière Médicale Bd 14 Janvier', '95125555', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Chadli Ben Abdallah', 1, 'Tunis', 'Megrine', 3, NULL, '2033 29, Avenue Farhat Hached', '98327879', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Maissa Nawar', 1, 'Manouba', 'Mornaguia', 3, NULL, '1110 Centre Diamant Médical Rue Arabie Saoudie', '20160734', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rym Hmidet Neffati', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 Centre les Jonquilles Avenue Hédi Nouira Bloc A Bureau N°a5-6', '28515190', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hatem Ben Amar', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Rte Lafran Km 4 Imm. Mahsouna Esc C Etg 2 N°5 Sfax 3003 Sfax', '98415511', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Iheb Attia', 1, 'Tunis', 'Tunis', 3, NULL, 'Savary Médical 31 Bis, Avenue Alain Savary 2ème Étage Cabinet 9', '98302666', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ahmed Ayadi', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3027 Rue Hedi Nouira Imm. Emna City Bloc A', '98278887', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Moncef Kamoun', 1, 'Tunis', 'Cité El Khadra', 3, NULL, '1002 39, Rue de Cologne Bloc B 3ème Étage', '98316608', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Zoubeir Ben Boubaker', 1, 'Nabeul', 'Nabeul', 3, NULL, '3, Avenue Ahmed Khabthani', '98305579', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Leila Bouzidi', 1, 'Manouba', 'Mannouba', 3, NULL, '2011 Résidence Ettawfik App.n°8- 2ème Étage- 17, Avenue de l''Indépendance', '96061756', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Yousra Arfaoui Garbouj', 1, 'Manouba', 'Mannouba', 3, 'Centre Médical Nour 2ème Étage App.a2.6 2', '2011 Centre Médical Nour 2ème Étage App.a2.6 2, Avenue Kasserine- Den', '21474963', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Aicha Hadj Ali Mahjoub', 1, 'Monastir', 'Ksibet El Mediouni', 3, NULL, '5025 31 Boulevard de l''Environnement', '98677074', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sonia Fitouhi Kouki', 1, 'Ben Arous', 'Rades', 3, NULL, '2040 Rades Medical 8, Rue Ali Ben Ayed 1er Étage Cabinet N°1', '94754766', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Aida Falfoul Ben Aissa', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 Rue 2 Mars 1934', '98904355', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ibtissem Frikha Maaloul', 1, 'Ariana', 'La Soukra', 3, NULL, '2036 Résidence Ayech Ii 55, Avenue de l''Uma Bloc A 1er Étage App.a1.2', '98667525', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed El Bez', 1, 'Tunis', 'Le Bardo', 3, NULL, '2017 App.1 Résidence Seville 1 9, Avenue de l''Indépendance', '97578120', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdelhamid Gnaoui', 1, 'Jendouba', 'Jendouba', 3, NULL, '8100 Rue Omar Elkhaiem 1ér Étage Bureau N° 5', '98446038', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khaled Sghaier', 1, 'Bizerte', 'Menzel Bourguiba', 3, NULL, '7050 Aziz Center 2ème Étage B107avenue de l''Indépendance Menzel Bourguiba', '98441943', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Afef Jguirim', 1, 'Mahdia', 'Souassi', 3, NULL, '5140 Imm. Al Salam Rue Habib Bourguiba, Route Chorbane', '28560077', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Kamel Kamoun', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Av. des Martyrs Imm. Palmarium B Etg 4 Appt B404 3027 Sfax', '73681989', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samia Taalouche Turki', 1, 'Nabeul', 'Hammamet', 3, NULL, '8050 77, Avenue de la République- 1er Étage App.n°3', '98628312', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Anouar Ksentini', 1, 'Sfax', 'Sfax Est', 3, NULL, '37 Avenue de Jordanie Cite el Habib 3052 Sfax', '98412588', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Faouzi Skhiri', 1, 'Monastir', 'Monastir', 3, NULL, '5000 Avenue de la République Borj Khefacha 2', '98406619', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amel Oueslati Nouri', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2080 le Miracle Médical 1er Étage App.b1-6 Avenue Ibn Khaldoun', '26538415', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Faten Saidi Bibi', 1, 'Sfax', 'Sfax', 3, NULL, '11 Rue Habib Thameur Mahres', '98421636', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jamel Chnayna', 1, 'Tunis', 'Tunis', 3, NULL, 'Hannibal Médical Center Cité les Pins 1er Étage Cabinet 1.10', '25344997', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Karima Abidi', 1, 'Jendouba', 'Jendouba', 3, NULL, '8100 Avenue Habib Bourguiba Avenue des Palmiers', '98644372', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ahmed Ben Abdallah', 1, 'Ariana', 'La Soukra', 3, NULL, '2036 Elysée Médical Avenue Dar Fadhal 2ème Étage', '98314305', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samir Bouguessas', 1, 'Ben Arous', 'Ben Arous', 3, NULL, '75, Avenue Salammbo App N° 5', '98339368', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Aleya El Fehaiel', 1, 'Tunis', 'Cité El Khadra', 3, NULL, '1002 63, Avenue de la Liberté', '97601239', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. HÉDi Bouzidi', 1, 'Tunis', 'Mnihla', 3, NULL, '2094 Wafa Centre 2ème Étage Bureau N°1 Route de Bizerte', '98136318', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Soufia Khattech', 1, 'Sousse', 'Sousse Jaouhara', 3, 'Centre Médical les Oliviers', '4051 Centre Médical les Oliviers', '98701938', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ridha Marrakchi', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3027 Imm. Ibn Zohr Etg 1 Appt A12 Sfax Imm. Ibn Zohr Etg 1 Appt A12', '98410045', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Ridha Akacha', 1, 'Tunis', 'Cité El Khadra', 3, NULL, '1002 Boulevard 7 Novembre Spcm Ettaoufik', '98323521', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Haifa Chafai', 1, 'Manouba', 'Ettahrir', 3, NULL, '2042 Immeuble B 1er Étage App.n °7-2 33, Avenue des Martyrs Cité 18 Janvier', '25712506', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samy Jebnoun', 1, 'Tunis', 'El Menzah', 3, NULL, '2092 Avicenne Médical 02, Avenue Tahar Sfar 2ème Étage Cabinet 10', '98330412', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Fathi Hamza', 1, 'Mahdia', 'Mahdia', 3, NULL, '5100 Avenue Habib Bourguiba', '55433488', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Narjess Tirellil Ben Fredj', 1, 'Tunis', 'Tunis', 3, NULL, 'Bardo Center Immeuble 4- 1er Étage App.7', '98310141', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Najeh Barhoumi', 1, 'Tunis', 'Tunis', 3, NULL, 'Avenue Habib Bourguiba, 1 Rue Ali Antar 1er Étage', '98538620', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdelaziz Ben Kram', 1, 'Le Kef', 'Le Kef Est', 3, NULL, '7100 Rue Hédi Chaker', '97961738', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Randa Ziadi Ep Mejdoub', 1, 'Monastir', 'Ksar Helal', 3, NULL, '5070 Immeuble Meriem Avenue Habib Bourguiba', '55838426', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mouldi Lahmar', 1, 'Monastir', 'Monastir', 3, NULL, 'Av.de la République', '73250234', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wissal Hannachi', 1, 'Tunis', 'Tunis', 3, 'Centre Médical la Palmeraie 2ème Étage App.205- 2 Avenue Hédi Chaker', 'Centre Médical la Palmeraie 2ème Étage App.205- 2 Avenue Hédi Chaker', '98446966', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jihene Bouzaraa Jelassi', 1, 'Tunis', 'Tunis', 3, NULL, '14, Avenue Habib Bourguiba Anle Rue d''Algérie N°35 2ème Étage App.8', '95765119', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Faouzia Khaldi', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 Rue Medinat Kadhima', '98323699', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nejah Boujelbane', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Av. des Martyrs Imm. Palmarium 3 Bloc d Etg 3 3003 Sfax', '98410929', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Naceur Zarrouk', 1, 'Siliana', 'Siliana Sud', 3, NULL, '6100 Rue Abdessattar Dridi', '98813119', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Robka Kassiri', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 11 Rue 3 Août Trocadéro', '98400139', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ftouhi Dhorbani', 1, 'Béja', 'Beja Nord', 3, NULL, '9000 Avenue 18 Janvier', '97794091', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hana Ridene', 1, 'Nabeul', 'Kelibia', 3, NULL, '8090 Avenue Ali Belhaouane Bureau N°31-3ème Étage', '24845614', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nizar Nouaili', 1, 'Ariana', 'Mnihla', 2, 'Clinique Pédiatrique de Tunis', '2094 Clinique Pédiatrique de Tunis', '98665399', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Houda Ben Ali', 1, 'Tunis', 'Tunis', 3, NULL, '28, Rue Taieb Mhiri', '98643459', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nabila Gazzeh Bahroun', 1, 'Tunis', 'La Marsa', 3, NULL, '2045 Résidence Riadh Soukra Rue Khaled Ibn el Walid Imm. Folla I- 2ème Étage App.a.21- 2045 Ain Zaghouan', '97470191', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Habib Zahouani', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Rue Ribat Résidence Ribat', '98400260', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ahmed Gharbi', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3027 Av. la Liberté 14 Jan Imm. Aida Esc B N° 301', '22759533', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hazar Turki Triki', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3027 Av. de Carthage Rte Gremda Imm. Madina Centre 2 Bloc d', '96269129', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Olfa Ghanmi', 1, 'Sidi Bouzid', 'Sidi Bouzid Ouest', 3, NULL, '9100 Imm. Essalem Avenue Habib Bourguiba', '93337997', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Chokri Ben Moussa', 1, 'Tunis', 'Tunis', 3, NULL, '5, Avenue Habib Bourguiba Colisée', '98330599', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rafik Farhat Guerfala', 1, 'Médenine', 'Houmet Essouk', 3, NULL, '4180 Ulysse Médical Route de l''Aéroport Houmet Essouk', '75652871', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. AÎCha Amira Ghedamsi', 1, 'Ben Arous', 'Megrine', 3, NULL, '2033 Cité Jawhara 2ème Étage Cabinet N°2 12, Rue Jendouba', '97418839', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nahla Lahmeri', 1, 'Tunis', 'Tunis', 3, NULL, 'Angle Avenue Habib Bourguiba & Rur Ibn Khaldoun 1er Étage App.5', '99951476', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdessalem Harrathi', 1, 'Médenine', 'Midoun', 3, NULL, 'Avenue 7 Novembre Complexe Médical Avicenne - 1er Étage 4116 Médennine', '98647293', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mustapha Abderrahim', 1, 'Gabès', 'Gabes Medina', 3, NULL, '6000 Avenue Mongi Slim', '98420092', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sarra Barrak Essid', 1, 'Ariana', 'Raoued', 3, NULL, '2083 29, Avenue Hassen Belkhodja 2083 Cité el Ghazala- Ariana', '98341925', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lotfi Trabelsi', 1, 'Sfax', 'Sakiet Ezzit', 3, NULL, '3021 Rte de Tunis Km 6 Imm. Ennakhla Etg 2 App 21', '98446166', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. InÈS Kasraoui', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 Tunisie Médicale 2ème Étage Cabinet B8-2 Avenue Hédi Nouira Ennasr Ii', '25545793', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Manel Nammouchi', 1, 'Gabès', 'Gabes Medina', 3, NULL, '6000 N°17 Avenue Mongi Slim - Immeuble Bachraoui 2 3ème Étage', '21798747', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ines Kacem Hamouda', 1, 'Sousse', 'Sousse Ville', 3, 'Centre Médical Carré Blanc', '4000 Avenue Ibn Jazzar Centre Médical Carré Blanc', '29004959', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sabeur Hammami', 1, 'Monastir', 'Monastir', 3, NULL, '5000 Avenue du Combattant Suprême Immeuble Ghomrassi', '98676614', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ferid Souibgui', 1, 'Nabeul', 'Nabeul', 3, NULL, '8000 Immeuble Dimassi 44, Rue Hédi Chaker 4ème Étage App.a4.2', '22354470', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Megdiche', 1, 'Tunis', 'Tunis', 3, 'Centre Médical les Jasmins 2ème Étage Cabinet 2-4', 'Centre Médical les Jasmins 2ème Étage Cabinet 2-4', '98303716', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sihem Mammou', 1, 'Tunis', 'La Marsa', 3, NULL, '1053 Erable Médical 4ème Étage Cabinet 342 Cité les Pins Lac Ii Tunis', '98646823', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ikram Louati', 1, 'Tunis', 'La Medina', 3, NULL, '1008 13, Avenue Taha Houssein 3ème Étage Cabinet 3-1', '97330048', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Bejaoui', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2037 Cité el Faouz Jardin', '98317261', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Widad Lariani Hamza', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2091 Centre Jamil Bloc 2 Niveau 2 el Menzah 6', '26044853', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Ben Abderrahmen', 1, 'Monastir', 'Monastir', 3, NULL, '5000 Avenue de la République Immeuble Najah', '98288807', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Saadia Ben Amor', 1, 'Tunis', 'Mornag', 3, NULL, '2090 Immeuble Lagil 2ème Étage Bureau N°4 -19, Avenue Farhat Hached Mornag', '98321313', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Serra Ayadi-Sahnoun', 1, 'Sfax', 'Sfax', 3, NULL, 'Imm. Salima Medical Rte Gremda Imm. Salima Medical Etg 1 N14', '98411165', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Chokri Teka', 1, 'Monastir', 'Teboulba', 3, NULL, '5080 Avenue Habib Bourguiba', '22748369', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lilia Trigui Ben Jemaa', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3002 Imm. le Prestige Etg 1 Rte el Ain Km 1, 5 Imm. le Prestige Etg 1', '26613413', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amine Ben Othman', 1, 'Nabeul', 'Hammamet', 3, 'Centre Médical Al Iyada Avenue Habib Bourguiba', '8050 Centre Médical Al Iyada Avenue Habib Bourguiba', '29330060', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Manel Ben Hamada Larnaout', 1, 'Nabeul', 'Kelibia', 3, NULL, '8090 Avenue des Martyrs Immeuble Ben Massaoud 1er Étage', '98658193', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hanen Mnasri', 1, 'Gafsa', 'Gafsa Sud', 3, 'Centre Médical Tlili', '2100 Centre Médical Tlili, Rue Houcine Bouzaiene', '97891116', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sarra Ben Jemaa Sabbahi', 1, 'Ariana', 'Raoued', 3, NULL, '2083 Taksim 211, Rue Fatma Ezzahra 1er Étage', '94910794', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Iheb Haffani', 1, 'Tunis', 'Le Bardo', 3, NULL, '2000 Bardo Center Bloc 3- 5ème Étage App.19 Bardo Tunis', '98408664', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hocine Azzi', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2058 Résidence el Amen Bloc A 1er Étage App.a1-1 Avenue Ibn Khaldoun', '98323518', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mounir Loukil', 1, 'Sfax', 'Sakiet Ezzit', 3, NULL, '3021 Avenue Mongi Slim Imm. Amen 1 Sakiet Ezzit', '98410771', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Aymen Labassi', 1, 'Ben Arous', 'Ariana Ville', 3, NULL, '2080 Centre Kouki 01 Avenue Ahmed Khefacha 1er Étage Apprt N5', '98938792', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abderrahmen Barbouche', 1, 'Nabeul', 'Nabeul', 3, NULL, '8000 29, Rue de France', '98345476', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ibtissem Hafsa Tanboura', 1, 'Tunis', 'Tunis', 3, NULL, '38, Rue Mohamed Kassar Cité des Juges', '98304065', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mourad Bouraoui', 1, 'Tunis', 'Tunis', 3, NULL, '7, Avenue Habib Thameur Imm. B 2ème Étage App B3', '98312509', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Charfeddine Atallah', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2080 19, Avenue 18 Janvier 1956 Imm. Amen Center Entrée A 3ème Étage Bureau A 3-2', '98323963', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ayoub Kamoun', 1, 'Tunis', 'El Menzah', 3, NULL, '2092 5, Avenue Tahar Ben Ammar', '98306412', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Moez Ben Amara', 1, 'Tunis', 'Mnihla', 3, NULL, '2094 Résidence el Mahrajène 2ème Étage App.a22 Jardins d''El Menzah 2', '29141464', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Dhiaeddine Chakroun', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 27, Rue 8 Janvier 1938', '98440124', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wiem Chaker-Maazoun', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3027 Avenue Ahmed Aloulou Imm. Razi Appt N° 1', '98415018', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mustapha Helaoui', 1, 'Bizerte', 'Ras Jebel', 3, NULL, '7070 Rue Salah Eddine el Ayoubi', '98440757', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Afif Jridi', 1, 'Tataouine', 'Tataouine Sud', 3, NULL, '3200 Rue Monastir, Immeuble Trab', '98813554', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Anis Ben Rhouma', 1, 'Nabeul', 'Beni Khalled', 3, NULL, '8021 Immeuble Harguem 2ème Étage Bureau 207 Avenue Habib Bourguiba', '98676491', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. MoÊZ Hassairi', 1, 'Ariana', 'La Marsa', 3, NULL, '2070 01 Bis, Rue Omar el Khayem- l''Entresol Cabinet.a7', '98922281', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Moncef Ksontini', 1, 'Nabeul', 'Nabeul', 3, NULL, '31, Rue Marbella', '98308795', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Raouf Hmila', 1, 'Ben Arous', 'Ben Arous', 3, NULL, 'Avenue des Martyrs Imm. Snit Bloc A 8', '98308445', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nabil Djeribi', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Rte Gremda Imm. Ribat el Medina Etage 1 N° 103 3027 Sfax', '98609253', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed NÉJib Kanoun', 1, 'Tunis', 'Tunis', 3, NULL, '44, Avenue Habib Bourguiba 1er Étage', '98308003', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. HÉDi Miladi', 1, 'Tunis', 'Mannouba', 3, NULL, '2011 12, Rue de Kairouan', '98335633', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ali Debbabi', 1, 'Tunis', 'Cité El Khadra', 2, 'Clinique Ettaoufik', '1002 Clinique Ettaoufik', '98305604', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Aymen Ben Salah', 1, 'Mahdia', 'Souassi', 3, NULL, '5140 Avenue de l''Environnement', '98350767', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Salma Hachicha Bouthour', 1, 'Tunis', 'Tunis', 3, 'Centre Médical Omar 1er Étage App N°2- Avenue Khaled Ibn el Walid', 'Centre Médical Omar 1er Étage App N°2- Avenue Khaled Ibn el Walid', '98923140', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Monia Joulak Yatougi', 1, 'Ariana', 'Ettahrir', 3, NULL, '2042 Route de Bizerte Résidence Echerifa Bloc B- 1er Étage App 5', '98337277', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nafissa Zroud', 1, 'Mahdia', 'La Chebba', 3, NULL, '5170 33, Rue Hedi Chaker Route de Sfax', '23083492', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. ChÉRif Bakhti', 1, 'Tunis', 'Le Bardo', 3, NULL, '2000 Avenue Habib Bourguiba', '98315710', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Houda Foughali Ben Jazia', 1, 'Ben Arous', 'Ben Arous', 3, NULL, 'Place de la République', '97333869', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wafa Ziadi', 1, 'Tunis', 'Tunis', 3, NULL, 'Rue Khaled Ibn el Walid Résidence Riadh Soukra Imm. Folla App 13 Aïn Zaghouan', '98348184', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Houda Arjoun Ep Hammami', 1, 'Tunis', 'El Kram', 3, NULL, '2015 Immeuble Ibn Jazzar, 2éme Étage Avenue Habib Bourguiba', '98318135', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Saloua Azek Mezigh', 1, 'Tunis', 'Tunis', 3, NULL, 'Résidence Jardins d''El Mourouj Angle Avenue des Martyrs et Avenue Habib Thameur Bloc B 2ème Étage App.10', '98339772', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Salem Sahli', 1, 'Nabeul', 'Hammamet', 3, NULL, '8050 19, Rue des Jasmins', '98319977', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Kamel Baklouti', 1, 'Sfax', 'Jebeniana', 3, NULL, '3080 Av. Habib Bourguiba Rue el Ward Imm. Ben Abdallah Etage 1 N° A1 Jbeniana', '27360445', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Dahmane', 1, 'Zaghouan', 'Zaghouan', 3, NULL, '1100 05, Avenue Habib Bourguiba Imm. Samir Ben Nsir App.6', '98947888', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Soufia Helioui', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 Résidence les Émeraudes 2ème Étage Bloc C App.7 Avenue de l''Ere Nouvelle', '98314661', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Malek Chaabouni', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Avenue Hédi Nouira Imm. la Corone 7ème Étage 3027 Sfax', '98414994', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Alae Amri', 1, 'Tunis', 'La Marsa', 3, NULL, 'Centre Olivia Médical, 2eme Étage, Cabinet N°8, Rue Cheikh Mohamed Enneifer, Cité les Palmeraies, L''Aouina', '94839195', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jihene Jaber', 1, 'Gabès', 'Gabes Medina', 3, NULL, '6000 Avenue Mongi Slim - Complexe Oumayma', '98483597', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Zakia Habboul', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 Avenue Touhemi Negra Cabinets el Hakim', '22747665', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ramzi Ben Belhassen', 1, 'Kébili', 'Kebili Sud', 3, NULL, '4200 Immeuble les Palmiers Rue Jamel Eddine el Afghani', '97336070', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Ayedi', 1, 'Tunis', 'Mohamadia', 3, NULL, '1145 Immeuble Zarai Appt N°3 Avenue de la Liberté', '22745743', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mouna Bousnina Trabelsi', 1, 'Sousse', 'Hammam Sousse', 3, NULL, '4011 23, Route de Tunis Imm. Ernez', '98404544', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khaireddine Bouchahoua', 1, 'Tunis', 'Tebourba', 3, NULL, '1130 Rue 1er Juin 1955', '98245126', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Karima Chouchene', 1, 'Mahdia', 'El Jem', 3, NULL, '5160 Rue Sidi Bouhlel', '99891406', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sarra Lafi', 1, 'Médenine', 'Ben Guerdane', 3, NULL, '4160 Complexe Médical el Farabi - 1er Étage - App N°5', '54022113', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mongi Ben Hariz', 1, 'Tunis', 'La Marsa', 3, NULL, '2070 - la Marsa Khayem Médical 3ème Étage Bureau E.1 12, Rue Omar el Kayem', '98325680', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Said Ramadhane', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2080 73, Avenue Habib Bourguiba', '98305622', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nadia Ben Fredj', 1, 'Gabès', 'Gabes Sud', 3, NULL, '6022 N°84 Avenue Habib Bourguiba au Dessus Magasin Aziza - 1er Étage - Bureau N°4', '97903343', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mouna Chiha Cherif', 1, 'Nabeul', 'Nabeul', 3, NULL, '8000 Résidence Malek 6ème Étage Bureau N°b.602 Avenue Habib Thameur', '20351298', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nahla Lengliz Lamine', 1, 'Nabeul', 'Nabeul', 3, NULL, '20, Avenue Ibn Khaldoun', '98331376', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Miled Ben Dali', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 87, Bis Avenue de la République', '98400923', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nancie Lampin Tarkani', 1, 'Jendouba', 'Jendouba', 3, NULL, '8100 Rue Habib Thameur', '98446262', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Noomen Ellouze', 1, 'Sfax', 'Sfax', 3, NULL, 'Route Gremda Km 1.5 Immeuble Salima Medicale 2ème Étage N°24', '98530210', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ali Fredj', 1, 'Kasserine', 'Kasserine Nord', 3, NULL, '1200 15 Rue 18 Janvier', '98648572', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ahmed Ourari', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 Immeuble Karoui 3ème Étage App.3b- 41 Avenue d''Algérie', '29832655', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Saoussen Mrad', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2080 10, Avenue Habib Bourguiba Imm.zephyr 2ème Étage App.b2-1', '98370264', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jalel Khelif', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 98, Av.abi Zamaa el Balaoui', '98634203', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samia Boussetta', 1, 'Mahdia', 'Ksour Essaf', 3, NULL, '5180 Imm. Essalem Rue Palastine', '98977762', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sana Abdennassir', 1, 'Tunis', 'Le Bardo', 3, NULL, '2000 Avenue Habib Bourguiba 2ème Étage', '97184353', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Meriem Darghouth', 1, 'Tunis', 'La Marsa', 3, 'Centre Médical 1bis Rue Omar el Khayem Cabinet A7', '2078 Centre Médical 1bis Rue Omar el Khayem Cabinet A7', '52278278', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Ridha Hayder', 1, 'Tunis', 'La Marsa', 3, NULL, '2070 Rue Abdelaziz Chtioui', '71775941', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Leila Ghrairi Abdellatif', 1, 'Ben Arous', 'Bou Mhel El Bassatine', 3, NULL, '2097 Avenue de l''Environnement Résidence Nozha App.3', '98951341', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Haythem Chiha', 1, 'Bizerte', 'Menzel Bourguiba', 3, NULL, '7050 Centre Habiba 2ème Étage Cabinet N°10 Rue Mongi Slim', '55428608', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Kalthoum Kazdaghli Ben Hamouda', 1, 'Tunis', 'Megrine', 3, NULL, '2033 Tunis Sud Medical Center 3ème Étage Bureau N° 301 Gp1 Route de Sousse Km 6', '20927242', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Adel Hichri', 1, 'Bizerte', 'Menzel Bourguiba', 3, NULL, '7050 Centre Eya 1er Étage Avenue de l''Indépendance', '98446599', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Salah Maaroufi', 1, 'Jendouba', 'Jendouba', 3, NULL, '8100 Rue Hammamet', '98318898', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samir Doghri', 1, 'Tunis', 'El Mourouj', 3, NULL, '2074 Avenue Habib Thameur Immeuble Snit', '98343060', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Bouhala Chaabani', 1, 'Gafsa', 'Gafsa Sud', 3, NULL, '2143 Avenue Ibn el Jazzar', '98608181', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Haykel Hadj Ali', 1, 'Kasserine', 'Sbeitla', 3, NULL, '1250 Avenue Ali Balhouane', '20509161', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jezia Telmoudi', 1, 'Tozeur', 'Tozeur', 3, NULL, '2200 Immeuble Khdhiri 2 Ème Étage Bureau N°4 Route de Nefta', '95933889', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wissem Frikha-Chaari', 1, 'Sfax', 'Sfax', 3, NULL, 'Rte de Tunis Km 2, 5 Immeuble Dar Ettabib', '98656100', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Adel Debbiche', 1, 'Ben Arous', 'Megrine', 3, 'Centre Médical Ibn Rochd 2éme Étage Cabinet N° B2-4 02 Rue 1er Juin', '2033 Centre Médical Ibn Rochd 2éme Étage Cabinet N° B2-4 02 Rue 1er Juin', '98308037', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mongi Mosbahi', 1, 'Sousse', 'Enfidha', 3, NULL, '4030 Avenue de la République', '98400732', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. InÈS Tilouch Abouda', 1, 'Mahdia', 'Ksour Essaf', 3, NULL, '5180 Rue Ahmed Tlili', '97128909', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Zeineb Bacha Jenhani', 1, 'Nabeul', 'Kelibia', 3, NULL, '8090 Avenue Ali Belhouane', '98601766', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdelkrim Brini', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2080 5, Avenue Taieb m''Hiri Imm. Ridha', '98316433', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Kamel Monastiri', 1, 'Sousse', 'Sousse Jaouhara', 3, NULL, '4051 Imm. le Relais Rue Perle du Sahel', '27007725', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rahma Cherni', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2080 el Wardy Médical 2ème Étage Cabinet N°4 78, Avenue Habib Bourguiba', '54263477', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Dhouha Riahi Ep Chikhaoui', 1, 'Ben Arous', 'Fouchana', 3, NULL, '1135 Résidence Ajmel Kouroum 1er Étage App.a03 Rue 14 Janvier', '52558661', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Khecharem', 1, 'Tunis', 'La Marsa', 3, NULL, '1053 Centre Lago Rdc 40, Rue Lac Leman les Berges du Lac', '98435005', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amor Mechri', 1, 'Tunis', 'Tunis', 3, NULL, 'Rue Fadhel Ben Achour', '73632400', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdelhamid Kodia', 1, 'Ben Arous', 'Mornaguia', 3, NULL, '1110 Avenue de l''Environnement', '98641471', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khaled Bacha', 1, 'Béja', 'Beja Nord', 3, NULL, '9000 Rue Hassen Ibn Noomen', '98676119', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mounir Abida', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 117, Avenue Habib Bourguiba', '98441666', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lasmar Dahmani', 1, 'Monastir', 'Ksar Helal', 3, NULL, '5070 Avenue Habib Bourguiba', '98407790', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samia Kolsi', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3027 Av. des Martyrs Imm. Palmarium B Etg 2 Appt N° 24 Sfax Av. des Martyrs Imm. Palmarium B Etg 2 Appt N° 24', '97899617', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Maher Haffani', 1, 'Tunis', 'El Menzah', 3, NULL, '1082 Atlas Médical 1er Étage Cabinet N°13 Rue Aziza Othmana', '22305562', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Chahnez Khouadja Mokrani', 1, 'Tunis', 'Cité El Khadra', 3, 'Centre Médical les Jasmins 6ème Étage C.6-5', '1003 Centre Médical les Jasmins 6ème Étage C.6-5', '98337290', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Slim El Mabrouk', 1, 'Tunis', 'Tunis', 3, NULL, '43, Avenue Habib Bourguiba Rdc', '98313219', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Naouel Hedhli Fezzani', 1, 'Bizerte', 'Mateur', 3, NULL, '7030 Rue d''Alger 1er Étage', '97778791', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imene Amamou', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2080 Immeuble Tej 1er Étage App.b1-1 Avenue Mohamed Lahjaiej', '98353870', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lotfi Charfeddine', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 Rue Mouaouia Ibn Houdaije Hajjem', '96511444', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Abid', 1, 'Sfax', 'Sfax', 2, 'Polyclinique el Alya Sfax', 'Route el Ain Km 2 Polyclinique el Alya Sfax', '21650096', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ikram Ayed', 1, 'Monastir', 'Monastir', 3, NULL, '5011 Avenue de la République Route Bembla', '97486926', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Dalel Ben Hassine', 1, 'Bizerte', 'El Alia', 3, NULL, '7016 Avenue Habib Bourguiba', '26720220', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Samir Bellazreg', 1, 'Monastir', 'Moknine', 3, NULL, '5050 50, Avenue de la République', '98406559', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. BÉChir Lazzem', 1, 'Tunis', 'Tunis', 3, NULL, '10, Rue Bahri Ben Sassi', '98440025', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hasna Bel Hadj Hamouda Zakhama', 1, 'Tunis', 'Tunis', 3, NULL, 'Rue Bechir Sfar Immeuble Snit', '98530530', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Gastli', 1, 'Nabeul', 'Nabeul', 3, NULL, '8000 3, Avenue Habib Thameur', '98346522', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Seifeddine Karoui', 1, 'Tunis', 'Rades', 3, NULL, '2040 3, Avenue A.farhat', '98436346', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mourad Sarbeji', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Rte Gremda Imm. el Majd Etg 1 Appt N°3 3027 Sfax', '98414322', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sameh Chaieb Ben Amor', 1, 'Ariana', 'Ariana', 3, NULL, 'Rue de l''Environnement', '97594407', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Moncef Baccar', 1, 'Tunis', 'El Ouerdia', 3, NULL, '1009 9 Bis, Rue N.béranger', NULL, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jouline Remy Hajji', 1, 'Bizerte', 'Bizerte', 3, NULL, '94, Rue d''Espagne', NULL, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdulrazak Al Sabah', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 22, Rue 8 Janvier 38', NULL, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ahlem Ayat', 1, 'Mahdia', 'La Chebba', 3, NULL, '5170 Immeuble Fatima Avenue el Hedi Chaker', '98631347', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Assaad Louati', 1, 'Tunis', 'La Marsa', 3, NULL, '1053 Complexe Vital Cube Cabinet S1-1 Rue Tasmanie les Berges du Lac 2', '52886727', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mourad Bouden', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 Avenue de la Bosnie Résidence el Amel', '98323170', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Chefia Ben Zayed', 1, 'Kairouan', 'Bou Hajla', 3, NULL, '3180 Complexe Médical Echifa Lotissement Ouled Souidène', '99365917', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fadhila Ben Amor Hachani', 1, 'Gabès', 'Gabes Medina', 3, NULL, '6000 Avenue Mohamed Ali Imm. el Bachraoui, Étage 3, Bureau N°8', '97195347', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khalil Messaoui', 1, 'Gafsa', 'Metlaoui', 3, NULL, '2130 Cité des Jeunes Métlaoui Gafsa', '26132565', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Kais Mhiri', 1, 'Sousse', 'Hammam Sousse', 3, NULL, '4011 Immeuble Forum de Buraux Route de Tunis el Menchia', '99488081', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mustapha Zaafouri', 1, 'Ariana', 'Mnihla', 3, NULL, '2094 Rue Zaafarane Jardin d''El Menzah 2', '98303101', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Olfa El Gasmi', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Avenue 15 Octobre Souk el Ahad Complexe Dorra', '98639695', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nebhani Tlili', 1, 'Kasserine', 'Kasserine Nord', 3, NULL, '1200 Avenue de la Revolution du 14 Janavier el Douleb Imm. Missaoui Étage 1', '98367888', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Moez Adouani', 1, 'Médenine', 'Medenine Sud', 3, NULL, '4100 Complexe Médical el Bacha - Route de Tataouine Km 1', '97633821', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hichem Kamoun', 1, 'Sfax', 'Sfax', 3, NULL, 'Route Gremda Km 3.5 Immeuble Mmc 2ème Étage N°a29 Sfax', '21778565', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Najoua Meddeb Gandoura', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 Centre Pasteur 2ème Rue Taher Sfar', '98601376', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ameur Badr', 1, 'Sousse', 'Hammam Sousse', 3, NULL, '4011 Route de Tunis el Menchia', '98400596', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Latifa Bouguerra Mongalgi', 1, 'Tunis', 'El Menzah', 3, NULL, '2092 Résidence les Jasmins Bloc B Rdc App.b4 2092 el Manar I- Tunis', '21422069', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nora Kitouni Laajailia', 1, 'Jendouba', 'Ghardimaou', 3, NULL, '8160 Rue 1er Juin 1955 Ghardimaou', '21554036', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Amel Hamila', 1, 'Sousse', 'Sousse Ville', 3, 'Centre Médicale les Oliviers Boulevard 14 Janvier', '4000 Centre Médicale les Oliviers Boulevard 14 Janvier', '52880089', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ameni Khlifi', 1, 'Sousse', 'Sousse', 3, NULL, 'Rue Mohamed Bouazizi Imm. Zaitouna 3ème Étage N°4', '26432042', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Najoua Missaoui Amri', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Avenue Mohamed el Karoui Immeuble Al Jawhara', '97373720', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. FayÇAl Oubich', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2091 - el Menzah Vi Cité Jamil Escalier B 2ème Niveau', '98424256', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Afef Touati', 1, 'Manouba', 'Oued Ellil', 3, 'Centre Médical Oued Ellil 2ème Étage Cabinet N°2 Avenue 14 Janvier', '2021 Centre Médical Oued Ellil 2ème Étage Cabinet N°2 Avenue 14 Janvier', '94884989', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Monia Saidani', 1, 'Manouba', 'Sidi Hassine', 3, NULL, '1095 Rue 42800 1er Étage App.01 Route el Attar', '21200696', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imen Ayadi', 1, 'Ariana', 'Cité El Khadra', 3, NULL, '1003 Immeuble Coral Bloc A 7ème Étage Cabinet N° A7-5 Avenue Zohra Faiza', '98270630', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rafika El Fahem-Taamallah', 1, 'Sidi Bouzid', 'Maknassy', 1, 'Hôpital de Circonscription Meknessy', 'Av. Habib Bourguiba Imm. Amami Slah 9140 Meknessy Sidi Bouzid Hôpital de Circonscription Meknessy', '97352702', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Souad Ghanoudi Slim', 1, 'Médenine', 'Zarzis', 3, NULL, '4170 Route Médenine - Zarzis', '98305361', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdelaziz Harbi', 1, 'Sousse', 'Sousse', 3, NULL, 'Avenue Mohamed el Karoui', '52471248', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lamia Sebai Dhaoui', 1, 'Ariana', 'La Marsa', 3, NULL, '2070 Espace Saâda 15, Rue 9 Avril 1938', '98303656', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Yosra Sdiri', 1, 'Nabeul', 'Soliman', 3, NULL, '8020 Ayadi Centre 1er Étage Bureau A4 Avenue d''Egypte Erriadh', '58012437', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Habib Selmi', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Immobilière Médicale Bd 7 Novembre', '97222329', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Moncef Boulares', 1, 'Le Kef', 'Le Kef Est', 3, NULL, '7100 Rue 8 Juillet 1884', '98447031', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Dhaher Dhahri', 1, 'Sidi Bouzid', 'Sidi Bouzid Est', 3, NULL, '9171 Imm. Slim Centre Rue Hbib Bourguiba Imm. Slim Centre Etg 3 N°304', '55279948', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lamia Chabchoub Krichen', 1, 'Tunis', 'Tunis', 3, NULL, 'Immeuble Omrane 10 Cité el Ahd el Jadid Bloc E 1er Étage App.2', '97980001', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abdellatif Ben Jeddou', 1, 'Ben Arous', 'El Mourouj', 3, NULL, '2074 Avenue des Martys Centre Somïi 2ème Étage', '98333262', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hedia Ayache Zouaghi', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Place du Maghreb Arabe Immobiliere Médicale Essalem', '99733979', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Alaeddine Bouani', 1, 'Jendouba', 'Jendouba', 3, 'Centre Médical Ennakhil', '8100 Avenue Habib Bourguiba Centre Médical Ennakhil', '97047634', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jouhaina El Mahmoudi', 1, 'Tozeur', 'Tozeur', 1, 'Hôpital Régional', '2200 14, Rue de l''Hôpital Régional', '21694048', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Belgacem Gharsallaoui', 1, 'Kairouan', 'Cherarda', 3, NULL, '3116 sur la Gp2 en Face de la Municipalite Bouhajla', '98306086', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. FÉRid Hachfi Soussi', 1, 'Béja', 'Mejez El Bab', 3, NULL, '9070 Rue Ibn Battouta Cité Ferdaous Medjez el Bab', '98444035', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed NÉJi Guediche', 1, 'Monastir', 'Monastir', 3, NULL, '5000 Immeuble Bouzguarrou Place du Savoir', '98255739', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Tahar Sfar', 1, 'Mahdia', 'Mahdia', 3, NULL, '5100 Immeuble Chelaifa Avenue 2 Mars 1934', '98408311', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mounir Aloui', 1, 'Gabès', 'Gabes Medina', 3, NULL, '6000 Avenue Taieb m''Hiri Immeuble Dar Ettabib Bureau N° 1', '98421245', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Monia Troudi', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 Rue Ibn el Aghleb', '98236420', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Izdihar Ammar', 1, 'Sfax', 'Kerkenah', 3, NULL, '3070 Ouled Bou Ali', '98624606', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mounir Mallek', 1, 'Sfax', 'Sfax Ville', 3, NULL, 'Av. la Liberte 14 Jan Imm. Aida Esc. A App.404 3002 Sfax', '98410443', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Manoubi', 1, 'Nabeul', 'Beni Khalled', 3, NULL, '8021 Rue Mohamed Harrassi', '98244887', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rafla Tage Dellagi', 1, 'Tunis', 'La Marsa', 3, NULL, '2070 Résidence Riyadh Avenue Hédi Chaker Bloc d N°6', '98345348', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Wajdi Jarraya', 1, 'Sfax', 'Sfax', 3, 'Centre Médical el Bassatine Etg 4 N°43 Sfax', 'Centre Médical el Bassatine Etg 4 N°43 Sfax', '53987630', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jilani Takrouni', 1, 'Nabeul', 'Nabeul', 3, NULL, 'Immeuble Yazidi Rue Ali Chouk Route Korba', '21309072', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Bochra Laarouchi Bejaoui', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 Immeuble Business Center Bloc A 2ème Étage App.202 Avenue Hassen Ennouri', '98631101', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jihene Saloua Ben Zahra Trad', 1, 'Manouba', 'Oued Ellil', 3, NULL, '2021 68, Avenue Hassen Belkhoudja Cité Ennajet', '98349034', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Zaki Hidouri', 1, 'Gafsa', 'Gafsa Sud', 3, NULL, '2100 Complexe Médical Avicenne 3ème Étage', '97727240', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fredj Hassine', 1, 'Sousse', 'Sousse Riadh', 3, NULL, '4023 Avenue Ettaoufik Cité Riadh Immeuble Sehili', '98261353', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Raoudha Fourati Boussoffara', 1, 'Mahdia', 'Mahdia', 3, NULL, '5100 Route Touristique Résidence Errahma', '50908148', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Sameh Ayari Abadi', 1, 'Sousse', 'Msaken', 3, NULL, '4070 Boulevard de 7 Novembre Immeuble Zoubaier Baya', '98585833', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fethi Amri', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 98, Avenue Abou Zomaa Balaoui', '98451483', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fatma El Kilani', 1, 'Ben Arous', 'Ben Arous', 3, NULL, 'Avenue Mongi Slim 1er Étage Sabalet Mornag', '23572621', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Dhouha Zouari Ep Frad', 1, 'Sousse', 'Kalaa El Kebira', 3, NULL, '4060 Rue 1er Juin Immeuble Borj Khalifa', '53851072', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abderrahman Hmidi', 1, 'Gafsa', 'Gafsa Sud', 3, 'Centre Médicale Echifa Houcine Bouzaiene', '2100 Centre Médicale Echifa Houcine Bouzaiene', '58879177', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nesrine Ncibi Zaafouri', 1, 'Sidi Bouzid', 'Sidi Bouzid Ouest', 3, NULL, 'Imm. Baklouti en Face de Mosquee Errahma 2 Eme Etage Sidi Bouzid 9100 Sidi Bouzid', '98926200', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Hichem Sellami', 1, 'Jendouba', 'Tabarka', 3, NULL, '8110 Rue d''Alger Tabarka', '98598309', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Anis Allagui', 1, 'Nabeul', 'Nabeul', 3, NULL, '8000 Complexe Essalama Avenue Habib Thameur 5ème Étage Bureau N°503', '52639393', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Amine Tilouche', 1, 'Mahdia', 'Bou Merdes', 3, NULL, '5110 Avenue Ibrahim el Hadj Mohamed', '99431363', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mouna Askri Wali', 1, 'Zaghouan', 'Zaghouan', 3, NULL, '1100 Immeuble Ennesrine Rdc App.4 Avenue de l''Indépendance', '98611865', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Zeineb Ellafi', 1, 'Ariana', 'Megrine', 3, 'Centre Médical Infinity Health And Skin 2ème Étage Cabinet C4 -81', '2033 Centre Médical Infinity Health And Skin 2ème Étage Cabinet C4 -81', '97931704', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ezzeddine Chouaibi', 1, 'Sidi Bouzid', 'Sidi Bouzid Ouest', 3, NULL, '9100 Avenue la Poste Imm. el Hana Etg 1 N°13 Sidi Bouzid', '98814466', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Zied Boujemaa', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 Hippo Center 153, Avenue Habib Bourguiba Bloc A 2ème Étage N°5', '93906555', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Latifa Hedfi Chehima', 1, 'Ariana', 'Ariana Ville', 3, NULL, '2037 Ennasr Médical 3ème Étage App.2- 50, Avenue de l''Ere Nouvelle', '98306911', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lamia Gharsallah Guelmami', 1, 'Ariana', 'Mnihla', 3, NULL, '2094 Résidence Kordoba Mezzanine A7jardins d''El Menzah Ii', '28690469', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Abderrazek Ben Tkhayat', 1, 'Médenine', 'Houmet Essouk', 3, NULL, '4180 Complexe Médical Ibn Zohr - N°4 Avenue Salah Ben Youssef', '75651802', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Azza El Gharbi Samoud', 1, 'Manouba', 'Mnihla', 3, NULL, '2094 Résidence Didon 2ème Étage App.08 Jardin d''El Menzah Ariana', '98331154', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Walid Maammer', 1, 'Manouba', 'Mannouba', 3, NULL, '2010 Alyssa Médical Avenue du Grand Maghreb Arabe Drc Cabinet N°1', '22929669', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nesrine Omri Nouma', 1, 'Médenine', 'Medenine Sud', 3, NULL, '4100 Complexe Médical Ibn Nafiss - 2ème Étage Bureau N°9 - Route de Tataouine', '27970388', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mongi Ben Ammar', 1, 'Ariana', 'El Menzah', 3, NULL, '2092 42, Avenue Mohieddine Klibi', '98308103', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Imen Bennour', 1, 'Tunis', 'Mannouba', 3, 'Centre Médical Folla Rue 4366 Croisement Oued Gueriana', '2010 Centre Médical Folla Rue 4366 Croisement Oued Gueriana', '52448556', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Afif Besbes', 1, 'Monastir', 'Monastir', 3, NULL, '5000 Intersection de Rue de Martyrs et Rte de Kairouan', '98406489', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Leila Nefzi Chalghoumi', 1, 'Bizerte', 'Menzel Bourguiba', 3, NULL, '7050 Centre Marmara 2ème Étage Appartement N°4', '20700593', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. HÉDi Ben Ameur', 1, 'Sfax', 'Mahras', 3, NULL, '3060 Av. des Martyrs Complexe Médical Mahres 1er Étage N°107', '94360300', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Khadija Bel Hadj Ali Guayneychya', 1, 'Tunis', 'Ariana Ville', 3, NULL, '2037 Passage Tadjikistan', '98945910', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Habib Kharrat', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 Rue Mahmoud Abdellah', '94641040', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Fatma Loulou Mhiri', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3000 Av. la Liberte 14 Jan Rue Ahmed Aloulou Imm. Ibn Sina Etg 1 Apt N°15 Sfax Av. la Liberte 14 Jan Rue Ahmed Aloulou Imm.', '98656543', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ahmed Ben Mansour', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3000 Av.h.b Imm. Intilaka 2 Esc d Mezanine 6', '98656142', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Moncef Ben Jemaa', 1, 'Ben Arous', 'El Mourouj', 3, NULL, '2074 - el Mourouj I Résidence Jnène Bloc el Fel 2', '98330890', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lassaad Oualha', 1, 'Sfax', 'Sfax', 3, NULL, 'Rte Lafrane Km 4, 5 Markaz Jallouli A Cote de l''Ecole Jallouli Sfax Rte Lafrane Km 4, 5 Markaz Jallouli A Cote de l''Ecole', '21433252', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Jalleleddine Ben Ghozzia', 1, 'Tunis', 'Carthage', 3, NULL, '2026 76, Rue Slaheddine Bouchoucha Rdc', '98323713', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jamel Ben Mansour', 1, 'Nabeul', 'Nabeul', 3, NULL, 'Rue Mohamed Bach Hamba Imm. Mrabeh', '98329320', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Lilia Messai', 1, 'Bizerte', 'Bizerte Nord', 3, NULL, '7000 Business Center Hassen Ennouri', '98469388', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mhamed Borhan Victor Jlizi', 1, 'Tunis', 'Tunis', 3, NULL, 'Sephir Médical 26, Rue Aziza Othmana Rdc Cabinet N°3', '21422464', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Alia Ben Jemaa', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3000 Rte el Ain Km 2, 5 el Pole Medical Etg 2 App 2-2 Sfax', '23575648', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Tarek Khemis', 1, 'Sidi Bouzid', 'Sidi Bouzid Ouest', 3, NULL, '9100 Cite el Wouroud Imm. Ezzouhour E2 Etg 3 Sidi Bouzid', '53825043', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Afif Zouari', 1, 'Mahdia', 'Mahdia', 3, NULL, '5100 Complexe Médical Ghada Avenue Taieb Mhiri', '98408980', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Radhouane Attia', 1, 'Sousse', 'Sousse Ville', 3, NULL, '4000 Immeuble el Wifek Place du Maghreb Arabe', '73212599', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Imed Baizig', 1, 'Nabeul', 'Menzel Temime', 3, NULL, '8080 Rue Zhioua', '98313442', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Radhouane Abid', 1, 'Gabès', 'Gabes Medina', 3, NULL, '6000 Avenue Taieb m''Hiri Dar Tabib Gabès Bloc B N°2', '98420013', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Nadia Guellouz Najjar', 1, 'Tunis', 'La Marsa', 3, NULL, '1053 Complexe Vita Cube Rue Tasmanie Cabinet V2-2', '96087860', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Noamen Lakhal', 1, 'Sousse', 'Sousse', 3, NULL, 'Sousse', '98403156', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Brahim El Ghali', 1, 'Kairouan', 'Kairouan Sud', 3, NULL, '3100 Kairouan', '97220355', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Boubtane', 1, 'Médenine', 'Zarzis', 3, NULL, '4170 Imm. el Khalij Bloc ''B'' - 1er Etage - App N°7 Route de Médenine', '98212400', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Adel Zouari', 1, 'Sfax', 'Sfax', 3, NULL, 'Sfax', '98410501', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Med Ridha Fourati', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3000 26 Rue Dag-Hammarchold 3000 Sfax', '23430150', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Ahlem Ouachani Halloumi', 1, 'Médenine', 'Midoun', 3, NULL, '4175 Place Cité des Oliviers - el May', '98600915', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Elyas Lassoued', 1, 'Ariana', 'La Marsa', 3, 'Centre Médical la Rose Résidence 25', '1053 Centre Médical la Rose Résidence 25', '99874220', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Mizouni Ghodbani', 1, 'Kasserine', 'Sbeitla', 3, NULL, '1250 Taieb m''Hiri', '77471989', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Rihab Ben Othman', 1, 'Ben Arous', 'El Mourouj', 3, NULL, '2074 Complexe Médical Mayar Avenue des Martyrs 2ème Étage Cabinet B7 el Mourouj 3', '24691188', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Habiba El Memmi Tilouche', 1, 'Monastir', 'Ksar Helal', 3, NULL, '5070 Immeuble Mansour Mama, Place de l''Indépendance', '21594436', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Yahia Hammami', 1, 'Sfax', 'Sfax Ville', 3, NULL, '3027 Rte Gremda Rue Carthage Imm. Ribat el Madina Bloc B Appt 413', '98656083', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Besma Seket Monastiri', 1, 'Médenine', 'Médenine', 3, NULL, '11, Rue Manfalouti Cité Ezzahra', '97595737', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Jaafar El Mabrouk', 1, 'Monastir', 'Ksar Helal', 3, NULL, '5070 Rue Eddoustour el Jadid Imm.mahmoud el Hammami', NULL, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
  UNION ALL
  SELECT 'Dr. Mohamed Salah Jellali', 1, 'Sidi Bouzid', 'Sidi Bouzid', 3, NULL, 'Sidi Bouzid', NULL, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
) AS src
WHERE NOT EXISTS (
  SELECT 1 FROM medecins m
  WHERE m.fullname COLLATE utf8mb4_unicode_ci = src.fullname COLLATE utf8mb4_unicode_ci
    AND IFNULL(m.tel, '') COLLATE utf8mb4_unicode_ci = IFNULL(src.tel, '') COLLATE utf8mb4_unicode_ci
);
