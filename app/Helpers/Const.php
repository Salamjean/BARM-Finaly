<?php

const DEVICE = ' FCFA';

const GENDERS = ['Feminin', 'Masculin'];

const DEPARTURE_CONDITIONS = [
    // 'Fin de contrat',
    'Départ volontaire',
    'Démission',
    'Limite d\'age',
    'Réforme',
    // 'Radiation',
];

const FINANCIAL_CONDITIONS = [
    [
        'id' => 'pecule',
        'value' => 'Pécule',
    ],
    [
        'id' => 'perm',
        'value' => 'Plan épagne retraite mutualiste (PERM)',
    ],
    [
        'id' => 'pension_retraite',
        'value' => 'Pension retraite',
    ],
    [
        'id' => 'pension_reforme',
        'value' => 'Pension de réforme',
    ],
    [
        'id' => 'solde_reforme',
        'value' => 'Solde de réforme',
    ],
    [
        'id' => 'remboursement',
        'value' => 'Remboursement retenue',
    ],
    [
        'id' => 'epargne',
        'value' => 'Epargne personnelle',
    ],
    [
        'id' => 'assurance',
        'value' => 'Assurance-retaite personnelle',
    ],
];

const GRADES_MILITARY = [
        'Soldat 2e classe',
        'Soldat 1ère classe',
        'Caporal',
        'Caporal-Chef',
        'Sergent',
        'Sergent-Chef',
        'Adjudant',
        'Adjudant-Chef',
        'Adjudant-Chef Major',
        'Lieutenant',
        'Capitaine',
        'Commandant',
        'Lieutenant-Colonel',
        'Colonel',
        'Colonel-Major',
        'Général de Brigade',
        'Général de Division',
        'Général de Corps d\'Armée',
        'Général d\'Armée'
];

const GRADES = [
    'military' => [
        'Soldat 2e Classe',
        'Soldat 1e Classe',
        'Caporal',
        'Caporal Chef',
        'Sergent',
        'Sergent Chef',
        'Adjudant',
        'Adjudant Chef',
        'Adjudant Chef Major',
        'Aspirant',
        'Sous Lieutenant',
        'Lieutenant',
        'Capitaine',
        'Commandant',
        'Lieutenant Colonel',
        'Colonel',
        'Colonel Major',
        'Général de brigade',
        'Général de division',
        'Général de corps d’armée',
    ],
    'other' => [
        'D1',
        'C1',
        'C2',
        'B1',
        'B2',
        'B3',
        'A3',
        'A4',
        'A5',
        'A6',
        'A7',
    ]
];

const ROLES = [
    'CELLULE FORMATION ET INSERTION',
    'CELLULE SUIVI-EVALUATION',
];

const GADGETS_DISTRIBUTIONS = [
    'CELLULE FORMATION ET INSERTION',
    'CELLULE SUIVI-EVALUATION',
];

const CHIEFS = [
    'CHEF CELLULE FORMATION ET INSERTION',
    'CHEF CELLULE SUIVI-EVALUATION',
];

const BLOODGROUPS = [
    'A-',
    'A+',
    'B+',
    'B+',
    'AB+',
    'AB+',
    'O+',
    'O+',
];


// !PERMISSION POINT FOCAL
const POINTFOCAL = [
    'ADMIN',
    'CHEF BARM',
    'CANDIDAT',
    'PARTNER FINANCIAL',
    'PARTNER EMPLOYMENT',
    'PARTNER TECHNICAL',
    'GESTIONNAIRE DES RESSOURCES HUMAINES',
    'ASSISTANT CHEF BARM',
    'SECRETAIRE CHEF BARM',
    'RESPONSABLE COURRIER ET ARCHIVES',
    'SPECIALISTE PASSATION DE MARCHES',
    'ASSISTANT EN PASSATION DE MARCHES',
    'RESPONSABLE DES MOYENS GENERAUX',
    'RESPONSABLE COMMUNICATION',
    'CONDUCTEUR COURSIER',
];


// USERS ROELS AND PERMISSIONS
const TYPEUSER =  [
    [
        'name' => 'PARTNER',
        'permissions' => [
            'PARTNER FINANCIAL',
            // 'PARTNER EMPLOYMENT',
            'PARTNER TECHNICAL',
        ],
    ],
    [
        'name' => 'PERSONALS',
        'roles' => [
            [
                'name' => 'CHEF BARM',
                'permissions' => [
                    'CHEF BARM'
                ],
            ],

            [
                'name' => 'POINTS FOCAUX',
                'permissions' => [
                    'POINT FOCAL',
                ],
            ],

            [
                'name' => 'CELLULE FORMATION ET INSERTION',
                'permissions' => [
                    'CHEF CELLULE FORMATION ET INSERTION',
                    'CONSEILLER AUTO EMPLOI',
                    'CONSEILLER ENTREPRISE PRIVE',
                    'CONSEILLER FONCTION PUBLIC',
                    // 'CONSEILLER EN RECONVERSION',
                ],
            ],
            [
                'name' => 'CELLULE SUIVI-EVALUATION',
                'permissions' => [
                    'CHEF CELULLE SUIVI-EVALUATION',
                    'RESPONSABLE DES SYSTEMES DE L’INFORMATION',
                    'RESPONSABLE SUIVI-EVALUATION',
                    'ASSISTANT SUIVI-EVALUATION',
                ],
            ],
            [
                'name' => 'MINISTERE DE LA DÉFENSE',
                'permissions' => [
                    'C2D',
                    'MEMDEF',
                ],
            ],
            // [
            //     'name' => 'CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
            //     'permissions' => [
            //         'RESPONSABLE GESTIONNAIRE DES RESSOURCES HUMAINES',
            //     ],
            // ],
            // [
            //     'name' => 'CABINET CHEF BARM',
            //     'permissions' => [
            //         'RESPONSABLE DES MOYENS GENERAUX',
            //         'RESPONSABLE COMMUNICATION',
            //     ],
            // ],
        ],
    ],
];

const FOCAL_POINT = [
    'Abengourou',
    'Abidjan',
    'Bouaké',
    'Daloa',
    'Korhogo',
    'Man',
    'San-Pédro',
];


// PERSONALS BARM ROLES AND PERMISSIONS
const PERSONALS = [
    [
        'user' => [
            'firstname' => 'AKE-DANHO',
            'lastname' => 'STEPHANE ERIC',
            'username' => 'COLONEL AKE-DANHO STEPHANE ERIC',
            'email' => 'stephaneerica@yahoo.fr',
            'phone' => '0759514588',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-09-20',
            'matricule_barm' => 'AE-001CB19',
            'grade' => 'Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CHEF BARM',
        'post' => ['CHEF BARM'],
    ],
    [
        'user' => [
            'firstname' => 'KOFFI',
            'lastname' => 'CHARLES',
            'username' => 'ADJUDANT-CHEF KOFFI CHARLES',
            'email' => 'charlesberlin121@gmail.com',
            'phone' => '0759534062',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1969-06-29',
            'matricule_barm' => 'KC-023PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ], [
        'user' => [
            'firstname' => 'EDOUKOU',
            'lastname' => 'HONORE',
            'username' => 'M. EDOUKOU HONORE ',
            'email' => 'hedoukou05@gmail.com',
            'phone' => '0707511232',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1966-03-18',
            'matricule_barm' => 'EH-028PF20',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'ANOH',
            'lastname' => 'PIERRE',
            'username' => 'ADJUDANT-CHEF ANOH PIERRE',
            'email' => 'anohpierre70@gmail.com',
            'phone' => '0103476391',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1970-12-30',
            'matricule_barm' => 'AP-018PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abengourou'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'TANOH',
            'lastname' => 'KAMENAN JOACHIM',
            'username' => 'M. TANOH KAMENAN JOACHIM ',
            'email' => '',
            'phone' => '0102798715',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1968-12-31',
            'matricule_barm' => 'TJ-011PF20',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'N’DRIN',
            'lastname' => 'BANDAMAN ELIE',
            'username' => 'LIEUTENANT-COLONEL N’DRIN BANDAMAN ELIE',
            'email' => 'chrisnouveau1@gmail.com',
            'phone' => '0707703897',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1974-10-12',
            'matricule_barm' => 'WA-014PF20',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'WONAL',
            'lastname' => 'ADOUABO MIESSAN AIME',
            'username' => 'M.WONAL ADOUABO MIESSAN AIME ',
            'email' => 'wonaladouabo@gmail.com',
            'phone' => '0140098122',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1969-01-12',
            'matricule_barm' => 'WA-010CB20',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Daloa'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'KANHON',
            'lastname' => 'MONTEOMO AYMARD BRICE',
            'username' => 'LIEUTENANT-COLONEL KANHON MONTEOMO AYMARD BRICE',
            'email' => 'bricekanhon@gmail.com',
            'phone' => '0554004516',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1981-01-06',
            'matricule_barm' => 'KB-016PF20',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Daloa'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'GNEKPATO',
            'lastname' => 'DIDIER GERVAIS',
            'username' => 'ADJUDANT-CHEF GNEKPATO DIDIER GERVAIS',
            'email' => 'gnekpatodg@gmail.com',
            'phone' => '0101249798',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1976-01-23',
            'matricule_barm' => 'GG-020PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Man'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'FOFANA',
            'lastname' => 'SIRITIEHOUIN',
            'username' => 'LIEUTENANT-COLONEL FOFANA SIRITIEHOUIN',
            'email' => 'siritiehouinfofana@gmail.com',
            'phone' => '0707983392',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1969-01-15',
            'matricule_barm' => 'FS-015PF20',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Korhogo'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'KOFFI',
            'lastname' => 'KOUAME MESMIN',
            'username' => 'ADJUDANT-CHEF KOFFI KOUAME MESMIN',
            'email' => 'mesmino1@gmail.com',
            'phone' => '0101009717',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1974-04-18',
            'matricule_barm' => 'KM-022PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Korhogo'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'ASSI',
            'lastname' => 'ALLAH APOLINAIRE',
            'username' => 'ADJUDANT-CHEF ASSI ALLAH APOLINAIRE',
            'email' => 'assiallah@gmail.com',
            'phone' => '0102470800',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1983-06-21',
            'matricule_barm' => 'AA-021PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'San-Pédro'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],


    [
        'user' => [
            'firstname' => 'GOURI',
            'lastname' => 'VANIE JEAN-CHRISTIAN',
            'username' => 'LIEUTENANT-COLONEL GOURI VANIE JEAN-CHRISTIAN',
            'email' => 'jchristian.gouri@yahoo.fr',
            'phone' => '0709056906',
        ],
        'partner' => [
            'birth_date' => '1977-09-08',
            'gender' => GENDERS[1],
            'matricule_barm' => 'GC-009CI19',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['CHEF CELLULE FORMATION ET INSERTION']
    ],
    [
        'user' => [
            'firstname' => 'KOUAO',
            'lastname' => 'MONNET FESTOS',
            'username' => 'M.KOUAO MONNET FESTOS',
            'email' => 'festosmonnet@gmail.com',
            'phone' => '0504423153',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1985-12-05',
            'matricule_barm' => 'KF-004PR19',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => [
            'CONSEILLER AUTO EMPLOI',
            'CONSEILLER ENTREPRISE PRIVE',
            'CONSEILLER FONCTION PUBLIC',
        ],
    ],
    [
        'user' => [
            'firstname' => 'AHORE',
            'lastname' => 'AKAFFOU N’GUESSAN ROSAIRE AIMEE BERTILLE',
            'username' => 'MLLE AHORE AKAFFOU N’GUESSAN ROSAIRE AIMEE BERTILLE',
            'email' => 'ahore.rosaire@gmail.com',
            'phone' => '0777532852',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1975-09-20',
            'matricule_barm' => 'AH-030CR22',
            'grade' => 'B3',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['CONSEILLER FONCTION PUBLIC'],
    ],
    [
        'user' => [
            'firstname' => 'GBETIBOUO',
            'lastname' => 'ABRAHAM',
            'username' => 'M. GBETIBOUO ABRAHAM',
            'email' => 'gbetibouo.2014@gmail.com',
            'phone' => '0747709955',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1985-07-15',
            'matricule_barm' => 'GA-032CR23',
            'grade' => 'A4',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['CONSEILLER ENTREPRISE PRIVE'],
    ],
    [
        'user' => [
            'firstname' => 'DOSSO',
            'lastname' => 'NANNAN',
            'username' => 'MLLE. DOSSO NANNAN',
            'email' => 'dossonannan@gmail.com',
            'phone' => '0747170465',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1983-09-19',
            'matricule_barm' => 'DO-034CR23',
            'grade' => 'A3',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['CONSEILLER FONCTION PUBLIC'],
    ],
    [
        'user' => [
            'firstname' => 'KOUADIO',
            'lastname' => 'N’CHO HERMANN',
            'username' => 'LIEUTENANT-COLONEL KOUADIO N’CHO HERMANN',
            'email' => 'he.kouadio@defense.gouv.ci',
            'phone' => '0140519899',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-09-20',
            'matricule_barm' => 'KH-02RI19',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE SUIVI-EVALUATION',
        'post' => ['RESPONSABLE DES SYSTEMES DE L’INFORMATION']
    ],
    [
        'user' => [
            'firstname' => 'KOUASSI',
            'lastname' => 'N’GUESSAN',
            'username' => 'M. KOUASSI N’GUESSAN',
            'email' => 'coyssy.yssan@gmail.com',
            'phone' => '0505545723',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-12-30',
            'matricule_barm' => 'KN-025SE21',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE SUIVI-EVALUATION',
        'post' => ['RESPONSABLE SUIVI-EVALUATION']
    ],
    [
        'user' => [
            'firstname' => 'YAO',
            'lastname' => 'EPSE YAPI AKOUA TAMIA RITA EMILIENNE',
            'username' => 'MME.YAO EPSE YAPI AKOUA TAMIA RITA EMILIENNE',
            'email' => '',
            'phone' => '0789086985',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1981-12-30',
            'matricule_barm' => 'YY-027AE22',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE SUIVI-EVALUATION',
        'post' => ['ASSISTANT SUIVI-EVALUATION']
    ],
    [
        'user' => [
            'firstname' => 'DIABATE',
            'lastname' => 'OUMAROU',
            'username' => 'M. DIABATE OUMAROU',
            'email' => 'diabatealfarouck@gmail.com',
            'phone' => '0708180593',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1985-12-31',
            'matricule_barm' => 'DO-031RH23',
            'grade' => 'A3',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
        'post' => ['RESPONSABLE GESTIONNAIRE DES RESSOURCES HUMAINES', 'RESPONSABLE DES MOYENS GENERAUX']
    ],
];

const MONTHS = [
    "Janvier",
    "Février",
    "Mars",
    "Avril",
    "Mai",
    "Juin",
    "Juillet",
    "Aout",
    "Septembre",
    "Octobre",
    "Novembre",
    "Décembre",
];

const CIBLES = [
    "Bailleurs",
    "Etat",
    "Futurs candidats",
    "Grand public",
    "Journalistes",
    "Militaires retraités",
    "Partenaires",
];

const CANAUX = [
    "Presse ecrite",
    "Radio",
    "Réseaux sociaux",
    "Tv",
    "Web",
];

const YEARS = [
    "2018",
    "2019",
    "2020",
    "2021",
    "2022",
    "2023",
    "2024",
    "2025",
    "2026",
    "2027",
    "2028",
    "2029",
    "2030",
];

//PERSONAL NO POINTING
const NO_POINTING = ['chef-barm', 'point focal',];

const JOBTYPE = ['Temps plein', 'Temps partiel', 'Travail de journée'];

const TYPEPIECES = ['CNI', 'PASSEPORT', 'CMU', 'Carte de rétraite militaire', 'Attestation d\'identité', 'Permis de conduire'];

const JOBS = [
    'Agriculteur',
    'Agent administratif',
    'Agent d\'accueil',
    'Agent de facturation',
    'Agent de gestion des stocks',
    'Agent de logistique',
    'Agent de planification',
    'Agent de recouvrement',
    'Agent de saisie de données',
    'Agent des ressources humaines',
    'Archiviste',
    'Artisan potier',
    'Boulanger',
    'Boucher',
    'Chauffeur',
    'Charpentier',
    'Coiffeur/barbier',
    'Comptable',
    'Commercial(e)',
    'Conducteur de rickshaw',
    'Cordonnier',
    'Couturier',
    'Directeur(rice) Général(e)',
    'Cuisinier',
    'Cuisinier',
    'Eboueur',
    'Electricien',
    'Eleveur de volailles',
    'Employé de maison',
    "Fermier",
    "Forgeron",
    "Garde de sécurité",
    "Gérant de cybercafé",
    "Gérant de petit commerce",
    "Guide touristique",
    "Infirmier/infirmière",
    "Livreur",
    "Jardinier",
    "Maçon",
    "Marchand ambulant",
    "Mécanicien",
    "Mécanicien de moto",
    "Menuisier",
    "Nourrice",
    "Planteur de cacao/café",
    "Plombier",
    "Pompiste",
    "Ramasseur de déchets recyclables",
    "Réparateur de téléphones mobiles",
    "Réparateur de vélos",
    "Secrétaire administratif",
    "Secrétaire médicale",
    "Tailleur",
    "Teinturier",
    "Vendeur",
    "Autre",
];

const RELIGIONS = [
    'Animisme',
    'Bouddhisme',
    'Christianisme',
    'Indouisme',
    'Islam',
    'Judaïsme',
    'Khémitisme',
    'Sans réligion',
];

const ETHNICS = [
    "Abbey",
    'Abidji',
    "Abouré",
    "Abron",
    "Adioukrou",
    "Agni",
    "Ahizi",
    "Aïzi",
    "Akan",
    "Akouè",
    "Alladian",
    "Ano",
    "Aowin",
    "Attié",
    "Avikam",
    "Ayahou",

    "Bakwé",
    "Bambara",
    "Bamo",
    "Baoulé",
    "Beng",
    "Bété",
    "Birifor",
    "Bisa ",

    "Dagari",
    "Dakua",
    "Dan",
    "Dida",
    "Dikpi",
    "Djimini",
    "Dogbogwie",
    "Dri",

    "Ébriés",
    "Ehotilé",
    "Elomoué",

    "Gagou",
    "Gbadi",
    "Gbloh",
    "Godié",
    "Gotibo",
    "Gouin",
    "Gouro",
    "Grebo",
    "Guébié",
    "Guéré",

    "Karaboro",
    "Kono ",
    "Kotrohou",
    "Koulango",
    "Koyaka",
    "Krahn",
    "Kriwa",
    "Krobo",
    "Krou",

    "Ligbi",
    "Lobi",
    "Lossom",

    "M'Batto",
    "Mahous",
    "Malinké",
    "Mandés",
    "Mangoro",
    "Minianka",
    "Mona",

    "N'gban",
    "Nafana",

    "Nanafouè",
    "Néyo",
    "Niabré",
    "Niarafolo",
    "Nogogo",
    "Nyabwa",
    "Nzema",

    "Oualébo",

    "Paccolo",
    "Peul",

    "Sah",
    "Satiklan",
    "Sénoufo",
    "Sobô",

    "Tagbana",
    "Toura",

    "Wan",
    "Wassa",
    "Wés",
    "Wobé",

    "Yacouba",
    "Yaouré",
    "Yocolo",
    "Yoruba",

    "Zabia",
    "Zédi",
    "Zikobouo",
    "Zuglo"
];

const CITIES = [
    "Abengourou",
    "Abidjan",
    "Aboisso",
    "Adiaké",
    "Adzopé",
    "Agboville",
    "Aguégués",
    "Akouédo",
    "Alépé",
    "Bangolo",
    "Béoumi",
    "Biankouma",
    "Bingerville",
    "Bloléquin",
    "Bondoukou",
    "Bongouanou",
    "Bonon",
    "Bonoua",
    "Botro",
    "Bouaflé",
    "Bouaké",
    "Boundiali",
    "Dabakala",
    "Dabou",
    "Daloa",
    "Danané",
    "Daoukro",
    "Dimbokro",
    "Divo",
    "Duékoué",
    "Ferkessédougou",
    "Fresco",
    "Gagnoa",
    "Gbéléban",
    "Gboguhé",
    "Gohitafla",
    "Grand-Bassam",
    "Grand-Lahou",
    "Guéyo",
    "Guibéroua",
    "Guiglo",
    "Hiré",
    "Issia",
    "Jacqueville",
    "Kani",
    "Katiola",
    "Korhogo",
    "Kossihouen",
    "Kouto",
    "Lakota",
    "M'Bahiakro",
    "M'Batto",
    "M'Bengue",
    "M'Boré",
    "M'Pody",
    "Madinani",
    "Mahapleu",
    "Man",
    "Marcory",
    "Mankono",
    "Méagui",
    "Minignan",
    "Nassian",
    "Niakaramandougou",
    "Odienné",
    "Ouangolodougou",
    "Ouellé",
    "Oumé",
    "Panziazou",
    "Port-Bouët",
    "Sakassou",
    "San-Pédro",
    "Sassandra",
    "Séguéla",
    "Sikensi",
    "Sinématiali",
    "Soubré",
    "Tabou",
    "Taï",
    "Tiassalé",
    "Tiébissou",
    "Tienko",
    "Touba",
    "Toulepleu",
    "Toumodi",
    "Vavoua",
    "Yako",
    "Yamoussoukro",
    "Zouan-Hounien",
    "Zoukougbeu"
];

const DISTRICTS = [
    "Abidjan",
    "Bas-Sassandra",
    "Comoé",
    "Denguélé",
    "Gôh-Djiboua",
    "Lacs",
    "Lagunes",
    "Montagnes",
    "Sassandra-Marahoué",
    "Savanes",
    "Vallée du Bandama",
    "Woroba",
    "Yamoussoukro",
    "Zanzan"
];


const COUNTRIES =  [
    ['countrie' => 'Afghanistan', 'prefix' => 'AF', 'indicatif' => '+93'],
    ['countrie' => 'Afrique du Sud', 'prefix' => 'ZA', 'indicatif' => '+27'],
    ['countrie' => 'Albanie', 'prefix' => 'AL', 'indicatif' => '+355'],
    ['countrie' => 'Algérie', 'prefix' => 'DZ', 'indicatif' => '+213'],
    ['countrie' => 'Allemagne', 'prefix' => 'DE', 'indicatif' => '+49'],
    ['countrie' => 'Andorre', 'prefix' => 'AD', 'indicatif' => '+376'],
    ['countrie' => 'Angola', 'prefix' => 'AO', 'indicatif' => '+244'],
    ['countrie' => 'Anguilla', 'prefix' => 'AI', 'indicatif' => '+1-264'],
    ['countrie' => 'Antigua-et-Barbuda', 'prefix' => 'AG', 'indicatif' => '+1-268'],
    ['countrie' => 'Antilles néerlandaises', 'prefix' => 'AN', 'indicatif' => '+599'],
    ['countrie' => 'Arabie saoudite', 'prefix' => 'SA', 'indicatif' => '+966'],
    ['countrie' => 'Argentine', 'prefix' => 'AR', 'indicatif' => '+54'],
    ['countrie' => 'Arménie', 'prefix' => 'AM', 'indicatif' => '+374'],
    ['countrie' => 'Aruba', 'prefix' => 'AW', 'indicatif' => '+297'],
    ['countrie' => 'Australie', 'prefix' => 'AU', 'indicatif' => '+61'],
    ['countrie' => 'Autriche', 'prefix' => 'AT', 'indicatif' => '+43'],
    ['countrie' => 'Azerbaïdjan', 'prefix' => 'AZ', 'indicatif' => '+994'],
    ['countrie' => 'Bahamas', 'prefix' => 'BS', 'indicatif' => '+1-242'],
    ['countrie' => 'Bahreïn', 'prefix' => 'BH', 'indicatif' => '+973'],
    ['countrie' => 'Bangladesh', 'prefix' => 'BD', 'indicatif' => '+880'],
    ['countrie' => 'Barbade', 'prefix' => 'BB', 'indicatif' => '+1-246'],
    ['countrie' => 'Belgique', 'prefix' => 'BE', 'indicatif' => '+32'],
    ['countrie' => 'Belize', 'prefix' => 'BZ', 'indicatif' => '+501'],
    ['countrie' => 'Bénin', 'prefix' => 'BJ', 'indicatif' => '+229'],
    ['countrie' => 'Bermudes', 'prefix' => 'BM', 'indicatif' => '+1-441'],
    ['countrie' => 'Bhoutan', 'prefix' => 'BT', 'indicatif' => '+975'],
    ['countrie' => 'Biélorussie', 'prefix' => 'BY', 'indicatif' => '+375'],
    ['countrie' => 'Bolivie', 'prefix' => 'BO', 'indicatif' => '+591'],
    ['countrie' => 'Bosnie-Herzégovine', 'prefix' => 'BA', 'indicatif' => '+387'],
    ['countrie' => 'Botswana', 'prefix' => 'BW', 'indicatif' => '+267'],
    ['countrie' => 'Brésil', 'prefix' => 'BR', 'indicatif' => '+55'],
    ['countrie' => 'Brunéi Darussalam', 'prefix' => 'BN', 'indicatif' => '+673'],
    ['countrie' => 'Bulgarie', 'prefix' => 'BG', 'indicatif' => '+359'],
    ['countrie' => 'Burkina Faso', 'prefix' => 'BF', 'indicatif' => '+226'],
    ['countrie' => 'Burundi', 'prefix' => 'BI', 'indicatif' => '+257'],
    ['countrie' => 'Cambodge', 'prefix' => 'KH', 'indicatif' => '+855'],
    ['countrie' => 'Cameroun', 'prefix' => 'CM', 'indicatif' => '+237'],
    ['countrie' => 'Canada', 'prefix' => 'CA', 'indicatif' => '+1'],
    ['countrie' => 'Cap-Vert', 'prefix' => 'CV', 'indicatif' => '+238'],
    ['countrie' => 'Chili', 'prefix' => 'CL', 'indicatif' => '+56'],
    ['countrie' => 'Chine', 'prefix' => 'CN', 'indicatif' => '+86'],
    ['countrie' => 'Chypre', 'prefix' => 'CY', 'indicatif' => '+357'],
    ['countrie' => 'Colombie', 'prefix' => 'CO', 'indicatif' => '+57'],
    ['countrie' => 'Comores', 'prefix' => 'KM', 'indicatif' => '+269'],
    ['countrie' => 'Congo-Brazzaville', 'prefix' => 'CG', 'indicatif' => '+242'],
    ['countrie' => 'Congo-Kinshasa', 'prefix' => 'CD', 'indicatif' => '+243'],
    ['countrie' => 'Corée du Nord', 'prefix' => 'KP', 'indicatif' => '+850'],
    ['countrie' => 'Corée du Sud', 'prefix' => 'KR', 'indicatif' => '+82'],
    ['countrie' => 'Costa Rica', 'prefix' => 'CR', 'indicatif' => '+506'],
    ['countrie' => 'Côte d\'Ivoire', 'prefix' => 'CI', 'indicatif' => '+225'],
    ['countrie' => 'Croatie', 'prefix' => 'HR', 'indicatif' => '+385'],
    ['countrie' => 'Cuba', 'prefix' => 'CU', 'indicatif' => '+53'],
    ['countrie' => 'Danemark', 'prefix' => 'DK', 'indicatif' => '+45'],
    ['countrie' => 'Djibouti', 'prefix' => 'DJ', 'indicatif' => '+253'],
    ['countrie' => 'Dominique', 'prefix' => 'DM', 'indicatif' => '+1-767'],
    ['countrie' => 'Égypte', 'prefix' => 'EG', 'indicatif' => '+20'],
    ['countrie' => 'Émirats arabes unis', 'prefix' => 'AE', 'indicatif' => '+971'],
    ['countrie' => 'Équateur', 'prefix' => 'EC', 'indicatif' => '+593'],
    ['countrie' => 'Érythrée', 'prefix' => 'ER', 'indicatif' => '+291'],
    ['countrie' => 'Espagne', 'prefix' => 'ES', 'indicatif' => '+34'],
    ['countrie' => 'Estonie', 'prefix' => 'EE', 'indicatif' => '+372'],
    ['countrie' => 'États fédérés de Micronésie', 'prefix' => 'FM', 'indicatif' => '+691'],
    ['countrie' => 'États-Unis', 'prefix' => 'US', 'indicatif' => '+1'],
    ['countrie' => 'Éthiopie', 'prefix' => 'ET', 'indicatif' => '+251'],
    ['countrie' => 'Fidji', 'prefix' => 'FJ', 'indicatif' => '+679'],
    ['countrie' => 'Finlande', 'prefix' => 'FI', 'indicatif' => '+358'],
    ['countrie' => 'France', 'prefix' => 'FR', 'indicatif' => '+33'],
    ['countrie' => 'Gabon', 'prefix' => 'GA', 'indicatif' => '+241'],
    ['countrie' => 'Gambie', 'prefix' => 'GM', 'indicatif' => '+220'],
    ['countrie' => 'Géorgie', 'prefix' => 'GE', 'indicatif' => '+995'],
    ['countrie' => 'Ghana', 'prefix' => 'GH', 'indicatif' => '+233'],
    ['countrie' => 'Gibraltar', 'prefix' => 'GI', 'indicatif' => '+350'],
    ['countrie' => 'Grèce', 'prefix' => 'GR', 'indicatif' => '+30'],
    ['countrie' => 'Grenade', 'prefix' => 'GD', 'indicatif' => '+1-473'],
    ['countrie' => 'Groenland', 'prefix' => 'GL', 'indicatif' => '+299'],
    ['countrie' => 'Guadeloupe', 'prefix' => 'GP', 'indicatif' => '+590'],
    ['countrie' => 'Guam', 'prefix' => 'GU', 'indicatif' => '+1-671'],
    ['countrie' => 'Guatemala', 'prefix' => 'GT', 'indicatif' => '+502'],
    ['countrie' => 'Guinée', 'prefix' => 'GN', 'indicatif' => '+224'],
    ['countrie' => 'Guinée équatoriale', 'prefix' => 'GQ', 'indicatif' => '+240'],
    ['countrie' => 'Guinée-Bissau', 'prefix' => 'GW', 'indicatif' => '+245'],
    ['countrie' => 'Guyana', 'prefix' => 'GY', 'indicatif' => '+592'],
    ['countrie' => 'Haïti', 'prefix' => 'HT', 'indicatif' => '+509'],
    ['countrie' => 'Honduras', 'prefix' => 'HN', 'indicatif' => '+504'],
    ['countrie' => 'Hong Kong', 'prefix' => 'HK', 'indicatif' => '+852'],
    ['countrie' => 'Hongrie', 'prefix' => 'HU', 'indicatif' => '+36'],
    ['countrie' => 'Île Christmas', 'prefix' => 'CX', 'indicatif' => '+61'],
    ['countrie' => 'Île Norfolk', 'prefix' => 'NF', 'indicatif' => '+672'],
    ['countrie' => 'Îles Caïmans', 'prefix' => 'KY', 'indicatif' => '+1-345'],
    ['countrie' => 'Îles Cocos (Keeling)', 'prefix' => 'CC', 'indicatif' => '+61'],
    ['countrie' => 'Îles Cook', 'prefix' => 'CK', 'indicatif' => '+682'],
    ['countrie' => 'Îles Féroé', 'prefix' => 'FO', 'indicatif' => '+298'],
    ['countrie' => 'Îles Malouines', 'prefix' => 'FK', 'indicatif' => '+500'],
    ['countrie' => 'Îles Mariannes du Nord', 'prefix' => 'MP', 'indicatif' => '+1-670'],
    ['countrie' => 'Îles Marshall', 'prefix' => 'MH', 'indicatif' => '+692'],
    ['countrie' => 'Îles Pitcairn', 'prefix' => 'PN', 'indicatif' => '+64'],
    ['countrie' => 'Îles Salomon', 'prefix' => 'SB', 'indicatif' => '+677'],
    ['countrie' => 'Îles Turks et Caïques', 'prefix' => 'TC', 'indicatif' => '+1-649'],
    ['countrie' => 'Îles Vierges britanniques', 'prefix' => 'VG', 'indicatif' => '+1-284'],
    ['countrie' => 'Îles Vierges des États-Unis', 'prefix' => 'VI', 'indicatif' => '+1-340'],
    ['countrie' => 'Inde', 'prefix' => 'IN', 'indicatif' => '+91'],
    ['countrie' => 'Indonésie', 'prefix' => 'ID', 'indicatif' => '+62'],
    ['countrie' => 'Irak', 'prefix' => 'IQ', 'indicatif' => '+964'],
    ['countrie' => 'Iran', 'prefix' => 'IR', 'indicatif' => '+98'],
    ['countrie' => 'Irlande', 'prefix' => 'IE', 'indicatif' => '+353'],
    ['countrie' => 'Islande', 'prefix' => 'IS', 'indicatif' => '+354'],
    ['countrie' => 'Israël', 'prefix' => 'IL', 'indicatif' => '+972'],
    ['countrie' => 'Italie', 'prefix' => 'IT', 'indicatif' => '+39'],
    ['countrie' => 'Jamaïque', 'prefix' => 'JM', 'indicatif' => '+1-876'],
    ['countrie' => 'Japon', 'prefix' => 'JP', 'indicatif' => '+81'],
    ['countrie' => 'Jordanie', 'prefix' => 'JO', 'indicatif' => '+962'],
    ['countrie' => 'Kazakhstan', 'prefix' => 'KZ', 'indicatif' => '+7'],
    ['countrie' => 'Kenya', 'prefix' => 'KE', 'indicatif' => '+254'],
    ['countrie' => 'Kirghizistan', 'prefix' => 'KG', 'indicatif' => '+996'],
    ['countrie' => 'Kiribati', 'prefix' => 'KI', 'indicatif' => '+686'],
    ['countrie' => 'Koweït', 'prefix' => 'KW', 'indicatif' => '+965'],
    ['countrie' => 'La Réunion', 'prefix' => 'RE', 'indicatif' => '+262'],
    ['countrie' => 'Laos', 'prefix' => 'LA', 'indicatif' => '+856'],
    ['countrie' => 'Lesotho', 'prefix' => 'LS', 'indicatif' => '+266'],
    ['countrie' => 'Lettonie', 'prefix' => 'LV', 'indicatif' => '+371'],
    ['countrie' => 'Liban', 'prefix' => 'LB', 'indicatif' => '+961'],
    ['countrie' => 'Libéria', 'prefix' => 'LR', 'indicatif' => '+231'],
    ['countrie' => 'Libye', 'prefix' => 'LY', 'indicatif' => '+218'],
    ['countrie' => 'Liechtenstein', 'prefix' => 'LI', 'indicatif' => '+423'],
    ['countrie' => 'Lituanie', 'prefix' => 'LT', 'indicatif' => '+370'],
    ['countrie' => 'Luxembourg', 'prefix' => 'LU', 'indicatif' => '+352'],
    ['countrie' => 'Macédoine', 'prefix' => 'MK', 'indicatif' => '+389'],
    ['countrie' => 'Madagascar', 'prefix' => 'MG', 'indicatif' => '+261'],
    ['countrie' => 'Malaisie', 'prefix' => 'MY', 'indicatif' => '+60'],
    ['countrie' => 'Malawi', 'prefix' => 'MW', 'indicatif' => '+265'],
    ['countrie' => 'Maldives', 'prefix' => 'MV', 'indicatif' => '+960'],
    ['countrie' => 'Mali', 'prefix' => 'ML', 'indicatif' => '+223'],
    ['countrie' => 'Malte', 'prefix' => 'MT', 'indicatif' => '+356'],
    ['countrie' => 'Maroc', 'prefix' => 'MA', 'indicatif' => '+212'],
    ['countrie' => 'Martinique', 'prefix' => 'MQ', 'indicatif' => '+596'],
    ['countrie' => 'Maurice', 'prefix' => 'MU', 'indicatif' => '+230'],
    ['countrie' => 'Mauritanie', 'prefix' => 'MR', 'indicatif' => '+222'],
    ['countrie' => 'Mayotte', 'prefix' => 'YT', 'indicatif' => '+262'],
    ['countrie' => 'Mexique', 'prefix' => 'MX', 'indicatif' => '+52'],
    ['countrie' => 'Moldavie', 'prefix' => 'MD', 'indicatif' => '+373'],
    ['countrie' => 'Monaco', 'prefix' => 'MC', 'indicatif' => '+377'],
    ['countrie' => 'Mongolie', 'prefix' => 'MN', 'indicatif' => '+976'],
    ['countrie' => 'Montserrat', 'prefix' => 'MS', 'indicatif' => '+1-664'],
    ['countrie' => 'Mozambique', 'prefix' => 'MZ', 'indicatif' => '+258'],
    ['countrie' => 'Myanmar', 'prefix' => 'MM', 'indicatif' => '+95'],
    ['countrie' => 'Namibie', 'prefix' => 'NA', 'indicatif' => '+264'],
    ['countrie' => 'Nauru', 'prefix' => 'NR', 'indicatif' => '+674'],
    ['countrie' => 'Népal', 'prefix' => 'NP', 'indicatif' => '+977'],
    ['countrie' => 'Nicaragua', 'prefix' => 'NI', 'indicatif' => '+505'],
    ['countrie' => 'Niger', 'prefix' => 'NE', 'indicatif' => '+227'],
    ['countrie' => 'Nigeria', 'prefix' => 'NG', 'indicatif' => '+234'],
    ['countrie' => 'Niue', 'prefix' => 'NU', 'indicatif' => '+683'],
    ['countrie' => 'Norvège', 'prefix' => 'NO', 'indicatif' => '+47'],
    ['countrie' => 'Nouvelle-Calédonie', 'prefix' => 'NC', 'indicatif' => '+687'],
    ['countrie' => 'Nouvelle-Zélande', 'prefix' => 'NZ', 'indicatif' => '+64'],
    ['countrie' => 'Oman', 'prefix' => 'OM', 'indicatif' => '+968'],
    ['countrie' => 'Ouganda', 'prefix' => 'UG', 'indicatif' => '+256'],
    ['countrie' => 'Ouzbékistan', 'prefix' => 'UZ', 'indicatif' => '+998'],
    ['countrie' => 'Pakistan', 'prefix' => 'PK', 'indicatif' => '+92'],
    ['countrie' => 'Palaos', 'prefix' => 'PW', 'indicatif' => '+680'],
    ['countrie' => 'Panama', 'prefix' => 'PA', 'indicatif' => '+507'],
    ['countrie' => 'Papouasie-Nouvelle-Guinée', 'prefix' => 'PG', 'indicatif' => '+675'],
    ['countrie' => 'Paraguay', 'prefix' => 'PY', 'indicatif' => '+595'],
    ['countrie' => 'Pays-Bas', 'prefix' => 'NL', 'indicatif' => '+31'],
    ['countrie' => 'Pérou', 'prefix' => 'PE', 'indicatif' => '+51'],
    ['countrie' => 'Philippines', 'prefix' => 'PH', 'indicatif' => '+63'],
    ['countrie' => 'Pologne', 'prefix' => 'PL', 'indicatif' => '+48'],
    ['countrie' => 'Polynésie française', 'prefix' => 'PF', 'indicatif' => '+689'],
    ['countrie' => 'Porto Rico', 'prefix' => 'PR', 'indicatif' => '+1-787'],
    ['countrie' => 'Portugal', 'prefix' => 'PT', 'indicatif' => '+351'],
    ['countrie' => 'Qatar', 'prefix' => 'QA', 'indicatif' => '+974'],
    ['countrie' => 'République centrafricaine', 'prefix' => 'CF', 'indicatif' => '+236'],
    ['countrie' => 'République dominicaine', 'prefix' => 'DO', 'indicatif' => '+1-809'],
    ['countrie' => 'République tchèque', 'prefix' => 'CZ', 'indicatif' => '+420'],
    ['countrie' => 'Roumanie', 'prefix' => 'RO', 'indicatif' => '+40'],
    ['countrie' => 'Royaume-Uni', 'prefix' => 'GB', 'indicatif' => '+44'],
    ['countrie' => 'Russie', 'prefix' => 'RU', 'indicatif' => '+7'],
    ['countrie' => 'Rwanda', 'prefix' => 'RW', 'indicatif' => '+250'],
    ['countrie' => 'Saint-Christophe-et-Niévès', 'prefix' => 'KN', 'indicatif' => '+1-869'],
    ['countrie' => 'Saint-Marin', 'prefix' => 'SM', 'indicatif' => '+378'],
    ['countrie' => 'Saint-Pierre-et-Miquelon', 'prefix' => 'PM', 'indicatif' => '+508'],
    ['countrie' => 'Saint-Vincent-et-les Grenadines', 'prefix' => 'VC', 'indicatif' => '+1-784'],
    ['countrie' => 'Sainte-Hélène', 'prefix' => 'SH', 'indicatif' => '+290'],
    ['countrie' => 'Sainte-Lucie', 'prefix' => 'LC', 'indicatif' => '+1-758'],
    ['countrie' => 'Salvador', 'prefix' => 'SV', 'indicatif' => '+503'],
    ['countrie' => 'Samoa', 'prefix' => 'WS', 'indicatif' => '+685'],
    ['countrie' => 'Samoa américaines', 'prefix' => 'AS', 'indicatif' => '+1-684'],
    ['countrie' => 'Sao Tomé-et-Principe', 'prefix' => 'ST', 'indicatif' => '+239'],
    ['countrie' => 'Sénégal', 'prefix' => 'SN', 'indicatif' => '+221'],
    ['countrie' => 'Serbie-et-Monténégro', 'prefix' => 'CS', 'indicatif' => '+381'],
    ['countrie' => 'Seychelles', 'prefix' => 'SC', 'indicatif' => '+248'],
    ['countrie' => 'Sierra Leone', 'prefix' => 'SL', 'indicatif' => '+232'],
    ['countrie' => 'Singapour', 'prefix' => 'SG', 'indicatif' => '+65'],
    ['countrie' => 'Slovaquie', 'prefix' => 'SK', 'indicatif' => '+421'],
    ['countrie' => 'Slovénie', 'prefix' => 'SI', 'indicatif' => '+386'],
    ['countrie' => 'Somalie', 'prefix' => 'SO', 'indicatif' => '+252'],
    ['countrie' => 'Soudan', 'prefix' => 'SD', 'indicatif' => '+249'],
    ['countrie' => 'Sri Lanka', 'prefix' => 'LK', 'indicatif' => '+94'],
    ['countrie' => 'Suède', 'prefix' => 'SE', 'indicatif' => '+46'],
    ['countrie' => 'Suisse', 'prefix' => 'CH', 'indicatif' => '+41'],
    ['countrie' => 'Suriname', 'prefix' => 'SR', 'indicatif' => '+597'],
    ['countrie' => 'Swaziland', 'prefix' => 'SZ', 'indicatif' => '+268'],
    ['countrie' => 'Syrie', 'prefix' => 'SY', 'indicatif' => '+963'],
    ['countrie' => 'Tadjikistan', 'prefix' => 'TJ', 'indicatif' => '+992'],
    ['countrie' => 'Taïwan', 'prefix' => 'TW', 'indicatif' => '+886'],
    ['countrie' => 'Tanzanie', 'prefix' => 'TZ', 'indicatif' => '+255'],
    ['countrie' => 'Tchad', 'prefix' => 'TD', 'indicatif' => '+235'],
    ['countrie' => 'Thaïlande', 'prefix' => 'TH', 'indicatif' => '+66'],
    ['countrie' => 'Timor oriental', 'prefix' => 'TL', 'indicatif' => '+670'],
    ['countrie' => 'Togo', 'prefix' => 'TG', 'indicatif' => '+228'],
    ['countrie' => 'Tokelau', 'prefix' => 'TK', 'indicatif' => '+690'],
    ['countrie' => 'Tonga', 'prefix' => 'TO', 'indicatif' => '+676'],
    ['countrie' => 'Trinité-et-Tobago', 'prefix' => 'TT', 'indicatif' => '+1-868'],
    ['countrie' => 'Tunisie', 'prefix' => 'TN', 'indicatif' => '+216'],
    ['countrie' => 'Turkménistan', 'prefix' => 'TM', 'indicatif' => '+993'],
    ['countrie' => 'Turquie', 'prefix' => 'TR', 'indicatif' => '+90'],
    ['countrie' => 'Tuvalu', 'prefix' => 'TV', 'indicatif' => '+688'],
    ['countrie' => 'Ukraine', 'prefix' => 'UA', 'indicatif' => '+380'],
    ['countrie' => 'Uruguay', 'prefix' => 'UY', 'indicatif' => '+598'],
    ['countrie' => 'Vanuatu', 'prefix' => 'VU', 'indicatif' => '+678'],
    ['countrie' => 'Vatican', 'prefix' => 'VA', 'indicatif' => '+379'],
    ['countrie' => 'Venezuela', 'prefix' => 'VE', 'indicatif' => '+58'],
    ['countrie' => 'Viêt Nam', 'prefix' => 'VN', 'indicatif' => '+84'],
    ['countrie' => 'Wallis-et-Futuna', 'prefix' => 'WF', 'indicatif' => '+681'],
    ['countrie' => 'Yémen', 'prefix' => 'YE', 'indicatif' => '+967'],
    ['countrie' => 'Zambie', 'prefix' => 'ZM', 'indicatif' => '+260'],
    ['countrie' => 'Zimbabwe', 'prefix' => 'ZW', 'indicatif' => '+263'],
];

const LANGUAGES = [
    'fr' => [
        'français', 'anglais', 'espagnol', 'allemant', 'arabe',
    ],
    'en' => [
        'frensh', 'english', 'spanish', 'deutsch', 'arab',
    ],
];

const EDUCATIONS = [
    'BEPC', 'BT', 'BAC', 'BAC +1', 'BAC +2', 'DUT', 'BTS', 'BAC +3', 'Licence', 'BAC +4', 'BAC +5', 'Master', 'BAC +6', 'BAC +7', 'Doctorat'
];

const MESSAGES = [
    'job' => [
        'store' => "Offre enregistrée avec succès.",
        'update' => "Offre modifiée avec succès.",
        'delete' => "Offre supprimée avec succès.",
        'status' => "Statut modifiée avec succès.",
    ],
    'setting' => [
        'update' => "Paramètres du système modifiés avec succès.",
    ],
    'ad' => [
        'store' => "Actualité enregistrée avec succès.",
        'update' => "Actualité modifiée avec succès.",
        'delete' => "Actualité supprimée avec succès.",
        'status' => "Actualité modifiée avec succès.",
    ],
    'new' => [
        'store' => "Annonce enregistrée avec succès.",
        'update' => "Annonce modifiée avec succès.",
        'delete' => "Annonce supprimée avec succès.",
        'status' => "Annonce modifiée avec succès.",
    ],
    'team' => [
        'store' => "Membre enregistré avec succès.",
        'update' => "Membre modifié avec succès.",
        'delete' => "Membre supprimé avec succès.",
        'status' => "Membre modifié avec succès.",
        'chief' => "Utilisateur defini comme Directeur Générale.",
        'personal' => "Utilisateur defini comme membre.",
    ],
    'partner' => [
        'store' => "Partenaire enregistré avec succès.",
        'update' => "Partenaire modifié avec succès.",
        'delete' => "Partenaire supprimé avec succès.",
        'status' => "Partenaire modifié avec succès.",
    ],
    'cohort' => [
        'store' => "Cohorte enregistrée avec succès.",
        'update' => "Cohorte modifiée avec succès.",
        'delete' => "Cohorte supprimée avec succès.",
        'status' => "Cohorte modifiée avec succès.",
    ],
    'client' => [
        'store' => "Adhérent enregistré avec succès.",
        'update' => "Données de l'adhérent modifiées avec succès.",
        'delete' => "Adhérent supprimé avec succès.",
        'status_0' => "Compte d'adherent suspendu.",
        'status_1' => "Compte d'adherent activé.",
    ],

];


//RH
const POSTBYCELLBARM =  [

        [
            'name' => 'CHEF BARM',
            'permissions' => [
                'CHEF BARM'
            ],

        ],
        [
            'name' => 'CABINET CHEF BARM',
            'permissions' => [
                'ASSISTANT CHEF BARM',
                'SECRETAIRE CHEF BARM',
                'RESPONSABLE COURRIER ET ARCHIVES',
                'ASSISTANT COURRIER ET ARCHIVES',
                'SPECIALISTE PASSATION DE MARCHES',
                'ASSISTANT EN PASSATION DE MARCHES',
                'RESPONSABLE DES MOYENS GENERAUX',
                'ASSISTANT DES MOYENS GENERAUX',
                'RESPONSABLE COMMUNICATION',
                'ASSISTANT COMMUNICATION',
                'CONDUCTEUR COURSIER',
            ],
        ],
        [
            'name' => 'POINTS FOCAUX',
            'permissions' => [
                'RESPONSABLE PREPARATION A LA RECONVERSION',
            ],
        ],
        [
            'name' => 'CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
            'permissions' => [
                'CHEF CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
                'ASSISTANT DU CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
                'RESPONSABLE GESTIONNAIRE DES RESSOURCES HUMAINES',
                'ASSISTANT GESTIONNAIRE DES RESSOURCES HUMAINES',
                'RESPONSABLE DU PATRIMOINE ET DE LA LOGISTIQUE',
                'ASSISTANT DU PATRIMOINE ET DE LA LOGISTIQUE',
                'RESPONSABLE COMPTABLE',
                'ASSISTANT COMPTABLE',
                'RESPONSABLE JURIDIQUE',
                'ASSISTANT JURIDIQUE',
            ],
        ],
        [
            'name' => 'CELLULE FORMATION ET INSERTION',
            'permissions' => [
                'CHEF CELLULE FORMATION ET INSERTION',
                'RESPONSABLE PREPARATION A LA RECONVERSION',
                'ASSISTANT PREPARATION A LA RECONVERSION',
                'CONSEILLER PREPARATION A LA RECONVERSION',
                'CONSEILLER EN RECONVERSION',

                'RESPONSABLE PROJET',
                'ASSISTANT PROJET',

                'RESPONSABLE FORMATION',
                'ASSISTANT FORMATION',

                'RESPONSABLE INSERTION PUBLIC PRIVE',
                'ASSISTANT INSERTION PUBLIC PRIVE',

                'RESPONSABLE INSERTION AUTO EMPLOI',
                'ASSISTANT INSERTION AUTO EMPLOI',

            ],
        ],
        [
            'name' => 'CELLULE SUIVI-EVALUATION',
            'permissions' => [
                'CHEF CELLULE SUIVI-EVALUATION',
                'RESPONSABLE DES SYSTEMES DE L’INFORMATION',
                'ASSISTANT DES SYSTEMES DE L’INFORMATION',
                'RESPONSABLE SUIVI-EVALUATION',
                'ASSISTANT SUIVI-EVALUATION',
                'CHARGE D’ETUDES GENERALES ET DE MOBILISATION DES RESSOURCES',

                'ANALYSTE CREDIT',

            ],
        ],
        [
            'name' => 'PERSONNEL AGENCE COMPTABLE BARM SIEGE',
            'permissions' => [
                'RESPONSABLE AGENT COMPTABLE',
                'ASSISTANT AGENT COMPTABLE',
            ],
        ],
];


const PERSONALBARM = [
    [
        'user' => [
            'firstname' => 'AKE-DANHO',
            'lastname' => 'STEPHANE ERIC',
            'username' => 'COLONEL AKE-DANHO STEPHANE ERIC',
            'email' => 'stephaneerica@yahoo.fr',
            'phone' => '0759514588',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-09-20',
            'matricule_barm' => 'AE-001CB19',
            'grade' => 'Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CHEF BARM',
        'post' => ['CHEF BARM'],
    ],
    [
        'user' => [
            'firstname' => 'DOUKOURE',
            'lastname' => 'ROSE CHRISTIANE EPSE GODE',
            'username' => 'MME. DOUKOURE ROSE CHRISTIANE EPSE GODE',
            'email' => 'rosechristianedoukoure@yahoo.fr',
            'phone' => '0173725252',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1987-08-08',
            'matricule_barm' => 'DR-005AB19',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CABINET CHEF BARM',
        'post' => ['ASSISTANT CHEF BARM'],

    ],
    [
        'user' => [
            'firstname' => 'KOUDOU',
            'lastname' => 'GAGBO HENOC',
            'username' => 'M. KOUDOU GAGBO HENOC',
            'email' => 'henockoudou005@gmail.com',
            'phone' => '0748097886',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-09-20',
            'matricule_barm' => 'KH-006SB19',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CABINET CHEF BARM',
        'post' => ['SECRETAIRE CHEF BARM']
    ],
    [
        'user' => [
            'firstname' => 'KOUE',
            'lastname' => 'DARIUS OTIS GEOGES',
            'username' => 'ADJUDANT KOUE DARIUS OTIS GEOGES',
            'email' => 'kouedarius64@gmail.com',
            'phone' => '0101437374',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1972-10-20',
            'matricule_barm' => 'KD-017RC19',
            'grade' => 'Adjudant',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CABINET CHEF BARM',
        'post' => ['RESPONSABLE COURRIER ET ARCHIVES']
    ],
    [
        'user' => [
            'firstname' => 'GAHOUA',
            'lastname' => 'DJIHO. MIREILLE LAURA',
            'username' => 'MLLE. GAHOUA DJIHO. MIREILLE LAURA',
            'email' => 'gahouabelleprovidence@gmail.com',
            'phone' => '0544188822',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1987-07-17',
            'matricule_barm' => 'GD-003SP19',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CABINET CHEF BARM',
        'post' => ['SPECIALISTE PASSATION DE MARCHES']
    ],
    [
        'user' => [
            'firstname' => 'ANKUI',
            'lastname' => 'EBRIN MICHEL',
            'username' => 'M. ANKUI EBRIN MICHEL',
            'email' => 'michelebrin21@gmail.com',
            'phone' => '0758258521',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1989-01-11',
            'matricule_barm' => 'AP-026AM22',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CABINET CHEF BARM',
        'post' => ['ASSISTANT EN PASSATION DE MARCHES']
    ],
    [
        'user' => [
            'firstname' => 'ATHANGBA',
            'lastname' => 'WINNIE CYBELE',
            'username' => 'MLLE. ATHANGBA WINNIE CYBELE',
            'email' => 'winnieathangba@gmail.com',
            'phone' => '0505603583',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1986-08-26',
            'matricule_barm' => 'AC-007KC19',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CABINET CHEF BARM',
        'post' => ['RESPONSABLE COMMUNICATION']
    ],
    [
        'user' => [
            'firstname' => 'TRAORE',
            'lastname' => 'TIDJANE',
            'username' => 'ADJUDANT TRAORE TIDJANE',
            'email' => '',
            'phone' => '0102506205',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1984-09-09',
            'matricule_barm' => 'TT-008CC19',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CABINET CHEF BARM',
        'post' => ['CONDUCTEUR COURSIER']
    ],
    [
        'user' => [
            'firstname' => 'KONE',
            'lastname' => 'LADJI',
            'username' => 'M. KONE LADJI',
            'email' => '',
            'phone' => '0748404880',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1986-01-02',
            'matricule_barm' => 'KL-015CC22',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CABINET CHEF BARM',
        'post' => ['CONDUCTEUR COURSIER']
    ], [
        'user' => [
            'firstname' => 'KOFFI',
            'lastname' => 'CHARLES',
            'username' => 'ADJUDANT-CHEF KOFFI CHARLES',
            'email' => 'charlesberlin121@gmail.com',
            'phone' => '0759534062',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1969-06-29',
            'matricule_barm' => 'KC-023PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ], [
        'user' => [
            'firstname' => 'EDOUKOU',
            'lastname' => 'HONORE',
            'username' => 'M. EDOUKOU HONORE ',
            'email' => 'hedoukou05@gmail.com',
            'phone' => '0707511232',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1966-03-18',
            'matricule_barm' => 'EH-028PF20',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'ANOH',
            'lastname' => 'PIERRE',
            'username' => 'ADJUDANT-CHEF ANOH PIERRE',
            'email' => 'anohpierre70@gmail.com',
            'phone' => '0103476391',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1970-12-30',
            'matricule_barm' => 'AP-018PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'TANOH',
            'lastname' => 'KAMENAN JOACHIM',
            'username' => 'M. TANOH KAMENAN JOACHIM ',
            'email' => '',
            'phone' => '0102798715',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1968-12-31',
            'matricule_barm' => 'TJ-011PF20',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'N’DRIN',
            'lastname' => 'BANDAMAN ELIE',
            'username' => 'LIEUTENANT-COLONEL N’DRIN BANDAMAN ELIE',
            'email' => 'chrisnouveau1@gmail.com',
            'phone' => '0707703897',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1974-10-12',
            'matricule_barm' => 'WA-014PF20',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'WONAL',
            'lastname' => 'ADOUABO MIESSAN AIME',
            'username' => 'M.WONAL ADOUABO MIESSAN AIME ',
            'email' => 'wonaladouabo@gmail.com',
            'phone' => '0140098122',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1969-01-12',
            'matricule_barm' => 'WA-010CB20',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'KANHON',
            'lastname' => 'MONTEOMO AYMARD BRICE',
            'username' => 'LIEUTENANT-COLONEL KANHON MONTEOMO AYMARD BRICE',
            'email' => 'bricekanhon@gmail.com',
            'phone' => '0554004516',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1981-01-06',
            'matricule_barm' => 'KB-016PF20',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'GNEKPATO',
            'lastname' => 'DIDIER GERVAIS',
            'username' => 'ADJUDANT-CHEF GNEKPATO DIDIER GERVAIS',
            'email' => 'gnekpatodg@gmail.com',
            'phone' => '0101249798',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1976-01-23',
            'matricule_barm' => 'GG-020PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'FOFANA',
            'lastname' => 'SIRITIEHOUIN',
            'username' => 'LIEUTENANT-COLONEL FOFANA SIRITIEHOUIN',
            'email' => 'siritiehouinfofana@gmail.com',
            'phone' => '0707983392',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1969-01-15',
            'matricule_barm' => 'FS-015PF20',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'KOFFI',
            'lastname' => 'KOUAME MESMIN',
            'username' => 'ADJUDANT-CHEF KOFFI KOUAME MESMIN',
            'email' => 'mesmino1@gmail.com',
            'phone' => '0101009717',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1974-04-18',
            'matricule_barm' => 'KM-022PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'ASSI',
            'lastname' => 'ALLAH APOLINAIRE',
            'username' => 'ADJUDANT-CHEF ASSI ALLAH APOLINAIRE',
            'email' => 'assiallah@gmail.com',
            'phone' => '0102470800',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1983-06-21',
            'matricule_barm' => 'AA-021PF20',
            'grade' => 'Adjudant Chef',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Bouaké'
        ],
        'service' => 'POINTS FOCAUX',
        'post' => ['POINT FOCAL']
    ],
    [
        'user' => [
            'firstname' => 'KOFFI',
            'lastname' => 'KONAN JOCELYN',
            'username' => 'M. KOFFI KONAN JOCELYN ',
            'email' => 'jocekof@gmail.com',
            'phone' => '0707484256',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1994-12-10',
            'matricule_barm' => 'KJ-035AF23',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
        'post' => ['ASSISTANT DU CELLULE ADMINISTRATION FINANCE LOGISTIQUE']
    ],
    [
        'user' => [
            'firstname' => 'DIABATE',
            'lastname' => 'OUMAROU',
            'username' => 'M. DIABATE OUMAROU',
            'email' => 'diabatealfarouck@gmail.com',
            'phone' => '0708180593',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1985-12-31',
            'matricule_barm' => 'DO-031RH23',
            'grade' => 'A3',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
        'post' => ['RESPONSABLE GESTIONNAIRE DES RESSOURCES HUMAINES',
            'RESPONSABLE DES MOYENS GENERAUX',
        ]
    ],
    [
        'user' => [
            'firstname' => 'GOORE',
            'lastname' => 'BI KOUASSI ARTHUR R.',
            'username' => 'ADJUDANT GOORE BI KOUASSI ARTHUR R.',
            'email' => 'goorbykouess@gmail.com',
            'phone' => '0709126565',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-09-20',
            'matricule_barm' => 'GK-019RT19',
            'grade' => 'Adjudant',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
        'post' => ['RESPONSABLE DU PATRIMOINE ET DE LA LOGISTIQUE']
    ],
    [
        'user' => [
            'firstname' => 'GOURI',
            'lastname' => 'VANIE JEAN-CHRISTIAN',
            'username' => 'LIEUTENANT-COLONEL GOURI VANIE JEAN-CHRISTIAN',
            'email' => 'jchristian.gouri@yahoo.fr',
            'phone' => '0709056906',
        ],
        'partner' => [
            'birth_date' => '1977-09-08',
            'gender' => GENDERS[1],
            'matricule_barm' => 'GC-009CI19',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['CHEF CELLULE FORMATION ET INSERTION']
    ],
    [
        'user' => [
            'firstname' => 'KOUAO',
            'lastname' => 'MONNET FESTOS',
            'username' => 'M.KOUAO MONNET FESTOS',
            'email' => 'festosmonnet@gmail.com',
            'phone' => '0504423153',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1985-12-05',
            'matricule_barm' => 'KF-004PR19',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['RESPONSABLE PREPARATION A LA RECONVERSION']
    ],
    [
        'user' => [
            'firstname' => 'AHORE',
            'lastname' => 'AKAFFOU N’GUESSAN ROSAIRE AIMEE BERTILLE',
            'username' => 'MLLE AHORE AKAFFOU N’GUESSAN ROSAIRE AIMEE BERTILLE',
            'email' => 'ahore.rosaire@gmail.com',
            'phone' => '0777532852',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1975-09-20',
            'matricule_barm' => 'AH-030CR22',
            'grade' => 'B3',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['CONSEILLER PREPARATION A LA RECONVERSION']
    ],
    [
        'user' => [
            'firstname' => 'GBETIBOUO',
            'lastname' => 'ABRAHAM',
            'username' => 'M. GBETIBOUO ABRAHAM',
            'email' => 'gbetibouo.2014@gmail.com',
            'phone' => '0747709955',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1985-07-15',
            'matricule_barm' => 'GA-032CR23',
            'grade' => 'A4',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['CONSEILLER EN RECONVERSION']
    ],
    [
        'user' => [
            'firstname' => 'DOSSO',
            'lastname' => 'NANNAN',
            'username' => 'MLLE. DOSSO NANNAN',
            'email' => 'dossonannan@gmail.com',
            'phone' => '0747170465',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1983-09-19',
            'matricule_barm' => 'DO-034CR23',
            'grade' => 'A3',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE FORMATION ET INSERTION',
        'post' => ['CONSEILLER EN RECONVERSION']
    ],
    [
        'user' => [
            'firstname' => 'KOUADIO',
            'lastname' => 'N’CHO HERMANN',
            'username' => 'LIEUTENANT-COLONEL KOUADIO N’CHO HERMANN',
            'email' => 'he.kouadio@defense.gouv.ci',
            'phone' => '0140519899',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-09-20',
            'matricule_barm' => 'KH-02RI19',
            'grade' => 'Lieutenant Colonel',
            'statut_personnel' => 'Fonctionnaire militaire',
            'type' => 'militaire',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE SUIVI-EVALUATION',
        'post' => ['RESPONSABLE DES SYSTEMES DE L’INFORMATION']
    ],
    [
        'user' => [
            'firstname' => 'KOUASSI',
            'lastname' => 'N’GUESSAN',
            'username' => 'M. KOUASSI N’GUESSAN',
            'email' => 'coyssy.yssan@gmail.com',
            'phone' => '0505545723',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-12-30',
            'matricule_barm' => 'KN-025SE21',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE SUIVI-EVALUATION',
        'post' => ['RESPONSABLE SUIVI-EVALUATION']
    ],
    [
        'user' => [
            'firstname' => 'YAO',
            'lastname' => 'EPSE YAPI AKOUA TAMIA RITA EMILIENNE',
            'username' => 'MME.YAO EPSE YAPI AKOUA TAMIA RITA EMILIENNE',
            'email' => '',
            'phone' => '0789086985',
        ],
        'partner' => [
            'gender' => GENDERS[0],
            'birth_date' => '1981-12-30',
            'matricule_barm' => 'YY-027AE22',
            'statut_personnel' => 'Contractuel',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE SUIVI-EVALUATION',
        'post' => ['ASSISTANT SUIVI-EVALUATION']
    ],
    [
        'user' => [
            'firstname' => 'YAPI',
            'lastname' => 'BEUGRE LAURENT',
            'username' => 'M. YAPI BEUGRE LAURENT',
            'email' => 'laurentyapi1@gmail.com',
            'phone' => '0151101438',
        ],
        'partner' => [
            'gender' => GENDERS[1],
            'birth_date' => '1975-08-28',
            'matricule_barm' => 'DO-033CF23',
            'grade' => 'A5',
            'statut_personnel' => 'Fonctionnaire civil',
            'type' => 'civil',
            'ville_barm' => 'Abidjan'
        ],
        'service' => 'CELLULE SUIVI-EVALUATION',
        'post' => ['CHARGE D’ETUDES GENERALES ET DE MOBILISATION DES RESSOURCES']
    ],

];
