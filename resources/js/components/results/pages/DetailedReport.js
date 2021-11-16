import Divider from "@mui/material/Divider";
import React from "react";
import { MainAccordion } from "../components/accordion";
import { BarChart } from "../components/charts";
import { ResultLayout } from "../components/Layout";
import { HeaderDetail, ReportSection } from "./Report";
import { v4 as uuidv4 } from "uuid";
import { CharacterImage } from "../components/Icon";

export const mergeArr = () => {
    const data = window.overview;
    return data?.data
        .map((item, i) => {
            return { score: item, title: data?.label[i] };
        })
        .sort((a, b) => b.score - a.score);
};

export const _renderDominantInfo = () => {
    return (
        <div>
            <p style={{ fontWeight: 300, fontSize: 14, margin: 0 }}>
                Your dominant learning methods are{" "}
            </p>
            <div className="row dominant-info ">
                <div className="col-xl-10 m-auto ">
                    <div className="row justify-content-around">
                        {mergeArr().map((item, i) => {
                            if (i < 2)
                                return (
                                    <>
                                        <div
                                            className={`outline-icon  ${
                                                window.innerWidth < 800 &&
                                                i === 0
                                                    ? "mb-5"
                                                    : ""
                                            }`}
                                        >
                                            <CharacterImage
                                                name={
                                                    item?.title?.toLowerCase() +
                                                    "-o"
                                                }
                                            />
                                            <h3>
                                                {item?.title}
                                                <br />
                                                <span style={{ fontSize: 14 }}>
                                                    {item?.score}
                                                </span>
                                            </h3>
                                        </div>
                                        {i === 0 && (
                                            <div className="separator" />
                                        )}
                                    </>
                                );
                        })}
                    </div>
                </div>
            </div>
        </div>
    );
};

export const DetailedReport = ({ match }) => {
    const data = window.detailedReport;
    const { sessionId } = match?.params;
    const { user } = window;

    React.useEffect(() => {
        if (user?.payment_status !== 1) {
            window.location = `/transactions/result/${sessionId}`;
        }
    }, []);

    return (
        <ResultLayout
            checkAuth={true}
            bottomButton={{
                text: "View Detailed Report",
                url: `/result/${sessionId}/check-report`,
            }}
        >
            <div className="row justify-content-center detailed-report">
                <HeaderDetail
                    title={"Bio-Data"}
                    dominant={_renderDominantInfo()}
                    cardClassnameclassName="p-2"
                >
                    <div className="col-xl-5 biodata">
                        <div className="row justify-content-between bio-data text-white text-left text-capitalize">
                            <ul>
                                <li>
                                    Sex: <span>{user?.sex}</span>{" "}
                                </li>
                                <li>
                                    Age: <span>{user?.age}</span>{" "}
                                </li>
                                <li>
                                    School: <span>{user?.school}</span>{" "}
                                </li>
                            </ul>

                            <ul>
                                <li>
                                    Class: <span>{user?.class}</span>{" "}
                                </li>
                                <li>
                                    State/Province: <span>{user?.state}</span>{" "}
                                </li>
                                <li>
                                    Country: <span>{user?.country}</span>{" "}
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
                                    width:
                                        window.innerWidth > 800
                                            ? "max-content"
                                            : "100%",
                                    margin: "auto",
                                    marginTop: "1rem",
                                    marginBottom: "2rem",
                                }}
                            >
                                <BarChart
                                    id={uuidv4()}
                                    data={[
                                        {
                                            label: "Summary",
                                            data: window?.overview?.data || [],
                                            backgroundColor: "#526080",
                                        },
                                    ]}
                                    labels={window?.overview?.label || []}
                                />
                            </div>

                            <p className="">
                                {window?.overview?.graph_description}
                            </p>
                        </div>
                    </div>
                </div>

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
