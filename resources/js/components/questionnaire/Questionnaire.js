import React, {useContext, useState,Fragment} from 'react';
import App from "./App";
import ReactDOM from "react-dom";
import {GroupProvider} from "./Groups/GroupContext";
import {SectionProvider} from "./Sections/SectionContext";
import {QuestionProvider} from "./questions/QuestionContext";



const Questionnaire = ()  => {

    return (
        <Fragment>
            <GroupProvider>
                <SectionProvider>
                    <QuestionProvider>
                        <App/>
                    </QuestionProvider>
                </SectionProvider>
            </GroupProvider>
        </Fragment>
    );

}

Questionnaire.propTypes = {};
export default Questionnaire;
if (document.getElementById('questionnaire-component')) {
    ReactDOM.render(<Questionnaire />, document.getElementById('questionnaire-component'));
}
