import React, {useEffect, useState} from 'react';
import Modal from '@material-ui/core/Modal';
import Backdrop from '@material-ui/core/Backdrop';
import Fade from '@material-ui/core/Fade';
import TextField from '@material-ui/core/TextField';
import useForm from "./useForm";
import validate from "./validateInfo";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faThumbsUp} from "@fortawesome/free-solid-svg-icons";


export default function GroupEditModal({open,handleClose,fillData}) {
    const handleSuccess = ($success = true) => {
        setSuccess($success);
    }
    const {values,handleChange,errors,handleSubmit,handleEdit,handleChangeEdit} = useForm(validate,handleSuccess,handleClose,fillData);
    const [success,setSuccess] = useState(false);



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
                }}
            >
                <Fade in={!!open}>
                    <div className="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div className="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div className="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                            <span className="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div className="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                                <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div className="sm:flex sm:items-start">

                                        <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 className="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Edit Group
                                            </h3>
                                            <div className={`inline-flex w-full overflow-hidden bg-gray-100 rounded-lg shadow-2xl my-2 ${ !success && 'hidden' } `}>
                                                <div className="flex items-center justify-content-center w-12 bg-green-500">
                                                    <FontAwesomeIcon icon={faThumbsUp} size="lg" className=" mx-auto flex-shrink-0 text-white"/>
                                                </div>
                                                <div className="px-3 py-2 text-left">
                                                    <span className="font-semibold text-green-500">Success</span>
                                                    <p className="mb-1 text-sm leading-none text-gray-500">Group Created successfully</p>
                                                </div>
                                            </div>
                                            <div className="mt-2">
                                                <form   noValidate autoComplete="off" onSubmit={ (e) => handleEdit(e,fillData.id)}>
                                                    <div className="grid grid-cols-2 gap-2.5 my-2">
                                                        <div>
                                                            <TextField  name="name" value={values.name}   margin="dense" error=""  label="Name" variant="outlined" onChange={  handleChangeEdit } />
                                                            <br/><small className={"text-red-400"}>{errors.name && errors.name}</small>
                                                        </div>

                                                        <div>
                                                            <TextField  name="icon" value={values.icon}  margin="dense" error=""  label="Icon" variant="outlined" onChange={handleChangeEdit}/>
                                                            <br/><small className={"text-danger"}>{errors.icon && errors.icon}</small>
                                                        </div>

                                                        <div>
                                                            <TextField  name="color"  value={values.color}  label="Color" margin="dense" error=""  variant="outlined" onChange={handleChangeEdit}  />
                                                            <br/><small className={"text-danger"}>{errors.color && errors.color}</small>
                                                        </div>

                                                        <div>
                                                            <TextField name="description" value={values.description} label="Description" margin="dense" error=""  multiline rows={4} variant="outlined" onChange={handleChangeEdit} />
                                                            <br/><small className={"text-danger"}>{errors.description && errors.descrition}</small>
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
