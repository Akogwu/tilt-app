import React, {Fragment, useState} from 'react';
import { makeStyles } from '@material-ui/core/styles';
import Accordion from '@material-ui/core/Accordion';
import AccordionSummary from '@material-ui/core/AccordionSummary';
import AccordionDetails from '@material-ui/core/AccordionDetails';
import Typography from '@material-ui/core/Typography';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import TextField from "@material-ui/core/TextField";
import MenuItem from "@material-ui/core/MenuItem";
import Divider from '@material-ui/core/Divider';
import DialogActions from '@material-ui/core/DialogActions';
import {QuestionContext} from "./QuestionContext";
import useForm from "./useForm";
import validate from "./validateInfo";
import QuestionDeleteModal from "./QuestionDeleteModal";
import AlertMessage from "../../Alert";
import { ChromePicker } from 'react-color';
const useStyles = makeStyles((theme) => ({
    // root: {
    //     width: '100%',
    // },
    heading: {
        fontSize: theme.typography.pxToRem(15),
        fontWeight: theme.typography.fontWeightRegular,
    },
    formControl: {
        margin: theme.spacing(1),
        minWidth: 120,
    },
    root: {
        '& .MuiTextField-root': {
            margin: theme.spacing(1),
            width: '100%',
        },
    },
    flex:{
        Display:'flex',
    },
    selectEmpty: {
        marginTop: theme.spacing(2),
    },
    form:{
        width:'100%',
        display:'block',
        padding:'1rem',
        paddingLeft:10,
        paddingRight:10
    },
    Heading:{
        flex:1,
        display:"flex",
        flexDirection:"row",
        justifyContent:"space-between",
        alignItems:"center"
    }
}));

const  QuestionPanel = ({question,index}) => {
    const classes = useStyles();
    const handleSuccess = ($success = true) => {
        setSuccess($success);
    }
    const {state,handleChanges, handleChangeRemark,handleAddRemark,handleUpdateQuestion, handleColorChanges, errors, handleSubmit} = useForm(validate,handleSuccess,false, question);
    const [openDeleteModal,setOpenDeleteModal] = useState(false);
    const [success,setSuccess] = useState(false);

    const closeDeleteModal = () => {
        setOpenDeleteModal(false);
    }

    const [colorPicker, setColorPicker] = useState('#fff');
    const [showColorPicker, setShowColorPicker] = useState(false);

    return (
        <Fragment>
            { openDeleteModal && <QuestionDeleteModal open={openDeleteModal} handleClose={closeDeleteModal} question_id={question.id}/> }
            { success && <AlertMessage open={success} severity={'success'} message={'question updated successfully'} handleCloseSnack={ () => setSuccess(false) }/> }
            <div className={classes.root}>
                <Accordion className={`my-2`}>
                    <AccordionSummary
                        expandIcon={<ExpandMoreIcon />}
                        aria-controls="panel1a-content"
                        id="panel1a-header"
                    >
                        <Typography className={classes.heading}>{state.question}</Typography>
                    </AccordionSummary>
                    <AccordionDetails>
                        <form noValidate autoComplete="off" onSubmit={handleUpdateQuestion}  className={classes.form}>
                            <div >
                                <TextField
                                    fullWidth
                                    id="outlined-multiline-question"
                                    label="Question"
                                    multiline
                                    rows={3}
                                    name="question"
                                    onChange={handleChanges}
                                    value={state.question}
                                    variant="outlined"/>
                            </div>
                            <div className={classes.flex}>
                                <TextField
                                    fullWidth
                                    id="select-section"
                                    select
                                    label="Select score"
                                    onChange={handleChangeRemark}
                                    helperText="Please select score"
                                    value={state.weight_point}
                                    variant="outlined">
                                    <MenuItem  value="20">20%</MenuItem>
                                    <MenuItem  value="40">40%</MenuItem>
                                    <MenuItem  value="60">60%</MenuItem>
                                    <MenuItem  value="80">80%</MenuItem>
                                    <MenuItem  value="100">100%</MenuItem>
                                </TextField>
                                <TextField
                                    id="outlined-multiline-flexible"
                                    label={"Remark"}
                                    multiline
                                    value={state.remark}
                                    name={"remark"}
                                    onChange={handleChanges}
                                    onBlur={handleAddRemark}
                                    helperText={state.weight_point}
                                    rowsMax={4}
                                    variant="outlined"/>
                                <TextField
                                    fullWidth
                                    id="select-section-grade-point"
                                    select
                                    label="Select Grade Point"
                                    helperText="Please select Grade point"
                                    onChange = {handleChanges}
                                    value={state.grade_point || ""}
                                    name={"grade_point"}
                                    variant="outlined">
                                    <MenuItem  value="8">8%</MenuItem>
                                    <MenuItem  value="15">15%</MenuItem>
                                    <MenuItem  value="17">17%</MenuItem>
                                    <MenuItem  value="20">20%</MenuItem>
                                    <MenuItem  value="40">40%</MenuItem>
                                    <MenuItem  value="60">60%</MenuItem>
                                </TextField>

                            </div>


                            <Divider/>
                            <DialogActions className={classes.Heading}>
                                <button onClick={ ()=> setOpenDeleteModal(true)} className={"w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"} >
                                    Delete
                                </button>
                                <button  className={"w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm"}>
                                    Update
                                </button>
                            </DialogActions>
                        </form>
                    </AccordionDetails>
                </Accordion>

            </div>
        </Fragment>

    );
}

export default QuestionPanel;
