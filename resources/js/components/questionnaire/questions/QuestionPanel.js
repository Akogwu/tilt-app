import React, {useEffect,useState} from 'react';
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
    const {state,handleChanges, handleChangeRemark,handleAddRemark,handleUpdateQuestion, errors, handleSubmit} = useForm(validate,false,false, question);


    // const [state,setState] = useState({
    //     question:'',
    //     weight_points:[],
    //     weight_point:20,
    //     remark:'',
    //     section_id:'',
    //     question_id:''
    // });


    // useEffect( () => {
    //     const {question,weight_points,section_id} = props.question;
    //     let initial_point = 20;
    //     let initial = weight_points.find(current_score => current_score.weight_point === initial_point);
    //     setState({...state,
    //         question: question,
    //         weight_points: weight_points,
    //         remark:initial.remark,
    //         section_id:section_id,
    //         question_id: props.question.id
    //     });
    // },[props, state]);

    // const data = {
    //     question: state.question,
    //     section_id: state.section_id,
    //     weight_point:state.weight_points
    // };
    //
    //
    // const handleChanges = (e) => {
    //     setState({...state,[e.target.name]:e.target.value});
    // };
    //
    // const handleRemarkChanges = (e) => {
    //     const score = parseInt(e.target.value);
    //     let scoreObj = state.weight_points.find(current_score => current_score.weight_point === score);
    //     setState({...state,weight_point:scoreObj.weight_point,remark:scoreObj.remark});
    // };

    // const handleCloseDialog = () => setOpenDeleteDialog(false);
    // const handleDeleteQuestion = id => {
    //     setSelectedQuestion(id);
    //     setOpenDeleteDialog(true);
    // };

    // const handleUpdateForm = async e => {
    //     e.preventDefault();
    //     let res = await axios.put(config.apiBaseUrl+`questionnaire/${state.question_id}`,data,{headers:{Authorization: `Bearer ${returnToken()}`}});
    //     setReturnMessage('Updated successfully');
    //     setOpenSnack(true);
    //     console.log(res)
    // };
    //
    // const handleAddRemark = () => {
    //     let setData = {};
    //     setData.weight_point = state.weight_point;
    //     setData.remark       = state.remark;
    //     let index = state.weight_points.findIndex( obj => obj.weight_point === setData.weight_point);
    //     state.weight_points[index].remark = setData.remark;
    // };
    // const handleCloseSnack = () => setOpenSnack(false);



    return (
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
                        </div>

                        <Divider/>
                        <DialogActions className={classes.Heading}>
                            <button className={"w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"} >
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
    );
}

export default QuestionPanel;
