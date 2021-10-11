const mongoose = require('mongoose');

module.exports = {
    connectTo: function (database = 'cumac', host = 'localhost:27017') {
        return mongoose.connect(`mongodb://${host}/${database}`)
            .then(conn => console.log(`Connected to MongoDB - Server:127.0.0.1 DB:${database}`))
            .catch(err => console.log('error :::: ' + err));
    },
};