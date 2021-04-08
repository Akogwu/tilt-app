import React, {useEffect,useState} from 'react';
import NavLogo from "./navigation/NavLogo";
import NavigationLinks from "./navigation/NavigationLinks";
import NavActionButton from "../../snippets/NavActionButton";
import {NavLink, useHistory, useLocation} from "react-router-dom";
import axios from 'axios';
import { withRouter } from 'react-router'; 
import Snackbar from '@material-ui/core/Snackbar';
import MuiAlert from '@material-ui/lab/Alert';
import ChangePwd from './Changepwd';
import IconButton from '@material-ui/core/IconButton';
import AccountCircleIcon from '@material-ui/icons/AccountCircle';
import Menu from '@material-ui/core/Menu';
import MenuItem from '@material-ui/core/MenuItem';
import { loadCSS } from 'fg-loadcss';
import UpdateProfile from './UpdateProfile';
import Config from "../../../../helpers/Config";
import AvatarGroup from '@material-ui/lab/AvatarGroup';
import auth from '../../../auth';

function Alert(props) {
    return <MuiAlert elevation={6} variant="filled" {...props} />;
  }

const Header = (props) => {
    const [userProfile, setUserProfile] = React.useState({})
    const [logMsg, setLogMsg] = React.useState("")
    const [open, setOpen] = React.useState(false)
    const [isTest, setIsTest]= React.useState(false)
    const [canPwd, setPwd] = React.useState(false)
    const [clickedForm, setClickedForm] = React.useState(undefined)
    const [openedForm, setOpenedForm] = React.useState(undefined)
    const [anchorEl, setAnchorEl] = React.useState(null);
    const [isAdmin, setIsAdmin] = React.useState(false);
    const [isLearner,setIsLearner] = useState(false);

    const history = useHistory();
    const location = useLocation();

    const usrProfile = JSON.parse(localStorage.getItem('@UserProfile'))

    useEffect (()=> {
        if (usrProfile == null){
            setLogMsg("Login")
            setPwd(false)
        }else{
        setPwd(true)
        if (usrProfile.role.role === "SCHOOL_ADMIN" || usrProfile.role.role === "ADMIN"){
            setIsAdmin(true)
        }

        if (usrProfile.role.role === "PRIVATE_LEARNER"){
            setIsLearner(true);
        }
        setLogMsg("Logout")

        }
        setUserProfile(usrProfile)
        if (location.pathname === '/test'){
            setIsTest(true)
        }
    },[logMsg]);

    React.useEffect(() => {
        const node = loadCSS(
            'https://use.fontawesome.com/releases/v5.12.0/css/all.css',
            document.querySelector('#font-awesome-css'),
        );
        return () => {
            node.parentNode.removeChild(node);
        };
    }, []);

    const openMenu = (event) => {
        setAnchorEl(event.currentTarget);
      };
    
      const closeMenu = () => {
        setAnchorEl(null);
      };


    const doLog = () => {
        if (logMsg === "Login"){
            history.push("/auth/login")
        }else logout()
    };

   const  handleClick = () => {
        setOpen(true)
      };
    
     const  handleClose = (event, reason) => {
        if (reason === 'clickaway') {
          return;
        }
        setOpen(false)
      };

      const gotoAdmin = () => {
        let role = userProfile.role.role;
        switch (role) {
          case "ADMIN":
            history.push("/admin");
            break;
          case 'SCHOOL_ADMIN':
            history.push('admin/school/info/dashboard')
            break;
          
        }
      };

   
    const changePwd = () =>{
        closeMenu();
        setClickedForm(1)
    };
    const editProfile = () =>{
        closeMenu();
        setOpenedForm(1)
    };


    const handleRemoveModal = () => {
        setOpenedForm(undefined);
        setClickedForm(undefined);
    };

    const goToUserDashboard = () => {
        history.push('/private/learner/dashboard');
    };
    const returnToken = () =>{return  JSON.parse(localStorage.getItem('@AppT4k3n'));};
    const logout = async () =>{
        const Token = await JSON.parse(localStorage.getItem('@AppT4k3n'));
        const config = {headers: { Authorization: `Bearer${Token}` }}
       await axios.post(Config.apiBaseUrl+'auth/logout',config,{headers:{Authorization: `Bearer ${returnToken()}`}
       }).then(async res => {
             await localStorage.removeItem('@AppT4k3n');
             await localStorage.removeItem('@UserProfile');
             await localStorage.removeItem('@FullResults');
             await localStorage.removeItem('@detailedResults');
             await localStorage.removeItem('@TstS3ssion');
             await localStorage.removeItem('schoolKey');
             await localStorage.removeItem('login');
             auth.logout();
             setLogMsg('Login');
             history.push('/');
        }).catch(async  err => {
            await localStorage.removeItem('@AppT4k3n');
            await localStorage.removeItem('@UserProfile');
            // setUserProfile({})
            //window.location.reload(true)
        });
    };

    return (
        <header className="header-global">
            <nav id="navbar-main"
                className={`navbar navbar-main navbar-expand-lg navbar-transparent navbar-${props.navBarType} navbar-theme-primary headroom py-lg-2 px-lg-6`}>
                <div className="container">
                <ChangePwd
                    clickedForm={clickedForm}
                    showSuccess={handleClick}
                    handleRemoveModal={handleRemoveModal}
                />
                <UpdateProfile
                    openedForm={openedForm}
                    showSuccess={handleClick}
                    handleRemoveModal={handleRemoveModal}
                />
                    <NavLogo/>
                    <div className="navbar-collapse collapse" id="navbar_global">
                    <Snackbar open={open} autoHideDuration={4000} onClose={handleClose}>
                    <Alert onClose={handleClose} severity="success">
                    Success ! DONE
                    </Alert>
                    </Snackbar>
                        <div className="navbar-collapse-header">
                            <div className="row">
                                <div className="col-6 collapse-brand">
                                    <NavLogo/>
                                </div>
                                <div className="col-6 collapse-close">
                                    <a
                                        href="#navbar_global"
                                        role="button"
                                        className="fas fa-times"
                                        data-toggle="collapse"
                                        data-target="#navbar_global"
                                        aria-controls="navbar_global"
                                        aria-expanded="false"
                                        aria-label="Toggle navigation">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <NavigationLinks/>
                    </div>
                    <div className="d-flex align-items-center">
                      <NavLink to="/test" role="button"   className={"btn mr-3 btn-pill btn-secondary navTestBtn animate-up-2"} >
                        <i className="fa fa-file-alt mr-1"> Take Test </i>
                      </NavLink>
                      
                       {canPwd && <div className={" mr-3 animate-up-2"}>
                           <div className="profile-top">
                               <span>{ (usrProfile) && usrProfile.first_name}</span>
                               <IconButton color="primary" aria-label="account" component="span" onClick={openMenu}>
                                   <AccountCircleIcon fontSize="large" />
                               </IconButton>
                           </div>

                        <Menu
                            id="simple-menu"
                            anchorEl={anchorEl}
                            keepMounted
                            open={Boolean(anchorEl)}
                            onClose={closeMenu}
                        >
                            <MenuItem>{ (usrProfile) && usrProfile.fullname}</MenuItem>
                            <MenuItem>{ (usrProfile) && usrProfile.email }</MenuItem>
                            <MenuItem onClick={editProfile}>Edit Profile</MenuItem>
                            <MenuItem onClick={changePwd}>Change Password</MenuItem>
                            {isLearner && <MenuItem onClick={goToUserDashboard}>Dashboard</MenuItem>}
                            { isAdmin && <MenuItem onClick={gotoAdmin}> Admin Portal</MenuItem>}
                            {/* <MenuItem onClick={handleClose}>Logout</MenuItem> */}
                        </Menu>
                       </div>}
                       <div onClick={doLog}> 
                           <NavActionButton className={"btn btn-sm mr-3 text-white btn-pill btn-tertiary animate-up-2"}
                           icon={"fa-unlock"}
                           text={logMsg}
                       /></div>
                        <button className="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                            <span className="navbar-toggler-icon"> </span>
                        </button>
                    </div>
                </div>
            </nav>
        </header>
    );
};

export default Header;
