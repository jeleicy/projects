import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './components/App';
import Formula from './components/Formula';
// import reportWebVitals from './reportWebVitals';
import {Route, Switch, Router, BrowserRouter, useHistory, Link} from "react-router-dom";

const routingRoutes = (
    <BrowserRouter>
        <Switch>
            <Route path="/Formula/:id" component={Formula} />
            <Route path="/" component={App} />
        </Switch>
    </BrowserRouter>
)

const routing = (
    <React.StrictMode>
        <App />
    </React.StrictMode>
)

ReactDOM.render(
    routingRoutes,
    document.getElementById('root')
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
// reportWebVitals();
