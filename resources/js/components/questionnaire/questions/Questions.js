import React, {Fragment,useContext} from 'react';
import {QuestionContext} from "./QuestionContext";
import QuestionPanel from "./QuestionPanel";

const Questions = () => {
    const [questions] = useContext(QuestionContext);
    return (
        <Fragment>
            {questions && questions.map( (question,index) => <QuestionPanel key={index} question={question} index={index}/> )}
        </Fragment>
    );

}

export default Questions;
