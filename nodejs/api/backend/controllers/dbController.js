const Formulas = require('../model/Formulas.js');

const getAllFormulas = async (req, res) => {
	let collectionFormulas = findCollection(req, res, {});
}

async function findCollection(req, res, query) {
	try {
		let id = req.body.id;
		const result = await Formulas.find({})
		const collection = {...result};
		// console.log('::: collection ::: ',collection[0]);
		const formula = collection[0].formula;
		const operators = formula.operator;
		console.log('++++++++++++ ::: id ::: +++++++++++++ = ',id);
		res.status(200).json(collection)
	} catch (err) {
		res.status(500).json({message: err.message})
	}
}

module.exports = {getAllFormulas};