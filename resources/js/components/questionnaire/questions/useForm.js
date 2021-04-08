import React, {useState, useContext, useEffect} from "react";
import {SectionContext} from './SectionContext';
import { apiPost, apiUpdate} from "../../utils/ConnectApi";

const useForm = (validate,handleSuccess,handleClose,fillData) => {

    const [sections,setSections,,setSecGroupId] = useContext(SectionContext);

    const [values,setValues] = useState({
        question:'',
        weight_points:[],
        weight_point:20,
        remark:'',
        section_id:'',
        question_id:''
    });

    useEffect(()=>{
        fillData && setValues({
            question:fillData.question,
            weight_points:fillData.weight_points,
            weight_point:fillData.weight_point,
            remark:fillData.remark,
            section_id:fillData.section_id,
            question_id:fillData.question_id
        })
    },[fillData]);


    const [errors, setErrors] = useState({});

    const data = {
        question:values.question,
        weight_points:values.weight_points,
        weight_point:values.weight_point,
        remark:values.remark,
        section_id:values.section_id,
        question_id:values.question_id
    }
    const handleChange = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value.trim()})
    }

    const handleSelectChange = e => {
        setValues({group_id:e.target.value});
    }

    const handleChangeEdit = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value.trim()})
    }

    const handleSubmit = e =>{
        e.preventDefault();
        setErrors(validate(values));
        if (Object.keys(validate(values)).length <= 0)
        apiPost(data,'sections').then( () => {
            setSections([...sections,data]);
            setSecGroupId(data.group_id);
            handleSuccess();
            setTimeout(function (){
                handleClose();
            },1500)
        });
    }

    const handleEdit = (e,section_id) => {
        e.preventDefault();
        setErrors(validate(values));
        apiUpdate(data,`sections/${section_id}`).then( () => {

        });
    }

    return {values,handleChange,handleSelectChange,errors,handleSubmit,handleEdit,handleChangeEdit}
}

export default useForm;
