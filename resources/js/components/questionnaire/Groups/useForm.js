import React, {useState, useContext, useEffect} from "react";
import {GroupContext} from './GroupContext';
import {postGroup,updateGroup,getGroups} from './GroupApi';
import {apiGet} from "../../utils/ConnectApi";

const useForm = (validate,handleSuccess,handleClose,fillData) => {

    const [groups,setGroups] = useContext(GroupContext);
    const [errors, setErrors] = useState({});
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


    const data = {
        name:values.name,
        color:values.color,
        icon:values.icon,
        description:values.description
    }
    const handleChange = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value})
    }
    const handleChangeEdit = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value})
    }

    const handleSubmit = e =>{
        e.preventDefault();
        setErrors(validate(values));
        if (Object.keys(validate(values)).length <= 0)
        postGroup(data).then(() => {
            setGroups([...groups,data]);
            handleSuccess();
            setTimeout(function (){
                handleClose();
                setValues({
                    name: '',
                    color: '',
                    icon: '',
                    description: ''
                })
                handleSuccess(false);
            },1500)

        });

    }

    const handleEdit = (e,group_id) => {
        e.preventDefault();
        setErrors(validate(values));
        if (Object.keys(validate(values)).length <= 0)
        updateGroup(data,group_id).then(res => {
            apiGet('groups').then(groups => {
              setGroups(groups);

                handleSuccess();
                setTimeout(function (){
                    handleClose();

                    handleSuccess(false);
                },1500)

            });
        });
    }

    return {values,handleChange,errors,handleSubmit,handleEdit,handleChangeEdit}
}

export default useForm;
