import React from "react";

import Chart from "chart.js/auto";
import { getRelativePosition } from "chart.js/helpers";

export const BarChart = (props) => {
    const { cardStyle = { width: 500, height: 350 }, height=200, data = [], labels = [] } = props;
    const _chart = React.useRef(null);

    const formatDataObject = () => {
        if(!data) return [];
        console.log(data)
        return data?.map((item) => {
            return {
                ...item,
                ...{
                    barThickness: 10,
                    borderRadius: {
                        topLeft: 5,
                        topRight: 5,
                        bottomLeft: 0,
                        bottomRight: 0,
                    },
                    borderWidth: 2,
                    borderColor: "transparent",
                },
            };
        });
    };

    React.useEffect(() => {
        var myChart = new Chart(_chart.current, {
            type: "bar",
            data: {
                labels,
                datasets: formatDataObject()
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: "rgba(228, 228, 228, 0.2)",
                            borderColor: "transparent",
                            stacked: true,
                        },
                        ticks: {
                            font: {
                                family: '"Nunito Sans", sans-serif',
                                color: "#999999",
                            },
                        },
                    },
                    x: {
                        grid: {
                            display: false,
                            borderColor: "transparent",
                        },
                        ticks: {
                            font: {
                                family: '"Nunito Sans", sans-serif',
                                color: "#999999"
                            }
                        },
                    },
                },
                plugins: {
                    legend: {
                        align: "start",
                        position: "top",
                        labels: {
                            font: {
                                family: '"Nunito Sans", sans-serif',
                                weight: "bold",
                            },
                            pointStyle: "circle",
                            usePointStyle: true,
                        },
                    },
                },
            },
        });
        // myChart.destroy();
    }, [props]);
    return (
        <div className="card" style={cardStyle}>
            <div className={`card-body`}>
                <canvas ref={_chart} height={height}></canvas>
            </div>
        </div>
    );
};

export const GaugeChart = (props) => {
    const { percent=0, height=130, data = [], color={primary: "black", light: "white"} } = props;
    const _chart = React.useRef(null);
    React.useEffect(() => {
        var myChart = new Chart(_chart.current, {
            type: "doughnut",
           data: {
            datasets: [{
              label: 'Reading 63%',
              data: [percent, 100 - percent],
              backgroundColor: [
                color?.primary,
                color?.light
              ],
              hoverOffset: 0,
              borderWidth: 0,
              weight: 10
            }]
          },
          options: {
              responsive: true,
              plugins: {
                  legend: {
                      display: false
                  }
              },
              cutout: "90%",
              rotation: 90,
              radius: 65
          }
        });
        // myChart.destroy();
    }, [props]);
    return (
            <canvas ref={_chart} height={height}></canvas>
    );
};
