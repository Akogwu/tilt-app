import React from "react";
import Snackbar from '@material-ui/core/Snackbar';
import MuiAlert from '@material-ui/lab/Alert';
import { makeStyles } from '@material-ui/core/styles';

function Alert(props) {
    return <MuiAlert elevation={6} variant="filled" {...props} />;
}

const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
        '& > * + *': {
            marginTop: theme.spacing(2),
        },
    },
}));

const AlertMessage = ({open,handleCloseSnack,message,severity}) => {
    const classes = useStyles();
    return (
        <div className={classes.root}>
            <Snackbar open={!!open} autoHideDuration={6000} onClose={handleCloseSnack}>
                <Alert onClose={handleCloseSnack} severity={`${severity}`}>
                    {message}
                </Alert>
            </Snackbar>
        </div>
    );
};

export default AlertMessage;
