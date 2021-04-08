import React, {Fragment} from 'react';
import Questionnaire from "./Questionnaire";
import {QuestionProvider} from "./QuestionContext";

class App extends Component {
    render() {
        return (
            <Fragment>
                <QuestionProvider>
                    <Questionnaire/>
                </QuestionProvider>
            </Fragment>
        );
    }
}

export default App;
