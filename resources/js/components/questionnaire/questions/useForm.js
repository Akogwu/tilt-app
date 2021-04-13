import React, {useState, useContext, useEffect} from "react";

import {apiGet, apiPost, apiUpdate} from "../../utils/ConnectApi";
import {QuestionContext} from "./QuestionContext";

const useForm = (validate,handleSuccess,handleClose,question) => {

    const [questions,setQuestions,loadingQuestions,sectionId,setSectionId] = useContext(QuestionContext);
    const [loading, setLoading] = useState(false);

    const [weightPoints] = useState([
        { weight_point : 20,  remark : "Poor  result"},
        { weight_point : 40,  remark : "Fairly good result"},
        { weight_point : 60,  remark : "Good result"},
        { weight_point : 80,  remark : "Excellent result"},
        { weight_point : 100,  remark : "Perfect result"},
    ]);

    const [state,setState] = useState({
        question:'',
        weight_points:[],
        weight_point:20,
        remark:'',
        section_id:'',
        question_id:''
    });

    useEffect(()=>{
        let initial_point = 20;
        question && setState({...state,
            question: question.question,
            weight_points:question.weight_points,
            remark: question.weight_points.find( current_point => current_point.weight_point === initial_point ).remark,
            section_id: question.section_id,
            question_id: question.id
        });
    },[question]);


    const [errors, setErrors] = useState({});

    const data = {
        question:state.question,
        weight_point:state.weight_points,
        remark:state.remark,
        section_id:state.section_id,
        question_id:state.question_id
    }

    const newData = {
        question:state.question,
        weight_point:weightPoints,
        section_id:sectionId
    }

    const handleChanges = e => {
        const {name,value} = e.target;
        setState({...state,[name]:value})
    }

    const handleChangeRemark = e => {
        const score = parseInt(e.target.value);
        let scoreObj = state.weight_points.find(current_score => current_score.weight_point === score);
        setState({...state,weight_point:scoreObj.weight_point,remark:scoreObj.remark});
    }


    const handleAddRemark = () => {
        let setData = {};
        setData.weight_point = state.weight_point;
        setData.remark       = state.remark;
        let index = state.weight_points.findIndex( obj => obj.weight_point === setData.weight_point);
        state.weight_points[index].remark = setData.remark;
    };



    const handleSubmit = e =>{
        e.preventDefault();
        setErrors(validate(state));

        if (Object.keys(validate(state)).length <= 0){
            console.log(newData);
            setLoading(true);
            apiPost(newData,'questionnaire').then( () => {
                apiGet(`sections/${sectionId}/questionnaires`).then( questions => {
                    setQuestions(questions);
                });
                handleSuccess();
                setTimeout(function (){
                    setLoading(false);
                    handleClose();
                },1500)
            });
        }

    }

    const handleUpdateQuestion = async e => {
        e.preventDefault();
        setErrors(validate(state));
        if (Object.keys(validate(state)).length <= 0)
            setLoading(true);
        await apiUpdate(data,`questionnaire/${state.question_id}`).then( () => {
            setLoading(false);
            handleSuccess();
            setSectionId(state.section_id);
        })
    };

    const handleEdit = (e,section_id) => {
        e.preventDefault();
        setErrors(validate(values));
        apiUpdate(data,`sections/${section_id}`).then( () => {

        });
    }

    return {state,handleChanges,handleChangeRemark,handleAddRemark,handleUpdateQuestion,errors,handleSubmit,loading}
}

export default useForm;
