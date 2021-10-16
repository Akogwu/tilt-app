import Divider from "@mui/material/Divider";
import React from "react";
import { MainAccordion } from "../components/accordion";
import { BarChart } from "../components/charts";
import { ResultLayout } from "../components/Layout";
import { HeaderDetail, ReportSection } from "./Report";
import { v4 as uuidv4 } from "uuid";

export const _renderDominantInfo = () => {
    return (
        <div>
            <p style={{ fontWeight: 300, fontSize: 14, margin: 0 }}>
                Your dominant learning methods are{" "}
            </p>
            <div className="row dominant-info ">
                <div className="col-xl-10 m-auto ">
                    <div className="row justify-content-around">
                        <div className="outline-icon">
                            <img
                                src={
                                    require("../assets/images/character/outline/brainy-o.png")
                                        .default
                                }
                            />
                            <h3>Brainy</h3>
                        </div>
                        <div className="separator" />
                        <div className="outline-icon">
                            <img
                                src={
                                    require("../assets/images/character/outline/puter-o.png")
                                        .default
                                }
                            />
                            <h3>Puter</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export const DetailedReport = () => {
    const data = require("../sampledata/detailedreport.json");
    return (
        <ResultLayout
            bottomButton={{
                text: "View Detailed Report",
                url: "/result/check-report",
            }}
        >
            <div className="row justify-content-center detailed-report">
                <HeaderDetail
                    title={"Bio-Data"}
                    dominant={_renderDominantInfo()}
                    cardClassnameclassName="p-2"
                >
                    <div className="col-xl-5 biodata">
                        <div className="row justify-content-between bio-data text-white text-left">
                            <ul>
                                <li>
                                    Sex: <span>Female</span>{" "}
                                </li>
                                <li>
                                    Age: <span>17</span>{" "}
                                </li>
                                <li>
                                    School:{" "}
                                    <span>Government Girls College</span>{" "}
                                </li>
                            </ul>

                            <ul>
                                <li>
                                    Class: <span>SSS 3</span>{" "}
                                </li>
                                <li>
                                    State/Province: <span>Abuja</span>{" "}
                                </li>
                                <li>
                                    Country: <span>Nigeria</span>{" "}
                                </li>
                            </ul>
                        </div>
                    </div>
                </HeaderDetail>
                <div className="container">
                    <div className="col-xl-12">
                        <Divider style={{ marginTop: 50, marginBottom: 30 }}>
                            <h4
                                style={{
                                    margin: 0,
                                    marginLeft: 20,
                                    marginRight: 20,
                                }}
                            >
                                Overview
                            </h4>
                        </Divider>

                        <div className="col-sm-9 m-auto p-0">
                            <div
                                style={{
                                    width: "max-content",
                                    margin: "auto",
                                    marginTop: "1rem",
                                    marginBottom: "2rem",
                                }}
                            >
                                <BarChart
                                    id={uuidv4()}
                                    data={[
                                        {
                                            label: "Legend 1",
                                            data: [107, 124, 99, 115, 133, 133],
                                            backgroundColor: "#526080",
                                        },
                                        {
                                            label: "Legend 2",
                                            data: [66, 107, 75, 66, 91, 66],
                                            backgroundColor: "#A8AFBF",
                                        },
                                    ]}
                                    labels={[
                                        "Banky",
                                        "Brainy",
                                        "Jack",
                                        "Puter",
                                        "Level of Readiness",
                                        "Temperate",
                                    ]}
                                />
                            </div>

                            <p className="">
                                Lorem ipsum dolor sit amet, consectetuer
                                adipiscing elit, sed diam nonummy nibh euismod
                                tincidunt ut laoreet dolore magna aliquam erat
                                volutpat. Ut wisi enim ad minim veniam.Lorem
                                ipsum dolor sit amet, consectetuer adipiscing
                                elit, sed diam nonummy nibh euismod tincidunt ut
                                laoreet dolore magna aliquam erat volutpat. Ut
                                wisi enim ad minim veniam.
                            </p>
                        </div>
                    </div>
                </div>
                {/* {data.map((item, i) => {
                    return <ReportSection {...item} />;
                })} */}
                <div className="container">
                    <div className="col-xl-12">
                        <MainAccordion data={data} />
                    </div>
                </div>

                <div className="container">
                    <div className="col-xl-12 justify-content-end">
                        <ul className="report-sharing">
                            <li>
                                <a href="#">
                                    <i className="fab fa-twitter" />
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i className="fab fa-facebook-f" />
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i className="fas fa-envelope" />
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div className="col-xl-12">
                        <hr style={{ borderColor: "#C9D9F5" }} />
                    </div>
                </div>
            </div>
        </ResultLayout>
    );
};
