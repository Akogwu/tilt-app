import React, { Fragment, useContext, useState } from "react";
import ListGroups from "./ListGroups";
import { GroupContext } from "./GroupContext";
import ContentLoader from "react-content-loader";
import TextField from "@material-ui/core/TextField";
import Button from "@material-ui/core/Button";
import Icon from "@mdi/react";
import { mdiPlusCircle, mdiMinusCircle, mdiAccountCircle } from "@mdi/js";
import {apiGet, apiPost, apiUpdate} from "../../utils/ConnectApi";

//import React, { useState } from "react";

const GroupResources = ({group_id}) => {
    const [inputList, setInputList] = useState([{ group_resource_desc: "" }]);

    // handle input change
    const handleInputChange = (e, index) => {
        const { name, value } = e.target;
        const list = [...inputList];
        list[index][name] = value;
        setInputList(list);
    };

    // handle click event of the Remove button
    const handleRemoveClick = (index) => {
        const list = [...inputList];
        list.splice(index, 1);
        setInputList(list);
    };

    // handle click event of the Add button
    const handleAddClick = () => {
        setInputList([...inputList, { group_resource_desc: "" }]);
    };

    const handleAddGroupResource = (e, index) => {
        e.preventDefault();
        const list = [...inputList];
        
        const data = {
            group_id:group_id,
            description:list[index].group_resource_desc
        }

        //setErrors(validate(values));
        //if (Object.keys(validate(values)).length <= 0)
        apiPost(data,`group-resources`).then((res) => {
            
            //setGroups([...groups,data]);
            //handleSuccess();
            // setTimeout(function (){
            //     handleClose();
            //     setValues({
            //         name: '',
            //         color: '',
            //         icon: '',
            //         description: ''
            //     })
            //     handleSuccess(false);
            // },1500)

        });
    };

    return (
        <div className="App">
            {inputList.map((x, i) => {
                return (
                    <div key={i}>
                        <form
                            noValidate
                            autoComplete="off"
                            onSubmit={(e) =>
                                handleAddGroupResource(e, i)
                            }
                        >
                            <TextField
                                name="group_resource_desc"
                                value={x.group_resource_desc}
                                label="Group Resource"
                                margin="dense"
                                error=""
                                multiline
                                rows={4}
                                variant="outlined"
                                onChange={(e) => handleInputChange(e, i)}
                            />
                            <br />
                            <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex">
                                <div className="btn-box">
                                    {inputList.length !== 1 && (
                                        <Icon
                                            path={mdiMinusCircle}
                                            size={1}
                                            color="#d90804"
                                            className="inline"
                                            onClick={() => handleRemoveClick(i)}
                                        />
                                        // <Button
                                        //     size="small"
                                        //     variant="outlined"
                                        //     onClick={() => handleRemoveClick(i)}
                                        // >
                                        //     Remove
                                        // </Button>
                                    )}
                                    {inputList.length - 1 === i && (
                                        <Icon
                                            path={mdiPlusCircle}
                                            size={1}
                                            color="#02497f"
                                            className="inline"
                                            onClick={handleAddClick}
                                        />
                                        // <Button
                                        //     size="small"
                                        //     variant="outlined"
                                        //     onClick={handleAddClick}
                                        // >
                                        //     <i className={`fa fa-plus text-blue`}> </i>
                                        // </Button>
                                    )}
                                </div>

                                <Button
                                    variant="contained"
                                    size="small"
                                    type="submit"
                                    className=" float-right w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm"
                                >
                                    Submit
                                </Button>
                            </div>
                        </form>
                    </div>
                );
            })}

            <div style={{ marginTop: 20 }}>{JSON.stringify(inputList)}</div>
        </div>
    );
};

export default GroupResources;
