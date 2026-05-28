"use strict";
!(function () {
    var a = document.querySelector("#TagifyBasic"),
        a = (new Tagify(a), document.querySelector("#TagifyReadonly")),
        a = (new Tagify(a), document.querySelector("#TagifySkills")),
        e = document.querySelector("#TagifyBenefits"),
        skills = [
            "Leadership",
            "Gestion de crise",
            "Jardinier",
            "Secretaire",
            "Boulanger",
            "Gestion du stress",
            "Travail d'équipe",
            "Planification stratégique",
            "Prise de décision",
            "Discipline",
            "Adaptabilité",
            "Communication efficace",
            "Formation et mentorat",
            "Gestion des ressources",
            "Analyse de risques",
            "Sécurité",
            "Logistique",
            "Utilisation d'équipement spécialisé",
            "Maintenance",
            "Premiers secours",
            "Surveillance et reconnaissance",
            "Technologie de l'information et de la communication",
            "Langues étrangères",
            "Administration",
            "Gestion des opérations",
            "Stratégie de combat",
            "Gestion du temps",
            "Résolution de problèmes",
            "Intégrité",
            "Négociation",
            "Présentation publique",
            "Planification d'événements",
            "Enseignement",
            "Mentorat",
            "Analyse des données",
            "Traitement de l'information",
            "Coordination",
            "Survie en environnement hostile",
            "Maintenance préventive",
            "Sens de l'organisation",
            "Développement personnel",
            "Développement professionnel",
            "Gestion du personnel",
            "Intelligence émotionnelle",
            "Formation continue",
            "Orientation",
            "Développement de compétences",
            "Gestion des conflits",
            "Évaluation des performances",
            "Diplomatie",
            "Respect des règles",
            "Assistance administrative",
            "Soutien logistique",
            "Planification logistique",
            "Gestion des finances",
            "Gestion des stocks",
            "Planification opérationnelle",
            "Analyse de données opérationnelles",
        ],
        benefits = [
            "Salaire compétitif",
            "Avantages sociaux",
            "Assurance santé",
            "Retraite",
            "Congés payés",
            "Opportunités de formation et de développement professionnel",
            "Flexibilité d'horaires",
            "Télétravail",
            "Bénéfices supplémentaires",
            "Tickets restaurant",
            "Primes",
            "Stabilité de l'emploi",
            "Possibilité d'avancement de carrière",
            "Environnement de travail stimulant",
            "Reconnaissance professionnelle",
            "Équilibre entre vie professionnelle et vie personnelle",
            "Opportunités de réseautage professionnel",
            "Possibilité de voyages professionnels",
            "Accès à des ressources et des outils de pointe",
            "Culture d'entreprise positive",
            "Leadership inspirant",
            "Possibilité de participer à des projets innovants",
            "Diversité et inclusion",
            "Programmes de bien-être des employés",
            "Conciliation travail-famille",
            "Environnement de travail sûr et sain",
            "Opportunités de travail à l'étranger",
            "Participation à des événements d'entreprise",
            "Programmes de mentorat",
            "Autonomie dans le travail",
            "Possibilité de faire une différence dans la société",
            "Avantages fiscaux",
            "Accès à des installations sportives ou de loisirs",
            "Possibilité de contribuer à des projets socialement responsables",
            "Participation à des programmes de volontariat d'entreprise",
        ];
        a =
            (new Tagify(a, {
                whitelist: skills,
                maxTags: 10,
                dropdown: {
                    maxItems: 20,
                    classname: "tags-inline",
                    enabled: 0,
                    closeOnSelect: !1,
                },
            }),
            new Tagify(e, {
                whitelist: benefits,
                maxTags: 10,
                dropdown: {
                    maxItems: 20,
                    classname: "tags-inline",
                    enabled: 0,
                    closeOnSelect: !1,
                },
            }),
            document.querySelector("#TagifyUserList"));
    let i = new Tagify(a, {
        tagTextProp: "name",
        enforceWhitelist: !0,
        skipInvalid: !0,
        dropdown: {
            closeOnSelect: !1,
            enabled: 0,
            classname: "users-list",
            searchKeys: ["name", "email"],
        },
        templates: {
            tag: function (a) {
                return `
    <tag title="${a.title || a.email}"
      contenteditable='false'
      spellcheck='false'
      tabIndex="-1"
      class="${this.settings.classNames.tag} ${a.class || ""}"
      ${this.getAttributes(a)}
    >
      <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
      <div>
        <div class='tagify__tag__avatar-wrap'>
          <img onerror="this.style.visibility='hidden'" src="${a.avatar}">
        </div>
        <span class='tagify__tag-text'>${a.name}</span>
      </div>
    </tag>
  `;
            },
            dropdownItem: function (a) {
                return `
    <div ${this.getAttributes(a)}
      class='tagify__dropdown__item align-items-center ${a.class || ""}'
      tabindex="0"
      role="option"
    >
      ${
          a.avatar
              ? `<div class='tagify__dropdown__item__avatar-wrap'>
          <img onerror="this.style.visibility='hidden'" src="${a.avatar}">
        </div>`
              : ""
      }
      <div class="fw-medium">${a.name}</div>
      <span>${a.email}</span>
    </div>
  `;
            },
            dropdownHeader: function (a) {
                return `
        <div class="${this.settings.classNames.dropdownItem} ${
                    this.settings.classNames.dropdownItem
                }__addAll">
            <strong>${this.value.length ? "Add remaning" : "Add All"}</strong>
            <span>${a.length} members</span>
        </div>
    `;
            },
        },
        whitelist: [
            {
                value: 1,
                name: "Justinian Hattersley",
                avatar: "https://i.pravatar.cc/80?img=1",
                email: "jhattersley0@ucsd.edu",
            },
            {
                value: 2,
                name: "Antons Esson",
                avatar: "https://i.pravatar.cc/80?img=2",
                email: "aesson1@ning.com",
            },
            {
                value: 3,
                name: "Ardeen Batisse",
                avatar: "https://i.pravatar.cc/80?img=3",
                email: "abatisse2@nih.gov",
            },
            {
                value: 4,
                name: "Graeme Yellowley",
                avatar: "https://i.pravatar.cc/80?img=4",
                email: "gyellowley3@behance.net",
            },
            {
                value: 5,
                name: "Dido Wilford",
                avatar: "https://i.pravatar.cc/80?img=5",
                email: "dwilford4@jugem.jp",
            },
            {
                value: 6,
                name: "Celesta Orwin",
                avatar: "https://i.pravatar.cc/80?img=6",
                email: "corwin5@meetup.com",
            },
            {
                value: 7,
                name: "Sally Main",
                avatar: "https://i.pravatar.cc/80?img=7",
                email: "smain6@techcrunch.com",
            },
            {
                value: 8,
                name: "Grethel Haysman",
                avatar: "https://i.pravatar.cc/80?img=8",
                email: "ghaysman7@mashable.com",
            },
            {
                value: 9,
                name: "Marvin Mandrake",
                avatar: "https://i.pravatar.cc/80?img=9",
                email: "mmandrake8@sourceforge.net",
            },
            {
                value: 10,
                name: "Corrie Tidey",
                avatar: "https://i.pravatar.cc/80?img=10",
                email: "ctidey9@youtube.com",
            },
        ],
    });
    i.on("dropdown:select", function (a) {
        a.detail.elm.classList.contains(
            i.settings.classNames.dropdownItem + "__addAll"
        ) && i.dropdown.selectAll();
    }).on("edit:start", function ({ detail: { tag: a, data: e } }) {
        i.setTagTextNode(a, `${e.name} <${e.email}>`);
    });
    e = Array.apply(null, Array(100)).map(function () {
        return (
            Array.apply(null, Array(~~(10 * Math.random() + 3)))
                .map(function () {
                    return String.fromCharCode(26 * Math.random() + 97);
                })
                .join("") + "@gmail.com"
        );
    });
    const n = document.querySelector("#TagifyEmailList"),
        s = new Tagify(n, {
            pattern:
                /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
            whitelist: e,
            callbacks: {
                invalid: function (a) {
                    console.log("invalid", a.detail);
                },
            },
            dropdown: { position: "text", enabled: 1 },
        }),
        l = n.nextElementSibling;
    l.addEventListener("click", function () {
        s.addEmptyTag();
    });
})();
