import React, {Fragment, useEffect, useState} from 'react';
import ImpactCounterItem from "./ImpactCounterItem";
import SectionHeading from "../SectionHeading";
import axios from 'axios';
import Config from "../../../../helpers/Config";

const ImpactCounterSection = () => {

    const [data,setData] = useState([]);

    useEffect(()=>{
        axios.get(Config.apiBaseUrl+`public-statistics`).then(res => {
            console.log(res.data);
            setData(res.data);
        }).catch(err => {

        });
    },[]);

    return (
        <Fragment>
            <SectionHeading
                renderHeading={() => (
                    <Fragment>
                        See the Impact of
                        <span className="text-primary font-weight-bold">&nbsp; TILT</span>
                    </Fragment>
                )}
                renderDescription={() => (
                    <Fragment>
                        <span className="text-primary font-weight-bold">&nbsp; The TILT Platform</span> is empowering student and schools to determine the causes of academic failures and address them. See the numbers for yourself.
                    </Fragment>
                )}
            />
            <section className="section section-lg py-0">
                <div className="container mt-n5 mt-md-n6">

                    <div className="row">
                        <div className="col-12">
                            <div className="card-group">
                                <ImpactCounterItem
                                    caption={"Test Completed"}
                                    count={data.total_tests}
                                    icon={"file-alt"}
                                />
                                <ImpactCounterItem
                                    caption={"Schools Registered"}
                                    count={data.total_schools}
                                    icon={"school"}
                                />
                                <ImpactCounterItem
                                    caption={"Learners Tested"}
                                    count={data.total_learners}
                                    icon={"user-graduate"}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </Fragment>
    );
};

export default ImpactCounterSection;
