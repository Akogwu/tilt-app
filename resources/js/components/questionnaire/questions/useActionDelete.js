import React, {useContext} from 'react';
import PropTypes from 'prop-types';
import {apiDelete} from "../../utils/ConnectApi";
import {QuestionContext} from "./QuestionContext";


const useActionDelete = (handleSuccess) => {
    const [questions,setQuestions] = useContext(QuestionContext);

    const handleDeleteModal = (question_id) => {
        apiDelete(`questionnaire/${question_id}`).then(() =>{
            setQuestions(questions.filter((question) => question.id !== question_id));
            //handleSuccess();
        });
    }

    return {handleDeleteModal}
}

useActionDelete.propTypes = {};

export default useActionDelete;
