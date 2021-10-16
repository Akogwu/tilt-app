import React from "react";
import { Link } from "react-router-dom";
import { XButton } from "./utils";

export const ResultLayout = ({
    children,
    bottomButton = { text: "Download", url: "#" },
    containerStyle = {}
}) => {
    return (
        <section
            class="section bg-main overlay-gray-100 text-black"
            data-background=""
        >
            <div className="container-fluid" style={containerStyle}>{children}</div>
            <div className="bottom-button">
                <XButton {...bottomButton} />
            </div>
        </section>
    );
};
