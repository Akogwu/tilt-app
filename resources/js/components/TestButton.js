import React, {Fragment} from 'react';
import ReactDOM from "react-dom";
import {apiPost} from "./utils/ConnectApi";
import { useHistory } from "react-router-dom";


const TestButton = () => {

    const getSession = () =>{
        let user_id = localStorage.getItem('user_id')??null;
        const data = {
            'user_id':user_id
        }
        apiPost(data,'test/new-session').then(res => {
            if(res.status){
                localStorage.setItem('session_id',res.session_id);
               window.location.href = "/take-test"
            }

        });
    }

    return (
        <Fragment>
            <button className={`btn btn-md btn-facebook btn-pill animate-up-2 mr-3`} onClick={ getSession }>
                Begin the test <i className="fas fa-arrow-right ml-2"></i>
            </button>
        </Fragment>
    );

}

export default TestButton;
if (document.getElementById('test-button-component')) {
    ReactDOM.render(<TestButton />, document.getElementById('test-button-component'));
}
