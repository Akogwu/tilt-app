import React, {Fragment, useEffect, useState} from 'react';
import {apiGet} from "../utils/ConnectApi";
import ReactDOM from "react-dom";


const Dashboard = () => {
    const [dashboardData,setDashboardData] = useState([]);

    useEffect( () => {
        apiGet(`admin/dashboard`).then(data => {
           setDashboardData(data);
        });
    },[]);


    return (
        <Fragment>

            <div className="grid grid-cols-12 gap-6 mt-5">
                <div
                    className="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-green-400 via-green-500 to-green-700">
                    <div className="report-box zoom-in">
                        <div className="box p-5">
                            <div className="flex">
                                <img src="/images/graduation.svg" height="24px" width="24px" alt=""/>
                            </div>
                            <div className="text-3xl font-bold leading-8 mt-6">{dashboardData.total_students}
                            </div>
                            <div className="text-base text-gray-600 mt-1">Students Registered</div>
                        </div>
                    </div>
                </div>
                <div
                    className="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-700">
                    <div className="report-box zoom-in">
                        <div className="box p-5">
                            <div className="flex">
                                <img src="/images/school.svg" height="24px" width="24px" alt=""/>

                            </div>
                            <div className="text-3xl font-bold leading-8 mt-6">{dashboardData.total_school}</div>
                            <div className="text-base text-gray-600 mt-1">School Enrolled</div>
                        </div>
                    </div>
                </div>
                <div
                    className="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-gray-300 via-gray-500 to-gray-700">
                    <div className="report-box zoom-in">
                        <div className="box p-5">
                            <div className="flex">
                                <img src="/images/test.svg" height="24px" width="24px" alt=""/>
                            </div>
                            <div className="text-3xl font-bold leading-8 mt-6">{dashboardData.total_test_taken}</div>
                            <div className="text-base text-gray-600 mt-1 text-white">Total Test Taken</div>
                        </div>
                    </div>
                </div>
                <div
                    className="col-span-12 sm:col-span-6 xl:col-span-3 intro-y shadow-lg rounded bg-gradient-to-r from-indigo-400 via-indigo-500 to-indigo-700">
                    <div className="report-box zoom-in">
                        <div className="box p-5">
                            <div className="flex">
                                <img src="/images/credit-card.svg" height="24px" width="24px" alt=""/>
                            </div>
                            <div className="text-3xl font-bold leading-8 mt-6">{dashboardData.successful_transaction}</div>
                            <div className="text-base text-gray-600 mt-1">Successful Transactions</div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="my-8  flex  w-full justify-content-between">
                <div className="recent-tests w-4/6 pr-3">
                    <h1 className="uppercase text-gray-700 font-bold my-2.5">Recent Tests</h1>
                    <div className="flex flex-col w-full">
                        <div className="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div className="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div className="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table className="min-w-full divide-y divide-gray-200">
                                        <thead className="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col"
                                                className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Average Score
                                            </th>
                                            <th scope="col"
                                                className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th scope="col"
                                                className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody className="bg-white divide-y divide-gray-200">
                                        {dashboardData.latest_test && dashboardData.latest_test.map( latest =>
                                            <tr>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="flex items-center">
                                                        <div className="flex-shrink-0 h-10 w-10">
                                                            <img className="h-10 w-10 rounded-full"
                                                                 src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                                                 alt=""/>
                                                        </div>
                                                        <div className="ml-4">
                                                            <div className="text-sm font-medium text-gray-900">
                                                                {latest.name.length > 1 ?latest.name:'Anonymous'}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="flex items-center">
                                                        <div className="ml-4">
                                                            <div className="text-sm text-gray-500">
                                                                {latest.percentage+'%'}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="text-sm text-gray-900">{latest.date}</div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                        <span
                                            className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                                </td>
                                            </tr>
                                        )}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="flex-1">
                    <h1 className="uppercase text-gray-700 font-bold my-2.5">High Performing Schools</h1>
                    <div className="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div className="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div className="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            School
                                        </th>
                                        <th scope="col"
                                            className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No. of Tests
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <div className="flex items-center">
                                                <div className="ml-4">
                                                    <div className="text-sm font-medium text-gray-900">
                                                        Gateway Int'l
                                                    </div>
                                                    <div className="text-sm text-gray-500">
                                                        Area 2, garki, Abuja Capital Territory, Nigeria
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <div className="text-sm text-gray-900">5</div>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Fragment>
    );
}

export default Dashboard;
if (document.getElementById('dashboard-component')) {
    ReactDOM.render(<Dashboard />, document.getElementById('dashboard-component'));
}
