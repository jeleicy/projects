const calculateModel = require('../model/calculateModel');
const Formulas = require('../model/Formulas.js');
// mongoose.Promise = require('bluebird');

/**
 * Get the data from given calculate value
 */
const calculatecalculate = async (req, res) => {
	let group = req.body.group;
	let chauffage = req.body.chauffage;
	let zipcode = req.body.zipcode;
	let situation = req.body.situation;
	let surface = req.body.surface;
	let longer_isole = req.body.longer_isole;
	let efficacite = req.body.efficacite;
	let type = req.body.type;
	let logement = req.body.logement;
	let version = req.body.version;
	let number_logements = req.body.number_logements;
	let type_installation = req.body.type_installation;
	let type_ventilation = req.body.type_ventilation;
	let type_caisson = req.body.type_caisson;
	let scop = req.body.scop;
	let number_installes = req.body.number_installes;
	let secteur_d_activite = req.body.secteur_d_activite;
	let equipe_instale = req.body.equipe_instale;
	let nombre_installations = req.body.nombre_installations;

	number_installes = nombre_installations;

	let calculateValue = 0;

	if (number_logements) number_logements = number_logements.replace('.',',');
	else number_logements=0;

	if (chauffage) { chauffage = slugyConvert(chauffage.toLowerCase()); }

	let zone = calculateModel.getClimateZone(zipcode);
	if (situation) {
		situation = slugyConvert(situation.toLowerCase());
	} else {
		situation = '';
	}

	if (nombre_installations) {
		nombre_installations = slugyConvert(nombre_installations.toLowerCase());
		nombre_installations = nombre_installations.replace('-',' ');
		nombre_installations = nombre_installations.replace('_',' ');
	} else {
		nombre_installations = 0;
	}

	if (equipe_instale) {
		equipe_instale = slugyConvert(equipe_instale.toLowerCase());
		equipe_instale = equipe_instale.replace('-',' ');
		equipe_instale = equipe_instale.replace('_',' ');
	} else {
		equipe_instale=0;
	}

	calculateValue = calculateModel.getcalculateValues(res, req, group,chauffage,zone,situation,surface,longer_isole,efficacite,type,logement,version,number_logements,type_installation,type_ventilation, type_caisson,scop,number_installes,secteur_d_activite,equipe_instale,nombre_installations);

	if (situation=='tres_modestes') {
		calculateValue = calculateValue*2;
	}
	
	res.status(200).send({result:calculateValue});
	// calculateValue = getcalculateValues_new(res, req, group,chauffage,zone,situation,surface,longer_isole,efficacite,type,logement,version,number_logements,type_installation,type_ventilation, type_caisson);
};

async function getcalculateValues_new (res, req, group= null,chauffage= null,zone= null,situation= null,surface= null,longer_isole= null,efficacite= null,type= null,logement= null, version = null,number_logements=null,type_installation=null, type_ventilation=null, type_caisson=null) {
	try {
		const result = await Formulas.find({group:group, version:version})
		const collection = {...result};
		// console.log('::: collection ::: ',collection[0]);
		const formula = collection[0].formula;
		const operators = formula.operator;
		// console.log('++++++++++++ formula +++++++++++++ = ',formula);
		// console.log('++++++++++++ formula.math_op +++++++++++++ = ',formula.math_op);
		if (formula.math_op) {
			math_op = formula.math_op;
			// console.log('math_op = ',math_op);
			if (math_op=='sum') math_op='+';
			if (math_op=='minus') math_op='-';
			if (math_op=='multiply') math_op='*';
			if (math_op=='divide') math_op='/';
			// console.log('++++++++++++ formula.math_op +++++++++++++ = ',formula.math_op);
		}

		let logic_operator = '';
		let evalOperator = '';
		let condObj = '';
		let conditions = '';
		let rescalculate = new Array();
		let i=0;
		rescalculate = [];
		for (evalOperator of operators) {
			// console.log(' :: evalOperator :: ',evalOperator);
			logic_operator = evalOperator.logic_operator;
			conditions = evalOperator.conditions;
			// console.log(' ****** outside a loop ****** ');
			rescalculate[i] = evalOperations(conditions, i, group ,chauffage,zone,situation,surface,longer_isole,efficacite,type,logement, version ,number_logements,type_installation, type_ventilation, type_caisson);
			// console.log('evalValues['+i+'] = ',rescalculate);
			i++;
			if (math_op!='') {
				rescalculate[i] = math_op;
				i++;
			}
		}

		// console.log('rescalculate.length = ',rescalculate.length);
		evalValues = '';
		for (i=0;i<rescalculate.length;i++) {
			if (rescalculate.length>1 && (i<rescalculate.length-1)) {
				evalValues+=' ' + rescalculate[i];
				// console.log('1) evalValues = '+evalValues);
			} else if (rescalculate.length==1) {
				evalValues+=' ' + rescalculate[i];
				// console.log('2) evalValues = '+evalValues);
			}
		}
		// console.log('evalValues result part 1 ');
		console.log('evalValues result = '+eval(evalValues));
		let calculateValue = eval(evalValues);
		console.log("calculate model value *** = ",calculateValue);
		// res.status(200).send({calculate:calculateValue});

		res.status(200).json({v1:calculateValue})

		// res.json('calculate = ',calculateValue)
	} catch (err) {
		res.status(500).json({message: err.message})
	}

	// *********************************************

	// Formulas.find({group:group, version:version})
	// 	.populate('formulas').exec()
	// 	.then(result => {
	// 		let evalValues = '';
	// 		let math_op = '';
	// 		const collection = {...result};
	// 		// console.log('::: collection ::: ',collection[0]);
	// 		const formula = collection[0].formula;
	// 		const operators = formula.operator;
	// 		// console.log('++++++++++++ formula.operator +++++++++++++ = ',formula.operator);
	// 		// console.log('++++++++++++ formula.math_op +++++++++++++ = ',formula.math_op);
	// 		if (formula.math_op) {
	// 			math_op = formula.math_op;
	// 			// console.log('math_op = ',math_op);
	// 			if (math_op=='sum') math_op='+';
	// 			if (math_op=='minus') math_op='-';
	// 			if (math_op=='multiply') math_op='*';
	// 			if (math_op=='divide') math_op='/';
	// 			// console.log('++++++++++++ formula.math_op +++++++++++++ = ',formula.math_op);
	// 		}
	//
	// 		let logic_operator = '';
	// 		let evalOperator = '';
	// 		let condObj = '';
	// 		let conditions = '';
	// 		let rescalculate = new Array();
	// 		let i=0;
	// 		rescalculate = [];
	// 		for (evalOperator of operators) {
	// 			// console.log(' :: evalOperator :: ',evalOperator);
	// 			logic_operator = evalOperator.logic_operator;
	// 			conditions = evalOperator.conditions;
	// 			// console.log(' ****** outside a loop ****** ');
	// 			rescalculate[i] = evalOperations(conditions, i, group ,chauffage,zone,situation,surface,longer_isole,efficacite,type,logement, version ,number_logements,type_installation, type_ventilation, type_caisson);
	// 			// console.log('evalValues['+i+'] = ',rescalculate);
	// 			i++;
	// 			if (math_op!='') {
	// 				rescalculate[i] = math_op;
	// 				i++;
	// 			}
	// 		}
	//
	// 		// console.log('rescalculate.length = ',rescalculate.length);
	// 		evalValues = '';
	// 		for (i=0;i<rescalculate.length;i++) {
	// 			if (rescalculate.length>1 && (i<rescalculate.length-1)) {
	// 				evalValues+=' ' + rescalculate[i];
	// 				// console.log('1) evalValues = '+evalValues);
	// 			} else if (rescalculate.length==1) {
	// 				evalValues+=' ' + rescalculate[i];
	// 				// console.log('2) evalValues = '+evalValues);
	// 			}
	// 		}
	// 		// console.log('evalValues result part 1 ');
	// 		// console.log('evalValues result = '+eval(evalValues));
	// 		// let calculateValue = eval(evalValues);
	// 		console.log("calculate model value = ",calculateValue);
	// 		res.status(200).send({calculate:calculateValue});
	// 	}).catch(error => {
	// 		res.status(500).send({error: 'Something went wrong! = ',error});
	// 	});
}

function evalOperations(conditions, i, group ,chauffage,zone,situation,surface,longer_isole,efficacite,type,logement, version ,number_logements,type_installation, type_ventilation, type_caisson) {
	// console.log(i + ' ::: conditions ::: ',conditions);
	var result = 0;
	var enter_loop=0;

	if (conditions.length>0) {
		for (condObj of conditions) {
			enter_loop++;
			// console.log(' ****** into a loop ****** ');

			let name = condObj.name;
			let label = condObj.label;
			let type = condObj.type;
			let value = condObj.value;
			let evalFormula = '';

			// console.log('evalOperations :: type = ', type);

			if (type != 'formula') {
				evalFormula = name + '=="' + label + '"';
				// console.log('evalFormula = ', evalFormula, '..... eval the formula = ', eval(evalFormula));
				if (eval(evalFormula) || value.toLowerCase() == 'x') {
					if (value.toLowerCase() == 'x') {
						eval('label = ' + condObj.label + ';');
						value = label;
					}
					// console.log('value from loop = ', value);
					return value;
				}
			} else {
				// console.log('::: evalFormula again :::');
				i++;
				return evalOperations(value, i, group, chauffage, zone, situation, surface, longer_isole, efficacite, type, logement, version, number_logements, type_installation, type_ventilation, type_caisson);
			}
		}
	}

	// console.log(' ### enter_loop : '+enter_loop+' ###');
	if (enter_loop==0) {
		// console.log('===== conditions with enter_loop = ',conditions);
		// let condObj = JSON.parse(conditions);
		let condObj = conditions;
		let name = condObj.name;
		let label = condObj.label;
		let type = condObj.type;
		let value = condObj.value;
		let evalFormula = '';

		evalFormula = name + '=="' + label + '"';
		// console.log('evalFormula = ', evalFormula, '..... eval the formula = ', eval(evalFormula));
		if (eval(evalFormula) || value.toLowerCase() == 'x') {
			if (value.toLowerCase() == 'x') {
				eval('label = ' + condObj.label + ';');
				// console.log('$$$$$ ' + 'let label = ' + condObj.label + ';');
				value = label;
			}
			return value;
		}
	}
	return result;
}

function slugyConvert(str) {
	str = str.replace(/^\s+|\s+$/g, ''); // trim
	str = str.toLowerCase();
	// remove accents, swap ñ for n, etc
	var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
	var to   = "aaaaaeeeeeiiiiooooouuuunc------";
	for (var i=0, l=from.length ; i<l ; i++) {
		str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}
	str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		.replace(/\s+/g, '-') // co
		// llapse whitespace and replace by -
		.replace(/-+/g, '-'); // collapse dashes
	str = str.replace('-','_');
	return str;
}

module.exports = {calculatecalculate};