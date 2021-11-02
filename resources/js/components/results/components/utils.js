import React, { useState } from "react";
import { Link } from "react-router-dom";

import { SvgIcon } from "./Icon";
import { GaugeChart } from "./charts";
import { v4 } from "uuid";

export const XButton = ({
    url = "#",
    text,
    action,
    style = { fontSize: 18 },
}) => {
    return (
        <a
            href={url}
            onClick={(e) => {
                action && e.preventDefault();
                action && action();
            }}
            className="btn btn-md btn-facebook btn-pill animate-up-2 p-2 pr-4 pl-4"
            style={style}
        >
            {text}
        </a>
    );
};

function hexToRGBA(hex, opacity) {
    if (hex.includes("rgb")) return hex;
    return (
        "rgba(" +
        (hex = hex.replace("#", ""))
            .match(new RegExp("(.{" + hex.length / 3 + "})", "g"))
            .map(function (l) {
                return parseInt(hex.length % 2 ? l + l : l, 16);
            })
            .concat(isFinite(opacity) ? opacity : 1)
            .join(",") +
        ")"
    );
}


// "guagechart": {
//     "title": "Your highest strength in Brainy is Reading",
//     "description": "You scored 63% in Reading which is your highest score in the Brainy Category.",
//     "charttext": "Reading 63%",
//     "percent": 63,
//     "color": {
//         "primary": "#F1A355",
//         "light": "#F9E2BF"
//     }
// }

export const LineGaugeDetails = ({ guagechart, color, allmax, sectionTitle }) => {

    const getTitle = () => {
        if(allmax?.length > 1) {
            return `Your highest strengths in ${sectionTitle} are ${allmax[0]?.title} and ${allmax[1]?.title}.`;
        }
        return `Your highest strength in ${sectionTitle} is ${guagechart?.title}`;
    }

    const getDescription = () => {

    }

    return (
        <div className="row mb-3">
            <div className="col-xl-12">
                <div class="card no-shadow" style={{ border: "none" }}>
                    <div
                        class={`card-body`}
                        style={{
                            backgroundColor: hexToRGBA(color?.light, 0.25),
                        }}
                    >
                        <div className="row justify-content-center">
                            <div className="col-xl-3">
                                <GaugeChart
                                    percent={guagechart?.score}
                                    color={guagechart?.color || color}
                                />
                            </div>
                            <div className="col-xl-7">
                                <div
                                    className="vertical-center-x"
                                    // style={{ marginTop: 30 }}
                                >
                                    <p
                                        style={{
                                            color: color?.primary,
                                            borderBottom: "1px solid",
                                            paddingBottom: "0.5rem",
                                            marginBottom: "0.5rem",
                                        }}
                                    >
                                        {getTitle()}
                                    </p>
                                    <p className="m-0" style={{ fontSize: 14 }}>
                                        {guagechart?.description}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export const AlignItemsList = ({
    reports = [],
    color,
    recommendations,
    resources,
    bottomCardTitle = "Short Recommendation",
    detailed,
    sectionTitle
}) => {

    const getGuageChart = () => {
        const highest = reports.reduce((acc, shot) => acc = acc > shot.score ? acc : shot.score, 0);
        const d = reports.filter(e => e.score === highest) || [];
        return { max: d.length > 0 ? d[0] : null , count: d };
    }

    React.useEffect(() => {
        console.log("ENGINE:  ", getGuageChart());

    }, [])

    return (
        <div className="list-group summary-list ">
            {reports.map((item, i) => {
                return (
                    <a
                        key={v4()}
                        href="#"
                        className="list-group-item-action "
                        aria-current="true"
                    >
                        <div
                            className="d-flex w-100 line-title"
                            style={{
                                borderBottomColor: color?.primary,
                            }}
                        >
                            <span>
                                <SvgIcon
                                    name={item.icon}
                                    color={color?.primary}
                                />
                            </span>
                            <h5
                                className="mb-1"
                                style={{ color: color?.primary }}
                            >
                                {item.title}
                            </h5>
                        </div>
                        <p className="mb-1">{item.description}</p>
                        {item?.recommendations && (
                            <>
                                <div className="mb-3">
                                    <p className="text-left mb-0 font-weight-bold mt-3">
                                        Recommendations
                                    </p>

                                    <ul
                                        style={{
                                            listStyle: "disc",
                                            marginLeft: "1rem",
                                        }}
                                    >
                                        {(item?.recommendations || []).map(
                                            (item, i) => {
                                                return (
                                                    <li>
                                                        <p className="m-0 linkard"
                                                            dangerouslySetInnerHTML={{ __html: item }}
                                                        />
                                                    </li>
                                                );
                                            }
                                        )}
                                    </ul>
                                </div>
                            </>
                        )}

                        {detailed && getGuageChart().max && getGuageChart()?.max?.title === item.title && (
                            <LineGaugeDetails
                                key={v4()}
                                guagechart={getGuageChart().max}
                                color={color}
                                allmax={getGuageChart().count}
                                sectionTitle={sectionTitle}
                            />
                        )}
                    </a>
                );
            })}

            {(recommendations || []).length > 0 || resources && (
                <>
                    <div
                        class="card after-list mt-3"
                        style={{ backgroundColor: color?.light }}
                    >
                        <div class="card-body">
                            <div className="mb-3">
                                <p
                                    className="text-center"
                                    style={{
                                        color: color?.primary,
                                        borderBottom: "1px solid",
                                        paddingBottom: "0.5rem",
                                        marginBottom: "0.5rem",
                                    }}
                                >
                                    {bottomCardTitle}
                                </p>
                                {resources && (
                                    <ul
                                        style={{
                                            listStyle: "disc",
                                            marginLeft: "1rem",
                                        }}
                                        dangerouslySetInnerHTML={{ __html: resources }}
                                    />
                                )||(
                                <ul
                                    style={{
                                        listStyle: "disc",
                                        marginLeft: "1rem",
                                    }}
                                >
                                    {recommendations.map(
                                        (item, i) => {
                                            return (
                                                <li>
                                                    <p className="m-0 linkard" 
                                                        dangerouslySetInnerHTML={{ __html: item }}
                                                    />
                                                </li>
                                            );
                                        }
                                    )}
                                </ul>
                                )}
                            </div>
                        </div>
                    </div>
                </>
            )}
        </div>
    );
};

