const express = require('express');

const cumacController = require('../controllers/cumacController');

let appRouter = express.Router();

// EndPoint: /cumac/v1
appRouter.route('/v1').post(function (req, res) {res.end(cumacController.calculateCumac(req,res));})

appRouter.route('').post(cumacController.calculateCumac);

// appRouter.route('/mongo-connect')
//     .post(function (req, res) {
//         db
//             .connectTo('cumac')
//             .then(() => console.log('\n... API Connected to Database ...\n'))
//             .catch(err => console.log('\n*** ERROR Connecting to Database ***\n', err));
//     })
//
// appRouter.route('/mongo-db')
//     .all(function (req, res) {
//         res.end(cumacController.mongoInsert(req, res));
//     })

appRouter.route('/*').all(function (req, res) {res.end('Error: Bad request')})

module.exports = appRouter;
