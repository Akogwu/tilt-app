import React from "react";
import { Link } from "react-router-dom";

import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import Divider from "@mui/material/Divider";
import ListItemText from "@mui/material/ListItemText";
import ListItemAvatar from "@mui/material/ListItemAvatar";
import Avatar from "@mui/material/Avatar";
import Typography from "@mui/material/Typography";
import { SvgIcon } from "./Icon";

export const XButton = ({ url = "#", text, action, style = { fontSize: 18 } }) => {
    return (
        <Link
            to={url}
            onClick={e => {
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

export const AlignItemsList = ({ reports=[], color, recommendations=[] }) => {
    return (
        <div className="list-group summary-list">
            {reports.map((item, i) => {
                return (
                    <a
                        href="#"
                        className="list-group-item-action "
                        aria-current="true"
                    >
                        <div className="d-flex w-100 line-title" style={{
                            borderBottomColor: color?.primary
                        }}>
                            <span>
                                <SvgIcon name={item.icon} color={color?.primary} />
                            </span>
                            <h5 className="mb-1" style={{ color: color?.primary }}>{item.title}</h5>
                        </div>
                        <p className="mb-1">
                           {item.description}
                        </p>
                    </a>
                );
            })}

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
                            Short Recommendation
                        </p>

                        <ul style={{ listStyle: "disc", marginLeft: "1rem" }}>
                            {recommendations.map((item, i) => {
                                return (
                                    <li>
                                        <p className="m-0">
                                           {item}
                                        </p>
                                    </li>
                                );
                            })}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
};
