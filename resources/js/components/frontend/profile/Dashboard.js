import React, {Fragment} from 'react';

const Dashboard = () => {

    return (
        <Fragment>
            <section className="section bg-gray-200 overlay-gray-100 text-white"
                     data-background="">
                <div className="container">
                    <div className="row justify-content-center pt-5">
                        <div className="col-10 mx-auto text-center">

                            <figure className=" rounded-xl  md:p-0">
                                <img className="w-32 h-32 md:w-48 md:h-auto  rounded-full mx-auto" src=""
                                     alt="" width="384" height="512"/>
                                    <div className="pt-2 md:p-8 text-center md:text-left ">
                                        <figcaption className="font-medium">
                                            <div className="font-bold text-blue-900">
                                                User NAME
                                            </div>
                                            <div className="text-gray-500">
                                                ROLE
                                            </div>
                                        </figcaption>
                                        <button className="rounded-full w-5 h-5 text-tertiary" title="Edit Profile"><i
                                            className="fas fa-edit fa-2x"></i></button>
                                    </div>
                            </figure>
                        </div>
                    </div>
                </div>
            </section>

            <div className="section pt-0">
                <div className="container mt-n5">
                    <div className="row">
                        <div className="col">
                            <nav>
                                <div
                                    className="nav nav-tabs flex-column flex-md-row shadow-sm border-soft justify-content-around bg-white rounded mb-3 py-3"
                                    id="nav-tab" role="tablist">
                                    <a className="nav-item nav-link active" id="nav-evidence-tab" data-toggle="tab"
                                       href="#" role="tab" aria-controls="nav-evidence" aria-selected="true">
                                        <i className="fas fa-file-alt"></i>No. of test taken <span
                                        className="badge badge-warning">0</span>
                                    </a>
                                    <a className="nav-item nav-link" id="nav-causes-tab" data-toggle="tab" href="#"
                                       role="tab" aria-controls="nav-causes" aria-selected="false">
                                        <i className="fas fa-chart-pie"></i>Success Transactions <span
                                        className="badge badge-dark">0</span>
                                    </a>
                                    <a className="nav-item nav-link" id="nav-effects-tab" data-toggle="tab" href="#"
                                       role="tab" aria-controls="nav-effects" aria-selected="false">&#8358; Total amount
                                        spent <span className="badge badge-success">0.00</span></a>
                                </div>
                            </nav>


                            <div className="tab-content mt-4 mt-lg-5" id="nav-tabContent">
                                <div className="tab-pane fade show active" id="nav-causes" role="tabpanel"
                                     aria-labelledby="nav-causes-tab">
                                    <div className="row justify-content-between">
                                        <div className="col-12 col-lg-7">
                                            <h1 className="text-gray-700 font-bold">Test History</h1>

                                            <div
                                                className="bg-gray-100 shadow-lg rounded p-3 flex justify-content-between my-3">
                                                <div className="border-r-2 border-gray-200">
                                                    <span className="font-bold px-2">Test Date</span>
                                                </div>
                                                <div className="border-r-2 border-gray-200">
                                                    <span className="font-bold px-2">Average Score</span>
                                                </div>
                                                <div className="border-r-2 border-gray-200">
                                                    <span className="font-bold px-2">Total Score</span>
                                                </div>
                                                <div className="">
                                                    <span className="font-bold px-2">Obtainable Score</span>
                                                </div>
                                            </div>

                                            <div className="bg-white shadow-lg rounded w-full p-4 ">

                                            </div>

                                        </div>
                                        <aside className="col-12 col-lg-4 mt-3 mt-lg-0 d-none d-lg-block z-2">
                                            <div className="card shadow-sm border-soft p-3">
                                                <div className="card-body">
                                                    <h4 className="pb-3">We live in a Greenhouse</h4>
                                                    <p>Life on Earth depends on energy coming from the Sun. About half
                                                        the light reaching Earth's
                                                        atmosphere passes through the air and clouds to the surface,
                                                        where it is absorbed and then
                                                        radiated upward in the form of infrared heat. About 90 percent
                                                        of this heat is then absorbed
                                                        by the greenhouse gases and radiated back toward the
                                                        surface.</p>
                                                </div>
                                            </div>
                                        </aside>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Fragment>
    );

}

export default Dashboard;
