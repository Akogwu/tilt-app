import React from "react";
import { ResultLayout } from "../components/Layout";
import { mergeArr } from "./DetailedReport";


const getDominant = () => {
    return mergeArr()[0];
}

export const CheckReport = ({ match }) => {
    const { sessionId } = match?.params;

    React.useEffect(() => {
        const { user } = window;
        if(user?.payment_status !== 1){
            window.location = `/transactions/result/${sessionId}`
        }
    }, [])

    return (
        <ResultLayout
            checkAuth={true}
            bottomButton={{
                text: "View Report",
                url: `/result/${sessionId}/detailed-report`,
            }}
            containerStyle={{ paddingRight: 0, paddingLeft: 0 }}
        >
            <div className="check-header-board-holder w-100 bg-white">
                <div className="container">
                    <div className="col-md-12 m-auto check-header-board">
                        <div className="picture-holder ">
                            <img
                                className="passport-photo"
                                src={
                                    window?.user?.image_url
                                }
                                width={145}
                                style={{ borderRadius: 10 }}
                            />
                            <h1
                                style={{
                                    fontSize: 20,
                                    marginBottom: 0,
                                    marginTop: 10,
                                }}
                            >
                                {window?.user?.name}
                            </h1>
                            <p
                                style={{
                                    fontWeight: "bolder",
                                    fontSize: 14,
                                    margin: 0,
                                }}
                            >
                                {/* Dominant: {getDominant().title} */}
                                Dominant: <strong>{mergeArr().map((item, i) => { 
                                    if(i < 2) return item.title + (i === 0 ? " & ": "")
                                })}</strong>
                            </p>
                        </div>
                        <h1
                            className="text-success text-center"
                            style={{
                                fontSize: 36,
                                marginBottom: 0,
                                marginTop: 200,
                                justifyContent: "center",
                                alignSelf: "baseline",
                            }}
                        >
                            Assessment Results
                        </h1>
                        <div className="check-about-footer">
                            <div className="check-about-footer-overlay" />
                            <img
                                src={
                                    require("../assets/images/bg-library.png")
                                        .default
                                }
                            />
                        </div>
                    </div>
                </div>
            </div>
        </ResultLayout>
    );
};
