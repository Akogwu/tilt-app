import React, {Fragment,useContext} from 'react';
import {QuestionContext} from "./QuestionContext";
import QuestionPanel from "./QuestionPanel";
import ContentLoader from "react-content-loader";

const Questions = () => {
    const [questions,,loadingQuestions] = useContext(QuestionContext);

    const MyLoader = (props) => (

        <ContentLoader
            speed={2}
            width={564}
            height={230}
            viewBox="0 0 476 230"
            backgroundColor="#f3f3f3"
            foregroundColor="#ecebeb"
            {...props}
        >
            <rect x="0" y="56" rx="3" ry="3" width="410" height="6" />
            <rect x="0" y="72" rx="3" ry="3" width="380" height="6" />
            <rect x="1" y="9" rx="0" ry="0" width="407" height="38" />
            <rect x="1" y="146" rx="3" ry="3" width="410" height="6" />
            <rect x="1" y="162" rx="3" ry="3" width="380" height="6" />
            <rect x="2" y="99" rx="0" ry="0" width="407" height="38" />
            <rect x="-1" y="247" rx="3" ry="3" width="380" height="6" />
            <rect x="0" y="184" rx="0" ry="0" width="407" height="38" />
        </ContentLoader>



    )

    return (
        <Fragment>
            {loadingQuestions? <MyLoader/> : questions.map( (question,index) => <QuestionPanel key={index} question={question} index={index}/> )}
        </Fragment>
    );

}

export default Questions;
