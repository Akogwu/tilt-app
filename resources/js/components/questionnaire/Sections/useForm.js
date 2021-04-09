import React, {useState, useContext, useEffect} from "react";
import {SectionContext} from './SectionContext';
import {apiGet, apiPost, apiUpdate} from "../../utils/ConnectApi";

const useForm = (validate,handleSuccess,handleClose,fillData) => {

    const [sections,setSections,,secGroupId,setSecGroupId] = useContext(SectionContext);

    const [values,setValues] = useState({
        name:'',
        group_id:'',
        recommendation:'',
        description:''
    });

    useEffect(()=>{
        fillData && setValues({
            name: fillData.name,
            group_id: fillData.group_id,
            group_name:fillData.group_name,
            description: fillData.description,
            recommendation: fillData.recommendation_id
        })
    },[fillData]);


    const [errors, setErrors] = useState({});

    const data = {
        name:values.name,
        group_id:values.group_id,
        group_name:values.group_name,
        description:values.description,
        recommendation:values.recommendation
    }
    const handleChange = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value})
    }

    const handleSelectChange = e => {
        console.log(e.target.value);
        setValues({group_id:e.target.value});
    }

    const handleChangeEdit = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value})
    }

    const handleSelectChangeEdit = e => {
        setValues({recommendation:e.target.value});
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
                setValues({
                    name: '',group_id: '',description: ''
                })
                handleSuccess(false);
            },1500)
        });
    }

    const handleEdit = (e,section_id) => {
        e.preventDefault();
        setErrors(validate(values));
        apiUpdate(data,`sections/${section_id}`).then( () => {
            handleSuccess();
            apiGet(`groups/${secGroupId}/sections`).then(sections => {
                setSections(sections);
            });
            setTimeout(function (){
                handleClose();
                setValues({
                    name: '',group_id: '',description: ''
                })
                handleSuccess(false);
            },1500)
        });
    }

    return {values,setValues,handleChange,handleSelectChange,errors,handleSubmit,handleEdit,handleChangeEdit,handleSelectChangeEdit}
}

export default useForm;
