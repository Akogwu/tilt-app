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

import "./assets/css/style.scss";
import "./assets/css/style.css";
import "./assets/css/mobile.css";
import { CheckReport } from "./pages/CheckReport";

function Index() {
    React.useEffect(() => {
        // alert("work")
    }, []);

    const history = useHistory();

    return (
        <Router history={history}>
            <Switch>
                <Route exact path="/result" component={Welcome} />
                <Route exact path="/result/report" component={Report} />
                <Route
                    exact
                    path="/result/check-report"
                    component={CheckReport}
                />
                <Route
                    exact
                    path="/result/detailed-report"
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
