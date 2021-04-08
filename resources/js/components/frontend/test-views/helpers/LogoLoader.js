import React,{Fragment} from "react";
import Logo from './tilt-logo.svg';

const LogoLoader = () => {

    return (
        <Fragment>
            <div className="logoloader">
                <img src={Logo} alt=""/>
                <p>please wait...</p>
            </div>
        </Fragment>
    );
}

export default LogoLoader;