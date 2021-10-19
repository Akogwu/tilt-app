import React from "react";
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
        <Link
            to={url}
            onClick={(e) => {
                action && e.preventDefault();
                action && action();
            }}
            className="btn btn-md btn-facebook btn-pill animate-up-2 p-2 pr-4 pl-4"
            style={style}
        >
            {text}
        </Link>
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

export const LineGaugeDetails = ({ guagechart, color }) => {
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
                                    percent={guagechart?.percent}
                                    color={guagechart?.color || color}
                                />
                            </div>
                            <div className="col-xl-7">
                                <div
                                    className="vertical-center-x"
                                    style={{ marginTop: 30 }}
                                >
                                    <p
                                        style={{
                                            color: color?.primary,
                                            borderBottom: "1px solid",
                                            paddingBottom: "0.5rem",
                                            marginBottom: "0.5rem",
                                        }}
                                    >
                                        {guagechart?.title}
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
}) => {
    return (
        <div className="list-group summary-list">
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
                                                        <p className="m-0">
                                                            {item}
                                                        </p>
                                                    </li>
                                                );
                                            }
                                        )}
                                    </ul>
                                </div>
                            </>
                        )}

                        {item?.guagechart && (
                            <LineGaugeDetails
                                key={v4()}
                                guagechart={item?.guagechart}
                                color={color}
                            />
                        )}
                    </a>
                );
            })}

            {(recommendations || resources || []).length > 0 && (
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

                                <ul
                                    style={{
                                        listStyle: "disc",
                                        marginLeft: "1rem",
                                    }}
                                >
                                    {(recommendations || resources || []).map(
                                        (item, i) => {
                                            return (
                                                <li>
                                                    <p className="m-0">
                                                        {item}
                                                    </p>
                                                </li>
                                            );
                                        }
                                    )}
                                </ul>
                            </div>
                        </div>
                    </div>
                </>
            )}
        </div>
    );
};
