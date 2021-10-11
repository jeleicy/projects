const facteurMaison106 = {
    "A14.1": [
        {"val1": "", "op1": ">", "val2": 70, "op2": "<", "res": 0.5},
        {"val1": 70, "op1": ">=", "val2": 90, "op2": "<", "res": 0.7},
        {"val1": 90, "op1": ">=", "val2": 110, "op2": "<", "res": 1},
        {"val1": 110, "op1": ">=", "val2": 130, "op2": "<=", "res": 1.1},
        {"val1": 130, "op1": ">", "val2": "", "op2": "<", "res": 1.6}
    ]
};

const facteurAppartement104 = {
    "A14.1": [
        {"val1": "", "op1": ">", "val2": 35, "op2": "<", "res": 0.5},
        {"val1": 35, "op1": ">=", "val2": 60, "op2": "<", "res": 0.7},
        {"val1": 60, "op1": ">=", "val2": 70, "op2": "<", "res": 1},
        {"val1": 70, "op1": ">=", "val2": 90, "op2": "<=", "res": 1.2},
        {"val1": 90, "op1": ">", "val2": 110, "op2": "<", "res": 1.5},
        {"val1": 110, "op1": ">", "val2": 130, "op2": "<", "res": 1.9},
        {"val1": 130, "op1": ">", "val2": "", "op2": "<", "res": 2.5}
    ]
};

const facteurMaison104 = {
    "A14.1": [
        {"val1": "", "op1": ">", "val2": 70, "op2": "<", "res": 0.5},
        {"val1": 70, "op1": ">=", "val2": 90, "op2": "<", "res": 0.7},
        {"val1": 90, "op1": ">=", "val2": 110, "op2": "<", "res": 1},
        {"val1": 110, "op1": ">=", "val2": 130, "op2": "<=", "res": 1.1},
        {"val1": 130, "op1": ">", "val2": "", "op2": "<", "res": 1.6}
    ]
};

const montantUnitarieApartment104 = {
    "A14.1": [
        {"h1": "24500", "h2": "20100", "h3": "13400"},
        {"h1": "32200", "h2": "26400", "h3": "17600"},
        {"h1": "39700", "h2": "32500", "h3": "21700"}
    ]
};

const montantUnitarieMaison104 = {
    "A14.1": [
        {"h1": "52700", "h2": "43100", "h3": "28700"},
        {"h1": "66400", "h2": "54400", "h3": "36200"},
        {"h1": "79900", "h2": "65400", "h3": "43600"}
    ]
};

const barEn101 = {
    "A14.1":{"h1":"1700","h2":"1400","h3":"900"}
};

const barTh113 = {
    "A14.1":{"h1":"41300","h2":"33800","h3":"26300"}
};

const barTh101 = {
    "A14.1":{"h1":"21500","h2":"24100","h3":"27600"}
};

const barEn103 = {
    "A14.1": {"h1":"1600","h2":"1300","h3":"900"}
};

const barEn148 = {
    "A14.1":{"maison":"15600","appartement":"11900"}
};

const barEn102 = {
    "A14.1": [
        {"electricite":{"h1":"2400","h2":"2000","h3":"1300"}},
        {"combustible":{"h1":"3800","h2":"3100","h3":"2100"}}
    ]
};

const barEn106 = {
    "A14.1": [
        {
            "maison":{"h1":"46900","h2":"39600","h3":"28500"},
            "appartement":{"h1":"24800","h2": "21200","h3":"15800"}
        }
    ]
};

const CollectiveBarTh125 = {
    "A14.1": {"h1":"23000","h2":"18800","h3":"12500"}
};

const IndividualleBarTh125 = {
    "A14.1": {"h1":"39700","h2":"32500","h3":"21600"}
};

const CollectiveBarTh127 = {
    "A14.1": {"h1":"21800","h2":"17800","h3":"11900"}
};

const IndividualleBarTh127 = {
    "A14.1": {"h1":"31600","h2":"25900","h3":"17200"}
};

const barEn160 = {"A14.1": {"h1": "6700","h2": "5600","h3": "15800"}};

exports.getcalculateValues = function(res, req, group = null,chauffage= null,zone= null,situation= null,surface= null,longer_isole= null,efficacite= null,type= null,logement= null, version = null,number_logements=null,type_installation=null, type_ventilation=null, type_caisson=null, scop = null, number_installes=null,secteur_d_activite = null, equipe_instale=null,nombre_installations=null)
{
    // return number_installes;
    version = 'A14.1';
    // return group;
    if (version && situation) {
        if (group == "BAR-EN-101") {
            // BAR-EN-101
            if (zone && barEn101[version]) return barEn101[version][zone] * surface; else return 'Error: You need the Zone (H) value';
        } else if (group == "BAR-TH-101") {
            // BAR-EN-101
            // return barTh101[version][zone];
            if (zone && barEn101[version]) return barTh101[version][zone]; else return 'Error: You need the Zone (H) value';
        } else if (group == "BAR-TH-113") {
            // BAR-EN-101
            if (zone && barTh113[version]) return barTh113[version][zone]; else return 'Error: You need the Zone (H) value';
        } else if (group == "BAR-EN-102") {
            // BAR-EN-102
            if (chauffage=='electricite') ind=0; else ind=1;
            if (chauffage && zone && surface && barEn102[version]) return barEn102[version][ind][chauffage][zone] * surface; else return 'Error: You need the' +
                ' Chauffage, Zone (H) and Surface values';
        } else if (group == "BAR-EN-103") {
            // BAR-EN--103
            if (zone && surface && barEn103[version]) return barEn103[version][zone] * surface; else return 'Error: You need the' +
                ' Zone (H) and Surface values';
        } else if (group == "BAR-TH-148") {
            // BAR-TH-148
            if (logement && barEn148[version]) return barEn148[version][logement]; else return 'Error: You need the logement Value';
        } else if (group == "BAR-TH-106") {
            //BAR-TH-106
            if (logement && zone) {
                if (logement == 'appartement') {
                    // BAR-TH-106: Logement: appartement
                    // return logement;
                    if (zone && barEn106[version]) return barEn106[version][0].appartement[zone]; else return 'Error: You need the zone Values';
                } else if (logement == 'maison') {
                    // BAR-TH-106: Logement: Maison
                    //************************************************
                    let evalOp = '';
                    let resOp = 0;
                    let arrayJson = '';

                    if (facteurMaison106[version]) {
                        for (let i = 0; i < facteurMaison106[version].length; i++) {
                            arrayJson = facteurMaison106[version][i];
                            // return arrayJson.val2;
                            if (arrayJson.val1 != '' && arrayJson.val2 != '') {
                                evalOp = surface + arrayJson.op1 + arrayJson.val1 + ' && ' + surface + arrayJson.op2 + arrayJson.val2;
                                resOp = arrayJson.res;
                                if (eval(evalOp)) return barEn106[version][0][logement][zone] * resOp;
                            }

                            if (arrayJson.val1 == '' && arrayJson.val2 != '') {
                                evalOp = surface + arrayJson.op2 + arrayJson.val2;
                                resOp = arrayJson.res;
                                if (eval(evalOp)) return barEn106[version][0][logement][zone] * resOp;
                            }

                            if (arrayJson.val2 == '' && arrayJson.val1 != '') {
                                evalOp = surface + arrayJson.op1 + arrayJson.val1;
                                resOp = arrayJson.res;
                                if (eval(evalOp)) return barEn106[version][0][logement][zone] * resOp;
                            }
                        }
                    } else {
                        return 'Error: We need the valid Version';
                    }
                } else {
                    return 'Error: You need the logement Value';
                }
            } else {
                return 'Error: You need the Logement and Zone Value';
            }
        } else if (group == "BAR-TH-104") {
            //BAR-TH-104
            if (logement && zone && surface) {

                if (logement == 'appartement') {
                    // BAR-TH-104: Logement: appartement
                    let evalOp = '';
                    let resOp = 0;
                    let arrayJson = '';
                    let facteur = 0;

                    if (facteurAppartement104[version]) {
                        for (let i = 0; i < facteurAppartement104[version].length; i++) {
                            arrayJson = facteurAppartement104[version][i];
                            // return arrayJson;
                            if (arrayJson.val1 != '' && arrayJson.val2 != '') {
                                evalOp = surface + arrayJson.op1 + arrayJson.val1 + ' && ' + surface + arrayJson.op2 + arrayJson.val2;
                                resOp = arrayJson.res;
                                if (eval(evalOp)) facteur = resOp;
                            }

                            if (arrayJson.val1 == '' && arrayJson.val2 != '') {
                                evalOp = surface + arrayJson.op2 + arrayJson.val2;
                                resOp = arrayJson.res;
                                if (eval(evalOp)) facteur = resOp;
                            }

                            if (arrayJson.val2 == '' && arrayJson.val1 != '') {
                                evalOp = surface + arrayJson.op1 + arrayJson.val1;
                                resOp = arrayJson.res;
                                if (eval(evalOp)) facteur = resOp;
                            }
                        }
                        // return efficacite;
                        if (efficacite >= 102 && efficacite <= 110) {
                            if (zone == 'h1') return facteur*montantUnitarieApartment104[version][0].h1;
                            if (zone == 'h2') return facteur*montantUnitarieApartment104[version][0].h2;
                            if (zone == 'h3') return facteur*montantUnitarieApartment104[version][0].h3;
                        }

                        if (efficacite >= 110 && efficacite < 120) {
                            if (zone == 'h1') return facteur*montantUnitarieApartment104[version][1].h1;
                            if (zone == 'h2') return facteur*montantUnitarieApartment104[version][1].h2;
                            if (zone == 'h3') return facteur*montantUnitarieApartment104[version][1].h3;
                        }

                        if (efficacite >= 120) {
                            if (zone == 'h1') return facteur*montantUnitarieApartment104[version][2].h1;
                            if (zone == 'h2') return facteur*montantUnitarieApartment104[version][2].h2;
                            if (zone == 'h3') return facteur*montantUnitarieApartment104[version][2].h3;
                        }
                    } else {
                        return 'Error: We need the valid Version';
                    }
                } else if (logement == 'maison') {
                    // BAR-TH-104: Logement: Maison
                    //************************************************
                    let evalOp = '';
                    let resOp = 0;
                    let arrayJson = '';

                    if (facteurMaison104[version]) {
                        for (let i = 0; i < facteurMaison104[version].length; i++) {
                            arrayJson = facteurMaison104[version][i];
                            // return zone;
                            // return montantUnitarieMaison104[version][0][zone];
                            if (arrayJson.val1 != '' && arrayJson.val2 != '') {
                                evalOp = surface + arrayJson.op1 + arrayJson.val1 + ' && ' + surface + arrayJson.op2 + arrayJson.val2;
                                resOp = arrayJson.res;
                                // return '1 = '+resOp;
                                if (eval(evalOp)) return montantUnitarieMaison104[version][0][zone] * resOp;
                            }

                            if (arrayJson.val1 == '' && arrayJson.val2 != '') {
                                evalOp = surface + arrayJson.op2 + arrayJson.val2;
                                resOp = arrayJson.res;
                                // return '2 = '+resOp;
                                if (eval(evalOp)) return montantUnitarieMaison104[version][0][zone] * resOp;
                            }

                            if (arrayJson.val2 == '' && arrayJson.val1 != '') {
                                evalOp = surface + arrayJson.op1 + arrayJson.val1;
                                resOp = arrayJson.res;
                                // return '3 = '+resOp;
                                if (eval(evalOp)) return montantUnitarieMaison104[version][0][zone] * resOp;
                            }
                        }

                        if (efficacite >= 102 && efficacite <= 110) {
                            if (zone == 'h1') return facteur*montantUnitarieMaison104[version][0].h1;
                            if (zone == 'h2') return facteur*montantUnitarieMaison104[version][0].h2;
                            if (zone == 'h3') return facteur*montantUnitarieMaison104[version][0].h3;
                        }

                        if (efficacite >= 110 && efficacite < 120) {
                            if (zone == 'h1') return facteur*montantUnitarieMaison104[version][1].h1;
                            if (zone == 'h2') return facteur*montantUnitarieMaison104[version][1].h2;
                            if (zone == 'h3') return facteur*montantUnitarieMaison104[version][1].h3;
                        }

                        if (efficacite >= 120) {
                            if (zone == 'h1') return facteur*montantUnitarieMaison104[version][2].h1;
                            if (zone == 'h2') return facteur*montantUnitarieMaison104[version][2].h2;
                            if (zone == 'h3') return facteur*montantUnitarieMaison104[version][2].h3;
                        }
                    } else {
                        return 'Error: We need the valid Version';
                    }
                }
            } else {
                return 'Error: You need the Logement and Zone Value';
            }
        } else if (group == "BAR-TH-160") {
            // BAR-TH-160
            if (zone && longer_isole && barEn160[version]) return barEn160[version][zone] * longer_isole; else return 'Error: You need the Zone and Longer Isole' +
                ' Value';
        } else if (group == "BAR-TH-125") {
            // BAR-TH-125
            if (type_installation=='collective') {
                if (zone && number_logements && type_installation) return CollectiveBarTh125[version][zone] * number_logements; else return 'Error: You need the' +
                    ' Zone (H) and Surface values';
            } else {
                if (zone && number_logements && type_installation && surface) {
                    if (surface<35) return IndividualleBarTh125[version][zone] * 0.3;
                    if (surface<60 && surface>=35) return IndividualleBarTh125[version][zone] * 0.5;
                    if (surface<70 && surface>=60) return IndividualleBarTh125[version][zone] * 0.6;
                    if (surface<90 && surface>=70) return IndividualleBarTh125[version][zone] * 0.7;
                    if (surface<110 && surface>=90) return IndividualleBarTh125[version][zone] * 1;
                    if (surface<130 && surface>=110) return IndividualleBarTh125[version][zone] * 1.1;
                    if (surface>130) return IndividualleBarTh125[version][zone] * 1.6;
                } else
                    return 'Error: You need the Zone (H) and Surface values';
            }
        } else if (group == "BAR-TH-127") {
            // BAR-TH-127

            let r = 0;
            if (type_ventilation=='a') {
                if (type_installation=='collective' && type_caisson=='consommation') {
                    r = 0.96;
                    // return r;
                } else if (type_installation=='collective' && type_caisson=='standard') {
                    r = 0.91;
                } else if (type_installation=='collective' && type_caisson=='basse pression') {
                    r = 0.76;
                } else if (type_installation=='individuelle' && type_caisson=='consommation') {
                    r = 0.9;
                }
            } else {
                if (type_installation=='collective' && type_caisson=='consommation') {
                    r = 1;
                } else if (type_installation=='collective' && type_caisson=='standard') {
                    r = 0.95;
                } else if (type_installation=='collective' && type_caisson=='basse pression') {
                    r = 0.78;
                } else if (type_installation=='individuelle' && type_caisson=='consommation') {
                    r = 1;
                }
            }

            if (type_installation=='collective') {
                if (zone && number_logements && type_installation && type_ventilation) {
                    return CollectiveBarTh127[version][zone] * number_logements * r;
                } else
                    return 'Error: You need the' + ' Zone (H) and Surface values';
            } else {
                if (zone && number_logements && type_installation && surface) {
                    if (surface<35) return IndividualleBarTh127[version][zone] * 0.3 * r;
                    if (surface<60 && surface>=35) return IndividualleBarTh127[version][zone] * 0.5 * r;
                    if (surface<70 && surface>=60) return IndividualleBarTh127[version][zone] * 0.6 * r;
                    if (surface<90 && surface>=70) return IndividualleBarTh127[version][zone] * 0.7 * r;
                    if (surface<110 && surface>=90) return IndividualleBarTh127[version][zone] * 1 * r;
                    if (surface<130 && surface>=110) return IndividualleBarTh127[version][zone] * 1.1 * r;
                    if (surface>130) return IndividualleBarTh127[version][zone] * 1.6 * r;
                } else
                    return 'Error: You need the Zone (H) and Surface values';
            }
        } else if (group == "BAR-TH-129") {
            if (logement == 'appartement') {
                if (scop>3.8) {
                    if (zone == 'h1') {
                        if (surface < 35) return (0.5 * 21300);
                        else if (surface < 60 && surface >= 35) return (0.7 * 21300);
                        else if (surface < 70 && surface >= 60) return (1 * 21300);
                        else if (surface < 90 && surface >= 70) return (1.2 * 21300);
                        else if (surface < 110 && surface >= 90) return (1.5 * 21300);
                        else if (surface < 131 && surface >= 110) return (1.9 * 21300);
                        else if (surface > 130) return (2.5 * 21300);
                        else return 0;
                    } else if (zone == 'h2') {
                        // return surface;
                        if (surface < 35) return (0.5 * 17400);
                        else if (surface < 60 && surface >= 35) return (0.7 * 17400);
                        else if (surface < 70 && surface >= 60) return (1 * 17400);
                        else if (surface < 90 && surface >= 70) return (1.2 * 17400);
                        else if (surface < 110 && surface >= 90) return (1.5 * 17400);
                        else if (surface < 131 && surface >= 110) return (1.9 * 17400);
                        else if (surface > 130) return (2.5 * 17400);
                        else return 0;
                    } else if (zone == 'h3') {
                        if (surface < 35) return (0.5 * 11600);
                        else if (surface < 60 && surface >= 35) return (0.7 * 11600);
                        else if (surface < 70 && surface >= 60) return (1 * 11600);
                        else if (surface < 90 && surface >= 70) return (1.2 * 11600);
                        else if (surface < 110 && surface >= 90) return (1.5 * 11600);
                        else if (surface < 131 && surface >= 110) return (1.9 * 11600);
                        else if (surface > 130) return (2.5 * 11600);
                        else return 0;
                    }
                }
            } else if (logement == 'maison') {
                if (scop<4.23 && scop>3.8) {
                    if (zone=='h1') {
                        if (surface<35) return (0.3*77900);
                        else if (surface<60 && surface>=35) return (0.5*77900);
                        else if (surface<70 && surface>=60) return (0.6*77900);
                        else if (surface<90 && surface>=70) return (0.7*77900);
                        else if (surface<110 && surface>=90) return (1*77900);
                        else if (surface<131 && surface>=110) return (1.1*77900);
                        else if (surface>130)  return (1.6*77900);
                        else return 0;
                    } else if (zone=='h2') {
                        if (surface<35) return (0.3*63700);
                        else if (surface<60 && surface>=35) return (0.5*63700);
                        else if (surface<70 && surface>=60) return (0.6*63700);
                        else if (surface<90 && surface>=70) return (0.7*63700);
                        else if (surface<110 && surface>=90) return (1*63700);
                        else if (surface<131 && surface>=110) return (1.1*63700);
                        else if (surface>130)  return (1.6*63700);
                        else return 0;
                    } else if (zone=='h3') {
                        if (surface<35) return (0.3*42500);
                        else if (surface<60 && surface>=35) return (0.5*42500);
                        else if (surface<70 && surface>=60) return (0.6*42500);
                        else if (surface<90 && surface>=70) return (0.7*42500);
                        else if (surface<110 && surface>=90) return (1*42500);
                        else if (surface<131 && surface>=110) return (1.1*42500);
                        else if (surface>130)  return (1.6*42500);
                        else return 0;
                    }
                } else if (scop>4.2) {
                    if (zone=='h1') {
                        if (surface<35) return (0.3*80200);
                        else if (surface<60 && surface>=35) return (0.5*80200);
                        else if (surface<70 && surface>=60) return (0.6*80200);
                        else if (surface<90 && surface>=70) return (0.7*80200);
                        else if (surface<110 && surface>=90) return (1*80200);
                        else if (surface<131 && surface>=110) return (1.1*80200);
                        else if (surface>130)  return (1.6*80200);
                        else return 0;
                    } else if (zone=='h2') {
                        if (surface<35) return (0.3*65600);
                        else if (surface<60 && surface>=35) return (0.5*65600);
                        else if (surface<70 && surface>=60) return (0.6*65600);
                        else if (surface<90 && surface>=70) return (0.7*65600);
                        else if (surface<110 && surface>=90) return (1*65600);
                        else if (surface<131 && surface>=110) return (1.1*65600);
                        else if (surface>130)  return (1.6*65600);
                        else return 0;
                    } else if (zone=='h3') {
                        if (surface<35) return (0.3*43700);
                        else if (surface<60 && surface>=35) return (0.5*43700);
                        else if (surface<70 && surface>=60) return (0.6*43700);
                        else if (surface<90 && surface>=70) return (0.7*43700);
                        else if (surface<110 && surface>=90) return (1*43700);
                        else if (surface<131 && surface>=110) return (1.1*43700);
                        else if (surface>130)  return (1.6*43700);
                        else return 0;
                    }
                }
                return 0;
            }
        } else if (group == "BAT-TH-146") {
            // BAT-TH-146
            // return
            if (zone=='h1') return (longer_isole*4300)
            if (zone=='h2') return (longer_isole*4000)
            if (zone=='h3') return (longer_isole*3600)
        } else if (group == "RES-EC-104") {
            //RES-EC-104

            return (number_installes*9300);
        } else if (group == "BAT-EQ-133") {
            //BAT-EQ-133
            // return equipe_instale;
            if (equipe_instale=='pomme de douche-de-classe-z') {
                // return nombre_installations;
                if (secteur_d_activite=='hôtellerie et habitat communautaire') {
                    return (nombre_installations*1200);
                } else if (secteur_d_activite=='santé') {
                    return (nombre_installations*0.85*1200);
                } else if (secteur_d_activite=='etablissements sportifs') {
                    return (nombre_installations*4*1200);
                }
            } else if (equipe_instale=='pomme de douche-de-classe-zz') {
                if (secteur_d_activite=='hôtellerie et habitat communautaire') {
                    return (nombre_installations*2000);
                } else if (secteur_d_activite=='santé') {
                    return (nombre_installations*0.85*2000);
                } else if (secteur_d_activite=='etablissements sportifs') {
                    return (nombre_installations*4*2000);
                }
            } else if (equipe_instale=='aerateurs non regules-de-classe-z') {
                if (secteur_d_activite=='bureaux') {
                    return (nombre_installations*1.7*340);
                } else if (secteur_d_activite=='enseignement') {
                    return (nombre_installations*4.3*340);
                } else if (secteur_d_activite=='hôtellerie et habitat communautaire') {
                    return (nombre_installations*340);
                }else if (secteur_d_activite=='santé') {
                    return (nombre_installations*0.85*340);
                } else if (secteur_d_activite=='etablissements sportifs') {
                    return (nombre_installations*4*340);
                } else if (secteur_d_activite=='autres secteurs') {
                    return (nombre_installations*0.3*340);
                }
            } else if (equipe_instale=='aerateurs auto regules') {
                if (secteur_d_activite=='bureaux') {
                    return (nombre_installations*1.7*630);
                } else if (secteur_d_activite=='enseignement') {
                    return (nombre_installations*4.3*630);
                } else if (secteur_d_activite=='hôtellerie et habitat communautaire') {
                    return (nombre_installations*630);
                }else if (secteur_d_activite=='santé') {
                    return (nombre_installations*0.85*630);
                } else if (secteur_d_activite=='etablissements sportifs') {
                    return (nombre_installations*4*630);
                } else if (secteur_d_activite=='autres secteurs') {
                    return (nombre_installations*0.3*630);
                }
            }
            return 0;
        }
        return 'Error: not valid calculate';
    } else {
        return 'Error: We need the version';
    }
}

exports.getClimateZone = function (zipcode)
{
    zipcode = zipcode.substr(0,2);

    h1 = [ '01', '02', '03', '05', '08', '10', '14', '15', '19', '21', '23', '25', '27', '28', '38', '39', '42', '43', '45', '51', '52', '54', '55', '57', '58', '59', '60', '61', '62', '63', '67', '68', '69', '70', '71', '73', '74', '75', '76', '77', '78', '80', '87', '88', '89', '90', '91', '92', '93', '94', '95' ];
    h2 = [ '04', '07', '09', '12', '16', '17', '18', '22', '24', '26', '29', '31', '32', '33', '35', '36', '37', '40', '41', '44', '46', '47', '48', '49', '50', '53', '56', '64', '65', '72', '79', '81', '82', '84', '85', '86' ];
    h3 = [ '06', '11', '13', '20', '30', '34', '66', '83' ];

    if (h1.indexOf(zipcode) > -1) {
        zone_climatique = 'h1';
    } else if (h2.indexOf(zipcode) > -1) {
        zone_climatique = 'h2';
    } else if (h3.indexOf(zipcode) > -1) {
        zone_climatique = 'h3';
    } else {
        zone_climatique = '';
    }
    return zone_climatique;
}