import React from "react";
import { Link } from "react-router-dom";
import { ResultLayout } from "../components/Layout";

export const Welcome = () => {
    return (
        <ResultLayout
            bottomButton={{ text: "View Report", url: "/result/report" }}
        >
            <div className="row justify-content-center">
                <div className="col-md-12 bg-white text-center welcome-board">
                    <img src={require("../assets/images/267_party_outline.png").default}  />
                    <h1 className="text-success" style={{ fontSize: 45, marginBottom: 15 }}>Congratulations!!</h1>
                    <p style={{ fontWeight: "bolder", fontSize: 18, marginBottom: 0 }}>You completed the test. Now let's see the results!</p>
                </div>
            </div>
        </ResultLayout>
    );
};
