import React, {useState, useContext, useEffect} from "react";
import {GroupContext} from './GroupContext';
import {postGroup,updateGroup,getGroups} from './GroupApi';
import {apiGet, apiPost, apiUpdate} from "../../utils/ConnectApi";

const useForm = (validate,handleSuccess,handleClose,fillData) => {

    const [groups,setGroups] = useContext(GroupContext);
    const [errors, setErrors] = useState({});
    const [values,setValues] = useState({
        name:'',
        color:'',
        icon:'',
        description:'',
        graph_description:'',
        resource:''
    });
    const [graph_overviewValue, setGraphOverviewValue] = useState({
        id:'',
        description: ''
    });

    useEffect(()=>{
        fillData && setValues({
            name: fillData.name,
            color: fillData.color,
            icon: fillData.icon,
            description: fillData.description,
            graph_description: fillData.graph_description,
            resource:fillData.resource
        })
    },[fillData]);

    // useEffect(()=>{
    //     graphOverview && setGraphOverviewValue({
    //         id:graphOverview.id,
    //         description: graphOverview.description
    //     })
    // },[graphOverview]);

    const data = {
        name:values.name,
        color:values.color,
        icon:values.icon,
        description:values.description,
        graph_description:values.graph_description,
        resource:values.resource

    }

    const handleChange = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value})
    }
    const handleChangeEdit = e => {
        const {name,value} = e.target;
        setValues({...values,[name]:value})
    }
    const handleChangeOverview = e => {
        const {name,value} = e.target;
        setGraphOverviewValue({...graph_overviewValue,[name]:value})

    }

    const handleResourceChangeEdit = value => {
        setValues({...values,['resource']:value})
    }

    const handleClear = () => {
        setGraphOverviewValue({...graph_overviewValue,['description']:''})
    }

    const handleSubmit = e =>{
        e.preventDefault();
        setErrors(validate(values));
        if (Object.keys(validate(values)).length <= 0)
        apiPost(data,`groups`).then(() => {
            setGroups([...groups,data]);
            handleSuccess();
            setTimeout(function (){
                handleClose();
                setValues({
                    name: '',
                    color: '',
                    icon: '',
                    description: '',
                    graph_description:'',
                    resource:''
                })
                handleSuccess(false);
            },1500)

        });
    }

    const handleEdit = (e,group_id) => {
        e.preventDefault();
        setErrors(validate(values));
        if (Object.keys(validate(values)).length <= 0)
        apiUpdate(data,`groups/${group_id}`).then(res => {
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

    // const graphOverview = {
    //     id:
    // };

    const handleOverviewEdit = (e,overview_id) => {
        e.preventDefault();

        //setErrors(validate(graph_overviewValue));
        //if (Object.keys(validate(graph_overviewValue)).length <= 0)
        apiPost(graph_overviewValue,`graph-overviews`).then(res => {
                apiGet('graph-overviews').then(overview => {
                    setGraphOverviewValue(overview);

                    handleSuccess();
                    setTimeout(function (){
                        //handleClose();

                        handleSuccess(false);
                    },1500)

                });
            });
    }

    return {values,handleChange,errors,handleSubmit,handleEdit,handleChangeEdit,
        handleResourceChangeEdit,handleOverviewEdit ,handleChangeOverview,
        handleClear,graph_overviewValue,setGraphOverviewValue}
}

export default useForm;
