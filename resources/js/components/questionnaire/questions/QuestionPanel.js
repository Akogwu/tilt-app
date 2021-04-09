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

    const [score, setScore] = useState(20)
    const [remark, setRemark] = useState("")
    const [weight_point, setWeightPoint] = useState([])
    const [open, setOpen] = React.useState(false);
    const [loading, setLoading] = useState(false)
    const [expanded, setExpanded] = React.useState(false);
    const [sectId, setSectId] = useState();
    const [qstId, setQstId] = useState();
    const {values,handleChange, errors, handleSubmit} = useForm(validate,false,false,fillData);




    useEffect ( () => {
       async function setDetails(){
           setWeightPoint(weight_point => weight_point = question.weight_points)
           setQstId(question.id)
           setSectId(question.section_id);
           //setQuestion(question.question);
           if(question.weight_points){
               const point = 20
               const pointObj = await weight_point.find(o => o.weight_point === point)
               if (pointObj){
                   setRemark(pointObj.remark)
               }else setRemark("")
           }
       }
        setDetails();
    },[weight_point])



    const data = {
        section_id:sectId,
        question: question,
        weight_point: weight_point
    };


    const handleRemarkChange = (event) => {
        setRemark(event.target.value)
    };
    const handleQuestionChange = (event) => {
        setQuestion(event.target.value)
    };
    const handleScoreChange = async (event) => {
        setScore(event.target.value);

        const point = event.target.value

        // weight_point.forEach
        const pointObj = await weight_point.find(o => o.weight_point === point)

        if (pointObj){
            setRemark(pointObj.remark)
        }else setRemark("")

    };
    const handleRemarkAdd = () => {
        if (remark !== ""){
            let wt_point = {};
            wt_point.questionnaire_id = qstId;
            wt_point.weight_point = parseInt(score);
            wt_point.remark = remark;

            const index = weight_point.findIndex(x => x.weight_point === wt_point.weight_point);

            console.log(index);

            weight_point[index].remark = wt_point.remark;
            handleClick()
        }else alert("Enter a remark to add this score")
    };

    const handleClick = () => {
        setOpen(true);
    };

    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }
        setOpen(false);
    };

    const deleteQuestion = (id) => {
        setLoading(true);
        if ( id !== 0){
            window.confirm('Are you sure?') &&
            axios.delete('https://tiltapp-api.herokuapp.com/questionnaire/'+id).then(async res => {
                if (res.status){
                    handleClick();

                    await getUpdatedQuestion();
                    setLoading(false)
                }else {
                    setLoading(false);
                    alert("Could not add question")
                }
            } ).catch(err => console.log(err));
        }
    };

    const getUpdatedQuestion = () => {
        axios.get('https://tiltapp-api.herokuapp.com/sections/'+sectId+'/questionnaires').then(res => {
            if (res.status){
                setQuestions(questObj => ({...questObj, questionList:res.data }))
            }
        }).catch( err => {
            console.log(err);
        });
    };

    const handleFormSubmit = (event) => {
        event.preventDefault()
        if(sectId === undefined || sectId === 0){
            return alert("Kindly reselect a section to update questions")

        }
        if (Object.keys(errors).length === 0){
            setLoading(true);
            axios.put('https://tiltapp-api.herokuapp.com/questionnaire/'+qstId,data).then(async res => {
                if (res.status){
                    await getUpdatedQuestion()
                    setLoading(false)
                    handleClick()
                }else {
                    setLoading(false)
                    alert("Could not add question")

                }

            }).then( err => {
                setLoading(false);

                console.log(err);
            } );
        }else{
            setErrors(errors)
        }
    };

    const handleExpChange = (panel) => (event, isExpanded) => {
        setExpanded(isExpanded ? panel : false);
    };



    return (
        <div className={classes.root}>
            <Accordion className={`my-2`}>
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon />}
                    aria-controls="panel1a-content"
                    id="panel1a-header"
                >
                    <Typography className={classes.heading}>{question.question}</Typography>
                </AccordionSummary>
                <AccordionDetails>
                    <form noValidate autoComplete="off"  className={classes.form}>
                        <div >
                            <TextField
                                fullWidth
                                id="outlined-multiline-question"
                                label="Question"
                                multiline
                                rows={3}
                                name="question"
                                value={question.question}
                                variant="outlined"/>
                        </div>
                        <div className={classes.root}>
                            <TextField
                                fullWidth
                                id="select-section"
                                select
                                label="Select score"
                                onChange=""
                                helperText="Please select score"
                                value=""
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
                                value=""
                                name={"remark"}
                                onChange=""
                                onBlur=""
                                helperText=""
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
