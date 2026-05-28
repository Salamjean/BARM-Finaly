// "use strict";

// (function () {
//     var e = $(".select2"),
//         a = $(".selectpicker"),
//         i = document.querySelector("#wizard-validation");

//         if (null !== i) {
//             var t = i.querySelector("#wizard-validation-form");
//             const s = t.querySelector("#etat_civil");
//             var o = t.querySelector("#marital_situation"),
//                 n = t.querySelector("#address"),
//                 c = t.querySelector("#professional"),
//                 r = [].slice.call(t.querySelectorAll(".btn-next")),
//                 u = [].slice.call(t.querySelectorAll(".btn-prev"));
        
//             const l = new Stepper(i, { linear: true });
        
//             const d = FormValidation.formValidation(s, {
//                 fields: {
//                     last_name: {
//                         validators: {
//                             notEmpty: { message: "Le Nom de famille est requis." },
//                             stringLength: {
//                                 min: 3,
//                                 message: "Le nom doit contenir au moins 03 caractères"
//                             },
//                             regexp: { regexp: /^[a-zA-Z]+$/, message: "Le nom ne peut contenir que des lettres." }
//                         }
//                     },
//                     first_name: {
//                         validators: {
//                             notEmpty: { message: "Le Prénom est requis." },
//                             stringLength: {
//                                 min: 3,
//                                 max: 30,
//                                 message: "Ce champ doit contenir au moins 03 caractères. "
//                             },
//                             regexp: { regexp: /^[a-zA-Z\s]+$/, message: "Le nom ne peut contenir que des lettres"}
//                         }
//                     },
//                     gender: { validators: { notEmpty: { message: "Le genre est requis" } } },
//                     birth_date: { validators: { notEmpty: { message: "La date de naissance est requise." } } },
//                     type_piece: { validators: { notEmpty: { message: "Le type de pièce est requise." } } },
//                     no_card: { validators: { notEmpty: { message: "Le numéro de la pièce est requis." },
//                         stringLength: {
//                             min: 11,
//                             message: "Le numéro de la pièce doit contenir au moins 11 caractères."
//                         },
//                         regexp: { regexp: /^[a-zA-Z0-9 ]+$/, message: "Le Numéro de la pièce contient que des lettres et des chiffres." }
//                     }
//                     },
//                     ethnic: { validators: { notEmpty: { message: "L'ethnie est requise." } } },
//                     religion: { validators: { notEmpty: { message: "La religion est requise." } } }
//                 },
//                 plugins: {
//                     trigger: new FormValidation.plugins.Trigger(),
//                     bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: "", rowSelector: ".col-sm-6" }),
//                     autoFocus: new FormValidation.plugins.AutoFocus(),
//                     submitButton: new FormValidation.plugins.SubmitButton()
//                 },
//                 init: e => {
//                     e.on("plugins.message.placed", function (e) {
//                         if (e.element.parentElement.classList.contains("input-group")) {
//                             e.element.parentElement.insertAdjacentElement("afterend", e.messageElement)
//                         }
//                     })
//                 }
//             }).on("core.form.valid", function () {
//                 l.next()
//             });
        
//             const m = FormValidation.formValidation(o, {
//                 fields: {
//                     statut: {
//                         validators: {
//                             notEmpty: { message: "Le statut est requis." }
//                         }
//                     },
//                     partnerName: {
//                         validators: {
//                             notEmpty: { message: "Le nom du conjoint est requis." },
//                             stringLength: {
//                                 min: 3,
//                                 max: 30,
//                                 message: "Ce champ doit contenir au moins 3 caractères et au maximum 30 caractères."
//                             },
//                             regexp: { regexp: /^[a-zA-Z\s]+$/, message: "Le nom du conjoint ne peut contenir que des lettres."}
//                         }
//                     },
//                     partnerJob: {
//                         validators: {
//                             notEmpty: { message: "La profession du conjoint est requise." }
//                         }
//                     },
//                     contactPartner: {
//                         validators: {
//                             notEmpty: { message: "Le contact du conjoint est requis." },
//                             stringLength: {
//                                 min: 10,
//                                 message: "Ce champ doit contenir au moins 10 caractères."
//                             },
//                             regexp: { regexp: /^[0-9]+$/, message: "Le contact doit contenir uniquement des chiffres."}
//                         }
//                     }
//                 },
//                 plugins: {
//                     trigger: new FormValidation.plugins.Trigger(),
//                     bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: "", rowSelector: ".col-sm-6" }),
//                     autoFocus: new FormValidation.plugins.AutoFocus(),
//                     submitButton: new FormValidation.plugins.SubmitButton()
//                 }
//             }).on("core.form.valid", function () {
//                 l.next();
//             });
        
//             const h = FormValidation.formValidation(n, {
//                 fields: {
//                     telephone: {
//                         validators: {
//                             stringLength: {
//                                 min: 10,
//                                 max: 10,
//                                 message: "Ce champ doit contenir exactement 10 chiffres."
//                             },
//                             regexp: { regexp: /^[0-9]+$/, message: "Le contact doit contenir uniquement des chiffres."}
//                         }
//                     },
//                     mobile: {
//                         validators: {
//                             stringLength: {
//                                 min: 10,
//                                 max:10,
//                                 message: "Ce champ doit contenir exactement 10 chiffres."
//                             },
//                             regexp: { regexp: /^[0-9]+$/, message: "Le contact doit contenir uniquement des chiffres."}
//                         }
//                     },
//                     email: {
//                         validators: {
//                             emailAddress: { message: "Ceci n'est pas une adresse email valide." }
//                         }
//                     },
//                     address: {
//                         validators: {
//                             stringLength: {
//                                 max: 30,
//                                 message: "Ce champ doit contenir au maximum 30 caractères."
//                             }
//                         }
//                     }
//                 },
//                 plugins: {
//                     trigger: new FormValidation.plugins.Trigger(),
//                     bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: "", rowSelector: ".col-sm-6" }),
//                     autoFocus: new FormValidation.plugins.AutoFocus(),
//                     submitButton: new FormValidation.plugins.SubmitButton()
//                 }
//             }).on("core.form.valid", function () {
//                 l.next();
//             });
        
//             const p = FormValidation.formValidation(c, {
//                 fields: {
//                     armee: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     unite_rachement: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     statut: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     dernier_grade: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     mecano: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     duree_service: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     periode: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     organism: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     fonction: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     diplome_militaire: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     annees1: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     diplome_civil: { validators: { notEmpty: { message: "Ce champ est requis." } } },
//                     annees2: { validators: { notEmpty: { message: "Ce champ est requis." } } }
//                 },
//                 plugins: {
//                     trigger: new FormValidation.plugins.Trigger(),
//                     bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: "", rowSelector: ".col-sm-6" }),
//                     autoFocus: new FormValidation.plugins.AutoFocus(),
//                     submitButton: new FormValidation.plugins.SubmitButton()
//                 }
//             }).on("core.form.valid", function () {
//                 l.next();
//                 alert("Submitted..!!");
//             });
        
//             r.forEach(btnNext => {
//                 btnNext.addEventListener("click", () => {
//                     switch (l._currentIndex) {
//                         case 0: d.validate(); break;
//                         case 1: m.validate(); break;
//                         case 2: h.validate(); break;
//                         case 3: p.validate(); break;
//                     }
//                 });
//             });
        
//             u.forEach(btnPrev => {
//                 btnPrev.addEventListener("click", () => {
//                     switch (l._currentIndex) {
//                         case 3:
//                         case 2:
//                         case 1:
//                             l.previous();
//                             break;
//                     }
//                 });
//             });
//         }
// })();