require("dotenv").config();
const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const port = process.env.PORT;
const fs = require('fs');
const calculateRoutes = require('./routes/calculateRoutes');
const server = express();
const db = require('./model/db.js');

db
    .connectTo('Calculate')
    .then(() => console.log('\n... *** API Connected to Database ...\n'))
    .catch(err => console.log('\n*** ERROR Connecting to Database ***\n', err));

server.use(bodyParser.json());
server.use(cors());
server.use('/', calculateRoutes);

// server.use('/v1', calculateRoutes);
// server.use('/get_all_formulas', calculateRoutes);

server.listen(port, err => {
    if (err)
        console.log('errr = ' + err);
    else
        console.log(`server is listening on port ${port}`);
});
