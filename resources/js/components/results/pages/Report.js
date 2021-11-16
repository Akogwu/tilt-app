import Divider from "@mui/material/Divider";
import React from "react";
import { CharacterImage } from "../components/Icon";
import { ResultLayout } from "../components/Layout";
import { AlignItemsList, XButton } from "../components/utils";
import { v4 } from "uuid";

export const HeaderDetail = ({
    children,
    title = window?.user?.name,
    dominant,
    cardClass = "",
    sessionId,
}) => {
    return (
        <>
            <div className="col-md-12 bg-gray text-center about-header-board">
                {(window?.user?.image_url && (
                    <div className="passport-holder">
                        {" "}
                        <img
                            className="passport-photo"
                            src={window?.user?.image_url}
                        />
                    </div>
                )) || (
                    <span>
                        {" "}
                        <i
                            className="user-icon fas fa-user-circle"
                            style={{
                                fontSize: 75,
                                color: "rgba(255,255,255,0.85)",
                            }}
                        />{" "}
                    </span>
                )}
                <h1
                    className="text-white"
                    style={{ fontSize: 22, marginBottom: 0, marginTop: 30 }}
                >
                    {title}
                </h1>
                {(children && children) || (
                    <p
                        className="text-white"
                        style={{
                            fontWeight: "bolder",
                            fontSize: 18,
                            marginBottom: 0,
                        }}
                    >
                        {window?.user?.email}
                    </p>
                )}
            </div>

            <div className="container">
                <div className="row">
                    <div className="col-xl-10 m-auto">
                        <div class="card header-summary-board text-center">
                            <div class={`card-body ${cardClass}`}>
                                {(dominant && dominant) || (
                                    <>
                                        <div className="mb-3">
                                            Here is the summary of your result.
                                            Click the button below to view the
                                            detailed result.
                                        </div>

                       
                                        {window?.user?.payment_status === 1 && (

                                        <XButton
                                            text={"View Detailed Report"}
                                            url={`/result/${sessionId}/check-report`}
                                            style={{ fontSize: 14 }}
                                        />
                                        ) || (
                                            <XButton
                                                text={"Pay Now"}
                                                url={`/transactions/result/${sessionId}`}
                                                style={{
                                                    background: "red",
                                                    borderWidth: 0,
                                                    fontSize: 14
                                                }}
                                            />

                                        )}

                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export const ReportSection = ({
    title,
    recommendations,
    description,
    reports,
    color,
    moredetaillink,
    detailed = false,
}) => {

    const summaryText = () => {
        return (
            <div className="col-sm-8">
                            <div
                                className="summary"
                                style={{
                                    marginTop: "3rem",
                                    marginBottom: "3rem",
                                }}
                            >
                                <p className="">{description}</p>
                            </div>
                        </div>
        )
    }

    const summaryImage = () => {
        return (
            <div className="col-sm-4">
                            <div className="summary-big-character">
                                <CharacterImage name={title?.toLowerCase()} />
                            </div>
                        </div>
        )
    }

    return (
        <div className="col-xl-12 p-0 report-section theme-green ">
            <div
                className="section-title"
                style={{
                    background: color?.light,
                }}
            >
                <div className="container">
                    <div className="col-sm-9 m-auto">
                        <h4
                            style={{
                                color: color?.primary,
                            }}
                        >
                            {title}
                        </h4>
                    </div>
                </div>
            </div>
            <div className="container mt-4">
                <div className="col-sm-9 m-auto">
                    <div className="row">

                        {window.innerWidth > 800 && (
                            <>
                                {summaryText()}
                                {summaryImage()}
                            </>
                        )||(
                            <>
                                {summaryImage()}
                                {summaryText()}
                            </>
                        )}

                        

                    </div>
                </div>
            </div>
            <div className="container">
                <div className="col-sm-9 m-auto">
                    <AlignItemsList
                        color={color}
                        recommendations={recommendations}
                        reports={reports}
                        detailed={detailed}
                    />
                </div>
                {moredetaillink && (
                    <div className="col-xl-8 m-auto">
                        <i className="fa fa-exclamation-square" />{" "}
                        <p
                            style={{
                                fontStyle: "italic",
                                fontSize: 16,
                                margin: "auto",
                            }}
                        >
                            The detailed report has more recommendations and
                            added resources.{" "}
                            <a className="alink" href={moredetaillink}>
                                Get the detailed report here.
                            </a>
                        </p>
                    </div>
                )}
            </div>
        </div>
    );
};

export const Report = ({ match }) => {
    const data = window?.report || []; // require("../sampledata/report.json");
    const { sessionId } = match?.params;
    const { user } = window;

    return (
        <ResultLayout
            bottomButton={
                user?.payment_status === 1
                    ? {
                          text: "View Detailed Report",
                          url: `/result/${sessionId}/check-report`,
                      }
                    : {
                          text: "Pay now",
                          url: `/transactions/result/${sessionId}`,
                          style: {
                              background: "red",
                              borderWidth: 0
                          },
                      }
            }
        >
            <div className="row justify-content-center">
                <HeaderDetail sessionId={sessionId} />
                <div className="container">
                    <div className="col-xl-12">
                        <Divider style={{ marginTop: 50, marginBottom: 30 }}>
                            <h4
                                style={{
                                    margin: 0,
                                    marginLeft: 20,
                                    marginRight: 20,
                                    color: "#526080",
                                }}
                            >
                                Overview
                            </h4>
                        </Divider>

                        <div className="col-sm-9 m-auto p-0">
                            <p className=""
                                dangerouslySetInnerHTML={{ __html: window.graph_overview }}
                            />
                        </div>
                    </div>
                </div>
                {data.map((item, i) => {
                    return <ReportSection key={v4()} {...item} />;
                })}

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
