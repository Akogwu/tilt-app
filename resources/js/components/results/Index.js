import React from "react";
import ReactDOM from "react-dom";
import {
    BrowserRouter as Router,
    Route,
    Switch,
    Redirect,
    Link,
    useHistory,
} from "react-router-dom";
import { Welcome } from "./pages/Welcome";
import { Report } from "./pages/Report";
import { DetailedReport } from "./pages/DetailedReport";

import "./assets/css/style.css";
import "./assets/css/mobile.css";
import { CheckReport } from "./pages/CheckReport";

function Index() {

    const history = useHistory();

    return (
        <Router history={history}>
            <Switch>
                <Route exact path="/result/:sessionId/home" component={Welcome} />
                <Route exact path="/result/:sessionId/report" component={Report} />
                <Route
                    exact
                    path="/result/:sessionId/check-report"
                    component={CheckReport}
                />
                <Route
                    exact
                    path="/result/:sessionId/detailed-report"
                    component={DetailedReport}
                />
            </Switch>
        </Router>
    );
}

export default Index;

if (document.getElementById("result-root")) {
    ReactDOM.render(<Index />, document.getElementById("result-root"));
}
