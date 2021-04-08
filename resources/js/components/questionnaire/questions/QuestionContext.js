import React, {createContext, useEffect, useState} from 'react';
import {apiGet} from "../../utils/ConnectApi";

export const QuestionContext = createContext();

export const QuestionProvider = (props) => {
    const [questions,setQuestions] = useState([]);
    const [sectionId,setSectionId]  = useState(0);
    const [loadingQuestions,setLoadingQuestions] = useState(false);

    useEffect( () => {
        if (sectionId > 0){
            setLoadingQuestions(true);
            apiGet(`sections/${sectionId}/questionnaires`).then(questions => {
                if (questions && questions.length > 0){
                    setQuestions(questions);
                }
                setLoadingQuestions(false);
            });
        }
    },[sectionId]);


    return (
        <QuestionContext.Provider value={[questions,setQuestions,loadingQuestions,sectionId,setSectionId]}>
            {props.children}
        </QuestionContext.Provider>
    );

}

