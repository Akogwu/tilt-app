import React from 'react';
import Snackbar from '@material-ui/core/Snackbar';
import MuiAlert from '@material-ui/lab/Alert';
import { makeStyles } from '@material-ui/core/styles';
import Bounce from 'react-reveal/Bounce';

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

const AlertMessage = (props) => {
  const classes = useStyles();

  const handleClose = (event, reason) => {
    if (reason === 'clickaway') {
      return;
    }
    props.closeMessage();
  };

  return (
    <div className={classes.root}>
      <Snackbar open={!!props.open} autoHideDuration={6000} onClose={handleClose}>
        <Bounce>
          <Alert onClose={handleClose} severity={props.severity}>
            {props.message}
          </Alert>
        </Bounce>
      </Snackbar>
    </div>
  );
}

export default AlertMessage;
