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

                        <div className="grid grid-cols-1 gap-2.5 my-2">
                             <GraphEditOverview graph_overview = {graph_overviewValue} handleSuccess={handleSuccess}/>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    );
}
