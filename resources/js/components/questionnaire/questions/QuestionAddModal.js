import React, {Fragment, useContext, useEffect,useState} from 'react';
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import Snackbar from "@material-ui/core/Snackbar";
import DialogContent from "@material-ui/core/DialogContent";
import FormControl from "@material-ui/core/FormControl";
import InputLabel from "@material-ui/core/InputLabel";
import Select from "@material-ui/core/Select";
import MenuItem from "@material-ui/core/MenuItem";
import TextField from "@material-ui/core/TextField";
import { makeStyles,withStyles } from '@material-ui/core/styles';
import DialogActions from "@material-ui/core/DialogActions";
import Button from "@material-ui/core/Button";
import useForm from "./useForm";
import validate from "./validateInfo";
import {SectionContext} from "../Sections/SectionContext";
import {QuestionContext} from "./QuestionContext";
import Slide from "@material-ui/core/Slide";
import AlertMessage from "../../Alert";


const useStyles = makeStyles((theme) => ({
    formControl: {
        margin: theme.spacing(1),
        minWidth: 250,
    },
    root: {
        '& .MuiTextField-root': {
            margin: theme.spacing(1),
            width: '60ch',
        },
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
}));

const Transition = React.forwardRef(function Transition(props, ref) {
    return <Slide direction="up" ref={ref} {...props} />;
});

const QuestionAddModal = ({open,handleClose}) => {
    const classes = useStyles();
    const handleSuccess = ($success = true) => {
        setSuccess($success);
    }
    const {state,handleChanges,handleChangeRemark,handleAddRemark,handleUpdateQuestion,errors,handleSubmit,loading} = useForm(validate,handleSuccess,handleClose);
    const [sections,,,secGroupId] = useContext(SectionContext);
    const [questions,setQuestions,loadingQuestions,sectionId,setSectionId] = useContext(QuestionContext);
    const [section,setSection] = useState({});
    const [success,setSuccess] = useState(false);


    useEffect( () => {
        setSection(sections.find( section => section.id === sectionId ));
    },[sectionId]);

    const closeAlert = () => {
        setSuccess(false);
    }

    return (
        <Fragment>

            <Dialog
                open={!!open}
                TransitionComponent={Transition}
                keepMounted
                aria-labelledby="form-dialog-title"
                className={classes.form}
            >
                <DialogTitle id="form-dialog-title">Add New Question</DialogTitle>
                <DialogContent>
                    {
                            <form  noValidate autoComplete="off" onSubmit={handleSubmit}>

                                <FormControl variant="outlined"  style={{marginLeft:10}} className={classes.formControl}>
                                    <InputLabel id="select-section-label">Section</InputLabel>
                                    <Select
                                        labelId="select-section-label"
                                        label={section.name}
                                        value={section.id}
                                        name="section_id"
                                        selected
                                        disabled>
                                        <MenuItem  value={section.id}>{section.name}</MenuItem>
                                    </Select>
                                </FormControl>

                                <div  className={ classes.form} >
                                    <TextField
                                        fullWidth
                                        error={!!(errors.question)}
                                        id="outlined-multiline-question"
                                        label="Question"
                                        multiline
                                        rows={4}
                                        cols={20}
                                        value={state.question}
                                        onChange={handleChanges}
                                        name="question"
                                        variant="outlined"/>
                                </div>

                                <DialogActions>
                                    <Button onClick={handleClose} color="secondary">
                                        Cancel
                                    </Button>
                                    <button type="submit"  className={"mt-3 w-full inline-flex justify-center rounded-md border border-green-300 shadow-sm px-4 py-2 bg-green-300 text-base font-medium text-green-700 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"}>Submit</button>
                                </DialogActions>
                            </form>
                    }
                </DialogContent>
            </Dialog>
        </Fragment>
    );

}

export default QuestionAddModal;
