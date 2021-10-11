require("dotenv").config();
const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const port = process.env.PORT;
const fs = require('fs');
const cumacRoutes = require('./routes/cumacRoutes');
const server = express();
const db = require('./model/db.js');

db
    .connectTo('cumac')
    .then(() => console.log('\n... API Connected to Database ...\n'))
    .catch(err => console.log('\n*** ERROR Connecting to Database ***\n', err));

server.use(bodyParser.json());
server.use(cors());

server.use('/v1', cumacRoutes);

server.listen(port, err => {
    if (err)
        console.log('errr = ' + err);
    else
        console.log(`server is listening on port ${port}`);
});
