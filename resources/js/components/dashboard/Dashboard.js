import React, {Fragment, useEffect, useState} from 'react';
import {apiGet} from "../utils/ConnectApi";
import ReactDOM from "react-dom";


const Dashboard = () => {
    const [dashboardData,setDashboardData] = useState([]);
    useEffect( () => {
        apiGet(`admin/dashboard`).then(data => {
           console.log(data);
        });
    },[]);


    return (
        <Fragment>

        </Fragment>
    );
}

export default Dashboard;
if (document.getElementById('dashboard-component')) {
    ReactDOM.render(<Dashboard />, document.getElementById('dashboard-component'));
}
