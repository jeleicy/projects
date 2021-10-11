import React from 'react';
import { BrowserRouter, Link, Route, Switch } from 'react-router-dom';
import '../App.css';

import Manatee from './Manatee';

function Test() {
    return (
        <div className="wrapper">
            <BrowserRouter>
                <nav>
                    <ul>
                        <li>1) <Link to="/manatee/25">Beluga Whale</Link></li>
                        <li>2) <Link to="/manatee/32">Blue Whale</Link></li>
                    </ul>
                </nav>
                <Switch>
                    <Route exact path="/manatee">
                        <Manatee />
                    </Route>
                    <Route path="/manatee/:id">
                        <Manatee />
                    </Route>
                </Switch>
            </BrowserRouter>
        </div>
    );
}

export default Test;