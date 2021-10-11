const mongoose = require('mongoose');
const ObjectId = mongoose.Schema.Types.ObjectId;

const Parameters = mongoose.Schema({
    name: String,
    slug: String,
    type: String
});

module.exports = mongoose.model('Parameters', Parameters);
