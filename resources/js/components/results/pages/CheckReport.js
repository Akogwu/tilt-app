import React from "react";
import { ResultLayout } from "../components/Layout";
import { mergeArr } from "./DetailedReport";


const getDominant = () => {
    return mergeArr()[0];
}

export const CheckReport = ({ match }) => {
    const { sessionId } = match?.params;

    return (
        <ResultLayout
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
                                Dominant: {getDominant().title}
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
