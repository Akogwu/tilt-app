import * as React from "react";
import Accordion from "@mui/material/Accordion";
import AccordionDetails from "@mui/material/AccordionDetails";
import AccordionSummary from "@mui/material/AccordionSummary";
import Typography from "@mui/material/Typography";
import { CharacterImage } from "./Icon";
import { AlignItemsList, XButton } from "./utils";
import { BarChart } from "./charts";
import { v4 as uuidv4 } from "uuid";

// import ExpandMoreIcon from '@mui/icons-material/ExpandMore';

export const ExpandMoreIcon = ({ color }) => {
    return (
        <div
            className={"fas fa-caret-down"}
            style={{
                padding: "0px 5px",
                border: "2px solid " + color,
                borderRadius: 5,
                fontSize: 25,
                color,
                marginRight: 40,
                marginLeft: 40,
            }}
        ></div>
    );
};

export const MainAccordion = ({ data }) => {
    const [expanded, setExpanded] = React.useState(false);
    const [expandAll, setExpandAll] = React.useState([]);
    const borderArea = React.useRef(null);
    const overviewChart = React.useRef(null);

    const handleChange = (panel) => (event, isExpanded) => {
        setExpanded(isExpanded ? panel : false);
        if (!isExpanded && expandAll.includes(panel)) {
            let d = expandAll;
            const index = d.indexOf(panel);
            if (index > -1) {
                d.splice(index, 1);
                setExpandAll([...d]);
            }
        }
    };

    const getOffSet = () => {
        const w = borderArea?.current?.clientWidth;
        const offSet = (window.screen.width - w) / 2;
        return -offSet;
    };

    return (
        <>
            {expandAll.length < 1 && (
                <div
                    className="row justify-content-end"
                    style={{
                        margin: 20,
                        marginTop: 30,
                        marginRight: 0,
                    }}
                >
                    <XButton
                        text={"Expand All"}
                        action={() => {
                            setExpandAll([
                                ...data.map((item, i) => {
                                    return i + 1;
                                }),
                            ]);
                        }}
                        style={{ fontSize: 14 }}
                    />
                </div>
            )}
            <div>
                {data.map((item, i) => {
                    return (
                        <Accordion
                            key={uuidv4()}
                            expanded={
                                expanded === i + 1 || expandAll.includes(i + 1)
                            }
                            onChange={handleChange(i + 1)}
                            style={{
                                background:
                                    expanded === i + 1 ||
                                    expandAll.includes(i + 1)
                                        ? "transparent"
                                        : item?.color?.light,
                            }}
                            classes={{
                                root: "accordion-summary",
                                rounded: "accordion-rounded",
                                expanded: "accordion-expanded",
                                gutters: "accordion-gutters",
                                region: "accordion-region",
                            }}
                        >
                            <AccordionSummary
                                expandIcon={
                                    <ExpandMoreIcon
                                        color={item?.color?.primary}
                                    />
                                }
                                aria-controls="panel1bh-content"
                                style={{
                                    background:
                                        expanded === i + 1 ||
                                        expandAll.includes(i + 1)
                                            ? item?.color?.light
                                            : "transparent",
                                    borderRadius: 10,
                                }}
                            >
                                <div className="accordion-icon">
                                    <div className="outline-icon">
                                        <div style={{ width: 120 }}>
                                            <CharacterImage
                                                name={
                                                    item?.title?.toLowerCase() +
                                                    "-o"
                                                }
                                            />
                                        </div>
                                        <h3
                                            style={{
                                                color: item?.color?.primary,
                                            }}
                                        >
                                            {item?.title}
                                        </h3>
                                    </div>
                                </div>
                            </AccordionSummary>
                            <AccordionDetails>
                                <div
                                    ref={borderArea}
                                    className="container mt-4"
                                >
                                    <div className="col-sm-9 m-auto">
                                        <div className="row">
                                            <div className="col-sm-8">
                                                <div
                                                    className="summary"
                                                    style={{
                                                        marginTop: "3rem",
                                                        marginBottom: "3rem",
                                                    }}
                                                >
                                                    <p className="">
                                                        {item?.description}
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="col-sm-4">
                                                <div className="summary-big-character">
                                                    <CharacterImage
                                                        name={item?.title?.toLowerCase()}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        ref={overviewChart}
                                        className="overview-chart justify-content-center"
                                        style={{
                                            position: "relative",
                                            background: item?.color?.light,
                                            width: window.screen.width,
                                            marginLeft: getOffSet() - 15,
                                            padding: 30,
                                            marginBottom: 40
                                        }}
                                    >
                                        <div className="row m-auto">
                                            <div className="col-sm-7 m-auto">
                                                <p
                                                    className="text-center"
                                                    style={{
                                                        color: item?.color
                                                            ?.primary,
                                                        paddingBottom: "0.5rem",
                                                        marginBottom: "0.75rem",
                                                    }}
                                                >
                                                    Overview
                                                </p>
                                                <div className="row">
                                                    <div className="col-xl-6 inline-chart">
                                                        <BarChart
                                                            {...item?.chart}
                                                            cardStyle={{
                                                                width: 400,
                                                                height: 250,
                                                            }}
                                                            height={180}
                                                        />
                                                    </div>
                                                    <div
                                                        className="col-xl-6"
                                                        style={{
                                                            alignItems:
                                                                "center",
                                                            display: "flex",
                                                        }}
                                                    >
                                                        <p className="p-4 m-0 right-description">
                                                            {item?.description}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-sm-9 m-auto">
                                        <AlignItemsList
                                            color={item?.color}
                                            resources={item?.resources}
                                            reports={item?.reports}
                                            bottomCardTitle={"Resources"}
                                        />
                                    </div>
                                </div>
                            </AccordionDetails>
                        </Accordion>
                    );
                })}
            </div>

            {expandAll.length > 0 && (
                <div
                    className="row justify-content-end"
                    style={{
                        margin: 20,
                        marginTop: 30,
                        marginRight: 0,
                    }}
                >
                    <XButton
                        text={"Collapse All"}
                        action={() => setExpandAll([])}
                        style={{ fontSize: 14 }}
                    />
                </div>
            )}
        </>
    );
};
