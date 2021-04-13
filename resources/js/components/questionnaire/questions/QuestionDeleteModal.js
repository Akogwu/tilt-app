import React, {useState,Fragment} from 'react';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import Slide from '@material-ui/core/Slide';
import useActionDelete from "./useActionDelete";
import AlertMessage from "../../Alert";

const Transition = React.forwardRef(function Transition(props, ref) {
    return <Slide direction="up" ref={ref} {...props} />;
});

export default function QuestionDeleteModal({open,handleClose,question_id}) {
    const [success,setSuccess] = useState(false);
    const handleSuccess = ($success = true) => {
        setSuccess($success);
    }
    const {handleDeleteModal} = useActionDelete(handleSuccess);
    const closeAlert = () => {
        setSuccess(false);
    }

    return (
        <Fragment>
            <AlertMessage open={success} handleCloseSnack={closeAlert} message={`Deleted successfully!`} severity={`success`}/>
            <Dialog
                open={!!open}
                TransitionComponent={Transition}
                keepMounted
                onClose={handleClose}
                aria-labelledby="alert-dialog-slide-title"
                aria-describedby="alert-dialog-slide-description"
            >
                <DialogTitle id="alert-dialog-slide-title">{"Are you sure you want to delete?"}</DialogTitle>
                <DialogContent>
                    <DialogContentText id="alert-dialog-slide-description">
                        You can not undo this operation, please ensure you really want to delete this group.
                    </DialogContentText>
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose} color="primary">
                        Cancel
                    </Button>
                    <Button onClick={ () =>{
                        handleDeleteModal(question_id);
                        handleClose();
                    }} variant="contained" color="secondary">
                        Delete
                    </Button>
                </DialogActions>
            </Dialog>
        </Fragment>
    );
}
