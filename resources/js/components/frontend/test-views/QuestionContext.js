import React, {createContext, useEffect, useState} from 'react';
import {apiGet} from "../../utils/ConnectApi";

export const QuestionContext  = createContext();
export const QuestionProvider = (props) => {

    const [questions,setQuestions] = useState([]);
    const [loading,setLoading]     = useState(false);

    useEffect( () => {
        setLoading(true);
        apiGet('/test/get-questions').then( questions => {
            setQuestions(questions);
            setLoading(false);
        });
    },[]);

    return (
        <QuestionContext.Provider value={[questions,setQuestions,loading,setLoading]}>
            {props.children}
        </QuestionContext.Provider>
    );

}


