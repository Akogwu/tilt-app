import React, {Component} from 'react';
import Dashboard from "./Dashboard";
import ReactDOM from "react-dom";

class App extends Component {
    render() {
        return (
            <div>
                <Dashboard/>
            </div>
        );
    }
}

export default App;
if (document.getElementById('profile-component')) {
    ReactDOM.render(<App />, document.getElementById('profile-component'));
}
