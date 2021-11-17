import React, {Fragment, useContext, useEffect, useState} from "react";
import TextField from "@material-ui/core/TextField";
import Button from "@material-ui/core/Button";
import Icon from "@mdi/react";
import {mdiPlusCircle, mdiMinusCircle, mdiAccountCircle} from "@mdi/js";
import {apiDelete, apiGet, apiPost, apiUpdate} from "../../utils/ConnectApi";
import OverviewDeleteModal from "./OverviewDeleteModal";
import isEmpty from "../../frontend/test-views/utils/is-empty";

const GraphEditOverview = ({graph_overview, handleSuccess}) => {

    const [overviewList, setOverviewList] = useState({});
    const [inputList, setInputList] = useState({data: []});
    const [openDeleteModal,setOpenDeleteModal] = useState(false);
    const [id,setId] = useState();

    useEffect(() => {

        let da = inputList
        if (!isEmpty(graph_overview)) {
            for (let i = 0; i < graph_overview.length; i++) {
                da.data.push(graph_overview[ i ]);
            }
        } else {
            da.data.push({id: null, description: ""});
        }
        setInputList(da);

    }, [graph_overview]);

    // handle input change
    const handleInputChange = (e, index) => {
        const { name, value } = e.target;
        const list = [...inputList.data];
        list[index][name] = value;
       setInputList({data :list});
    };

    // handle click event of the Remove button
    const handleRemoveClick = (index) => {
        const list = [...inputList.data];
        list.splice(index, 1);
        setInputList({data: list});
    };

    // handle click event of the Add button
    const handleAddClick = () => {
        let da = inputList
        da.data.push({id: null, description: ""});
        setInputList(da);
        setOverviewList({id: 0, description: ""});

    };

    //submits overview
    const handleGraphOverviewSubmit = (e, index) => {
        e.preventDefault();
        const list = [...inputList.data];
        const data = {
            description:list[index].description
        }
        apiPost(data,`graph-overviews`).then(res => {
            //setOverviewList({id: 0, description: ""});
            apiGet('graph-overviews').then(overview => {

                let da = {data: []};
                    for (let i = 0; i < overview.length; i++) {
                        da.data.push(overview[ i ]);
                    }
                setInputList(da);
                    handleSuccess();
                setTimeout(function (){
                    //handleClose();

                    handleSuccess(false);
                },1500)
            //
            });
        });
    };

    //opens delete modal
    const handleOpenDeleteModal = (e,id) => {
        setId(id);
        setOpenDeleteModal(true);
    }

    const handleCloseDeleteModal = () => {
        setOpenDeleteModal(false);
    }

    const handleDelete = () => {
        apiDelete(`graph-overviews/${id}`).then( () => {
            setInputList({data:inputList.data.filter((overview) => overview.id !== id)});
        });
    }

    return (
        <div className="App">
            <OverviewDeleteModal overview_id={id} open={openDeleteModal} handleClose={handleCloseDeleteModal} handleDelete={handleDelete}/>
            {
                inputList.data.map((x, i) => {
                    return (
                        <div key={i}>

                            <form
                                noValidate
                                autoComplete="off"
                                onSubmit={(e) =>
                                    handleGraphOverviewSubmit(e, i)
                                }
                            >
                                <TextField
                                    fullWidth
                                    name="description"
                                    value={x.description}
                                    label="Learning Behaviour Graph"
                                    margin="dense"
                                    error=""
                                    multiline
                                    rows={6}
                                    variant="outlined"
                                    onChange={(e) => handleInputChange(e, i)}
                                />
                                <br/>
                                <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex">
                                    <div className="btn-box mr-3">
                                        {inputList.data.length !== i && (

                                                <Icon
                                                    path={mdiMinusCircle}
                                                    size={1}
                                                    color="#d90804"
                                                    className="inline"
                                                    onClick={() => handleRemoveClick(i)}
                                                />

                                        )
                                        }
                                        {inputList.data.length - 1 == i && (

                                                <Icon
                                                    path={mdiPlusCircle}
                                                    size={1}
                                                    color="#02497f"
                                                    className="inline"
                                                    onClick={handleAddClick}
                                                />
                                        )
                                        }
                                    </div>

                                    <div className="mr-3">
                                        <Button
                                            variant="contained"
                                            size="small"
                                            type="submit"
                                            className=" float-right w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm"
                                            style={{backgroundColor: "#047857", color:"white"}}
                                        >
                                            Submit
                                        </Button>
                                    </div>
                                    <div className="mr-3">
                                        <Button
                                            variant="contained"
                                            size="small"
                                            type="button"
                                            className="float-right w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm"
                                            onClick={(e)=>handleOpenDeleteModal(e, x.id)}
                                            style={{backgroundColor: "#d90804", color:"white"}}
                                        >
                                            Delete
                                        </Button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    );
                })
            }
        </div>
    );
};

export default GraphEditOverview;
