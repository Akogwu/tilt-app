import React from "react";
import { ResultLayout } from "../components/Layout";

export const CheckReport = () => {
    return (
        <ResultLayout
            bottomButton={{
                text: "View Report",
                url: "/result/detailed-report",
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
                                    require("../assets/images/photo.png")
                                        .default
                                }
                                width={145}
                            />
                            <h1
                                style={{
                                    fontSize: 20,
                                    marginBottom: 0,
                                    marginTop: 10,
                                }}
                            >
                                Oni Oyintomiwa
                            </h1>
                            <p
                                style={{
                                    fontWeight: "bolder",
                                    fontSize: 14,
                                    margin: 0,
                                }}
                            >
                                Dominant: Puter
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
