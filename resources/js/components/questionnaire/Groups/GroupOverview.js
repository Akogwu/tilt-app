import React, {useContext, useEffect, useState} from "react";
import TextField from "@material-ui/core/TextField";
import useForm from "./useForm";
import validate from "./validateInfo";
import {GroupContext} from "./GroupContext";

export default function GroupOverview({
                                        open,
                                        handleClose,
                                        overviewData,
                                    }) {
    const handleSuccess = ($success = true) => {
        setSuccess($success);
    };

    const {
        values,
        overviewValue,
        handleChange,
        errors,
        handleSubmit,
        handleEdit,
        handleChangeEdit,
        handleResourceChangeEdit,
        handleChangeOverview,
        handleOverviewEdit,
        handleClear,
    } = useForm(validate, handleSuccess, handleClose, overviewData);
    const [success, setSuccess] = useState(false);

    return (
        <div>
            <div className="mt-2 text-center">
                <div className="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        {/*<div className="sm:flex sm:items-start">*/}
                        {/*<div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">*/}
                        <form
                            noValidate
                            autoComplete="off"
                            onSubmit={(e) =>
                                handleOverviewEdit(
                                    e,
                                    overviewData.id
                                )
                            }
                        >

                            <div className="grid grid-cols-1 gap-2.5 my-2">
                                <div>
                                    {/*<label style={{color:'#989898',fontSize:'18px'}}>Overview</label>*/}
                                    <TextField
                                        fullWidth
                                        name="description"
                                        value={
                                            overviewValue.description
                                        }
                                        label="Overview"
                                        margin="dense"
                                        error=""
                                        multiline
                                        rows={6}
                                        variant="outlined"
                                        onChange={
                                            handleChangeOverview
                                        }
                                    />
                                    <br/>
                                    <small
                                        className={
                                            "text-danger"
                                        }
                                    >
                                        {errors.description &&
                                        errors.descrition}
                                    </small>
                                </div>
                            </div>

                            <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button
                                    type="submit"
                                    className="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm"
                                >
                                    Submit
                                </button>
                                <button
                                    type="button"
                                    onClick={
                                        handleClear
                                    }
                                    className="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                >
                                    Clear
                                </button>
                            </div>
                        </form>
                        <div className="grid grid-cols-1 gap-2.5 my-2">
                            {/* Group Resources */}
                            {/* <GroupResources group_id = {group_id} /> */}
                        </div>
                    </div>
                    {/*</div>*/}
                    {/*</div>*/}
                </div>
            </div>
        </div>
    );
}
