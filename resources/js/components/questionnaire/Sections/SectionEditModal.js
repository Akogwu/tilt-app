import React, {useContext, useEffect, useState} from 'react';
import Modal from '@material-ui/core/Modal';
import Backdrop from '@material-ui/core/Backdrop';
import Fade from '@material-ui/core/Fade';
import TextField from '@material-ui/core/TextField';
import useForm from "./useForm";
import validate from "./validateInfo";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faThumbsUp} from "@fortawesome/free-solid-svg-icons";
import MenuItem from "@material-ui/core/MenuItem";
import FormControl from "@material-ui/core/FormControl";
import InputLabel from "@material-ui/core/InputLabel";
import Select from "@material-ui/core/Select";
import {QuestionContext} from "../questions/QuestionContext";
import PropTypes from 'prop-types';



 function SectionEditModal({open,handleClose,fillData}) {
    const handleSuccess = ($success = true) => {
        setSuccess($success);
    }
    const {values,errors,handleEdit,handleChangeEdit,handleSelectChangeEdit} = useForm(validate,handleSuccess,handleClose,fillData);
    const [success,setSuccess] = useState(false);
    const [questions,,loadingQuestions,,setSectionId] = useContext(QuestionContext);
    const [recommendedId,setRecommendedId] = useState(0);

    useEffect( () => {
       fillData && setSectionId(fillData.id);
        fillData &&  setRecommendedId(fillData.recommendation_id??0);
    },[fillData]);


    return (
        <div>
            <Modal
                aria-labelledby="transition-modal-title"
                aria-describedby="transition-modal-description"
                open={!!open}
                onClose={handleClose}
                closeAfterTransition
                BackdropComponent={Backdrop}
                BackdropProps={{
                    timeout: 500,
                }}>
                <Fade in={!!open}>
                    <div className="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div className="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div className="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                            <span className="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div className="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                                <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div className="">

                                        <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 className="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Edit Section
                                            </h3>
                                            <div className={`inline-flex w-full overflow-hidden bg-gray-100 rounded-lg shadow-2xl my-2 ${ !success && 'hidden' } `}>
                                                <div className="flex items-center justify-content-center w-12 bg-green-500">
                                                    <FontAwesomeIcon icon={faThumbsUp} size="lg" className=" mx-auto flex-shrink-0 text-white"/>
                                                </div>
                                                <div className="px-3 py-2 text-left">
                                                    <span className="font-semibold text-green-500">Success</span>
                                                    <p className="mb-1 text-sm leading-none text-gray-500">Section Edited successfully</p>
                                                </div>
                                            </div>
                                            <div className="mt-2">
                                                <form   noValidate autoComplete="off" onSubmit={ (e) => handleEdit(e,fillData.id)}>
                                                    <div className="my-2">
                                                        <div className="my-4">
                                                            <TextField  name="name" value={values.name || ''}  fullWidth  margin="dense" error={errors.name && true}  label="Name"

                                                                        variant="outlined" onChange={  handleChangeEdit } />
                                                            <br/><small className={"text-red-400"}>{errors.name && errors.name}</small>
                                                        </div>

                                                        <div className="mb-4">
                                                            <FormControl variant="outlined" fullWidth style={{margin:0,display:"flex"}}>
                                                                <InputLabel id="select-group-label">Group</InputLabel>
                                                                <Select
                                                                    labelId="select-group-label"
                                                                    id="select-group"
                                                                    disabled
                                                                    value={values.group_id || ''}
                                                                    name="group_id"
                                                                    error={errors.group_id && true}
                                                                    label="Group">
                                                                    <MenuItem  value={values.group_id}>{values.group_name}</MenuItem>
                                                                </Select>
                                                            </FormControl>
                                                            <small className={"text-red-400"}>{errors.group_id && errors.group_id}</small>
                                                        </div>
                                                        <div className="mb-4">
                                                            <TextField name="description" value={values.description} fullWidth label="Description" margin="dense" error={errors.description && true}  multiline rows={4} variant="outlined" onChange={handleChangeEdit} />
                                                            <br/><small className={"text-red-400"}>{errors.description && errors.description}</small>
                                                        </div>

                                                        <div className="mb-4">
                                                            <FormControl variant="outlined" fullWidth style={{margin:0,display:"flex"}}>
                                                                <InputLabel id="select-group-label">Recommendation </InputLabel>
                                                                <Select
                                                                    labelId="select-group-label"
                                                                    id="select-group"
                                                                    value={values.recommendation}
                                                                    onChange={handleSelectChangeEdit}
                                                                    label="Recommendation"
                                                                    name="recommendation"
                                                                    error={errors.recommendation && true}
                                                                    fullWidth>
                                                                    {
                                                                        (loadingQuestions)? <MenuItem  selected={true}>Loading... please wait</MenuItem> : questions.map( (question,index) => <MenuItem key={index} selected={(question.id === recommendedId)}  value={question.id}>{question.question.substring(0,50)+'...'}</MenuItem>)
                                                                    }

                                                                </Select>
                                                            </FormControl>
                                                            <br/>
                                                            <small className={"text-red-400"}>{errors.recommendation && errors.recommendation}</small>
                                                        </div>

                                                    </div>
                                                    <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <button type="submit" className="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Submit
                                                        </button>
                                                        <button type="button" onClick={handleClose}  className="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </Fade>
            </Modal>
        </div>
    );
}

SectionEditModal.propTypes = {
    open:PropTypes.bool.isRequired,
    handleClose: PropTypes.func.isRequired,
    fillData:PropTypes.object.isRequired
}

export default SectionEditModal;
