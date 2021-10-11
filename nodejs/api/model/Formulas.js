const mongoose = require('mongoose');
const ObjectId = mongoose.Schema.Types.ObjectId;
const Parameters = require('./Parameters.js');

const operator = {
    name: String,
    id_parameter: String,
    label: String,
    type: ['int','str','dbl','formula'],
    value: String
};

// {
//     type:mongoose.Schema.Parameters.ObjectId
// }

const Formulas = mongoose.Schema({
    version: String,
    group: String,
    formula: {
        operator: [
            {
                logic_operator: String,
                conditions: [{type:Object, value:operator}]
            }
        ],
        math_op:String
    }
});


module.exports = mongoose.model('Formulas', Formulas);
