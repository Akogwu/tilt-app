import React, {useContext, useEffect, useState} from "react";
import TextField from "@material-ui/core/TextField";
import useForm from "./useForm";
import validate from "./validateInfo";
import {GroupContext} from "./GroupContext";
import {apiGet} from "../../utils/ConnectApi";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faThumbsUp} from "@fortawesome/free-solid-svg-icons";
import GraphEditOverview from "./GraphEditOverview";

export default function GroupOverview({
                                     //   graph_overviewData,
                                    }) {

    const [success, setSuccess] = useState(false);

    const handleSuccess = ($success = true) => {
        setSuccess($success);
    };

    useEffect( () => {
        apiGet('graph-overviews').then(overview => {

            // for (let i = 0; i < overview.length; i++) {
            //     //console.log(overview[i]);
            //     setGraphOverviewValue({...graph_overviewValue, ['id']:overview[i].id, ['description']:overview[i].description});
            // }

            setGraphOverviewValue(overview);
        });
    },[]);

    const {
        values,
        graph_overviewValue,
        handleChange,
        errors,
        handleSubmit,
        handleEdit,
        handleChangeEdit,
        handleResourceChangeEdit,
        handleChangeOverview,
        handleOverviewEdit,
        handleClear,
        setGraphOverviewValue
    } = useForm(validate, handleSuccess);

    //console.log(graph_overviewValue[0]);
    return (
        <div>
            <div className="mt-2 text-center">
                <div className="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div
                            className={`inline-flex w-full overflow-hidden bg-gray-100 rounded-lg shadow-2xl my-2 ${
                                !success && "hidden"
                            } `}
                        >
                            <div className="flex items-center justify-content-center w-12 bg-green-500">
                                <FontAwesomeIcon
                                    icon={faThumbsUp}
                                    size="lg"
                                    className=" mx-auto flex-shrink-0 text-white"
                                />
                            </div>
                            <div className="px-3 py-2 text-left">
                                                    <span className="font-semibold text-green-500">
                                                        Success
                                                    </span>
                                <p className="mb-1 text-sm leading-none text-gray-500">
                                    Graph Overview Submitted
                                    Successfully
                                </p>
                            </div>
                        </div>
                        {/*<div className="sm:flex sm:items-start">*/}
                        {/*<div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">*/}
                        {/*<form*/}
                        {/*    noValidate*/}
                        {/*    autoComplete="off"*/}
                        {/*    onSubmit={(e) =>*/}
                        {/*        handleOverviewEdit(*/}
                        {/*            e,*/}
                        {/*            graph_overviewValue.id*/}
                        {/*        )*/}
                        {/*    }*/}
                        {/*>*/}

                        {/*    <div className="grid grid-cols-1 gap-2.5 my-2">*/}
                        {/*        <div>*/}
                        {/*            /!*<label style={{color:'#989898',fontSize:'18px'}}>Overview</label>*!/*/}
                        {/*            <TextField*/}
                        {/*                fullWidth*/}
                        {/*                name="description"*/}
                        {/*                value={*/}
                        {/*                    graph_overviewValue.description*/}
                        {/*                }*/}
                        {/*                label="Overview"*/}
                        {/*                margin="dense"*/}
                        {/*                error=""*/}
                        {/*                multiline*/}
                        {/*                rows={6}*/}
                        {/*                variant="outlined"*/}
                        {/*                onChange={*/}
                        {/*                    handleChangeOverview*/}
                        {/*                }*/}
                        {/*            />*/}
                        {/*            <br/>*/}
                        {/*            <small*/}
                        {/*                className={*/}
                        {/*                    "text-danger"*/}
                        {/*                }*/}
                        {/*            >*/}
                        {/*                {errors.description &&*/}
                        {/*                errors.descrition}*/}
                        {/*            </small>*/}
                        {/*        </div>*/}
                        {/*    </div>*/}

                        {/*    <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">*/}
                        {/*        <button*/}
                        {/*            type="submit"*/}
                        {/*            className="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm"*/}
                        {/*        >*/}
                        {/*            Submit*/}
                        {/*        </button>*/}
                        {/*        <button*/}
                        {/*            type="button"*/}
                        {/*            onClick={*/}
                        {/*                handleClear*/}
                        {/*            }*/}
                        {/*            className="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"*/}
                        {/*        >*/}
                        {/*            Clear*/}
                        {/*        </button>*/}
                        {/*    </div>*/}
                        {/*</form>*/}
                        <div className="grid grid-cols-1 gap-2.5 my-2">
                            {/* Graph Overview */}
                             <GraphEditOverview graph_overview = {graph_overviewValue} handleSuccess={handleSuccess}/>
                        </div>
                    </div>
                    {/*</div>*/}
                    {/*</div>*/}
                </div>
            </div>
        </div>
    );
}
