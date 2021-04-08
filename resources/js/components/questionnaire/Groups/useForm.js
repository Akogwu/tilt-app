import React, {useState, useContext, useEffect} from "react";
import {GroupContext} from './GroupContext';
import {postGroup,updateGroup,getGroups} from './GroupApi';
import {apiGet} from "../../utils/ConnectApi";

const useForm = (validate,handleSuccess,handleClose,fillData) => {

    const [groups,setGroups] = useContext(GroupContext);

    const [values,setValues] = useState({
        name:'',
        color:'',
        icon:'',
        description:''
    });

    useEffect(()=>{
        fillData && setValues({
            name: fillData.name,
            color: fillData.color,
            icon: fillData.icon,
            description: fillData.description
        })
    },[fillData]);


    const [errors, setErrors] = useState({});

    const data = {
        name:values.name,
        color:values.color,
        icon:values.icon,
        description:values.description
    }
    const handleChange = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value.trim()})
    }
    const handleChangeEdit = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value.trim()})
    }

    const handleSubmit = e =>{
        e.preventDefault();
        setErrors(validate(values));
        postGroup(data).then(() => {
            setGroups([...groups,data]);
            handleSuccess();
            setTimeout(function (){
                handleClose();
            },1500)
        });

    }

    const handleEdit = (e,group_id) => {
        e.preventDefault();
        setErrors(validate(values));
        updateGroup(data,group_id).then(res => {
            apiGet('groups').then(res => {
               setGroups([res.data]);
            });
        });
    }

    return {values,handleChange,errors,handleSubmit,handleEdit,handleChangeEdit}
}

export default useForm;
