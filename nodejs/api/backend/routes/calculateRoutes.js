const express = require('express');

const calculateController = require('../controllers/calculateController');
const dbController = require('../controllers/dbController');
// var app = express()

let appRouter = express.Router();

// EndPoint: /calculate/v1
appRouter.route('/v1').post(calculateController.calculatecalculate)
appRouter.route('/get_all_formulas').get(dbController.getAllFormulas)
appRouter.route('/get_all_formulas').post(dbController.getAllFormulas)

// appRouter.route('/get_all_formulas').post(function (req, res) {res.end(dbController.getAllFormulas(req, res));})

// appRouter.route('').post(calculateController.calculatecalculate);

//
// appRouter.route('/mongo-db')
//     .all(function (req, res) {
//         res.end(calculateController.mongoInsert(req, res));
//     })
appRouter.route('/*').all(function (req, res) {res.end('Error: Bad request')})

module.exports = appRouter;
