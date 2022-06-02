<script setup>
import { v4 as uuidv4 } from "uuid";
import { onMounted } from "vue";
import Chart from "chart.js/auto";
import { LineController } from "chart.js";

const props = defineProps({
    id: {
        String,
        default: uuidv4(),
    },
    labels: {
        Array,
        default: [],
    },
    title: {
        String,
        default: "",
    },
    data: {
        Array,
        default: [],
    },
});

class LineWithAnnotation extends LineController {
    draw(ease) {
        const ctx = this.chart.ctx;

        LineController.prototype.draw.call(this, ease);

        if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
            const activePoint = this.chart.tooltip._active[0];
            const x = activePoint.element.x;
            const topY = this.chart.scales["y"].top;
            const bottomY = this.chart.scales["y"].bottom;

            ctx.save();
            ctx.beginPath();
            ctx.moveTo(x, topY);
            ctx.lineTo(x, bottomY);
            ctx.lineWidth = 1;
            ctx.strokeStyle = "rgba(0, 0, 0, 0.1)";
            ctx.stroke();
            ctx.restore();
        }
    }
}

LineWithAnnotation.id = "lineWithAnnotation";

Chart.register(LineWithAnnotation);

const colors = { primary: "20, 83, 136" };

onMounted(() => {
    const ctx = document.getElementById(props.id);
    if (ctx) {
        ctx.getContext("2d");
        new Chart(ctx, {
            type: "lineWithAnnotation",
            plugins: [
                {
                    afterInit: (chart) => {
                        const info = chart.canvas.parentNode;

                        const value = chart.data.datasets[0].data[0];
                        const heading = chart.data.datasets[0].label;
                        const label = chart.data.labels[0];

                        info.querySelector(".chart-heading").innerHTML =
                            heading;
                        info.querySelector(".chart-value").innerHTML =
                            "$" + value;
                        info.querySelector(".chart-label").innerHTML = label;
                    },
                },
            ],
            data: {
                labels: props.labels,
                datasets: [
                    {
                        label: props.title,
                        data: props.data,
                        borderColor: "rgba(" + colors.primary + ")",
                        borderWidth: 2,
                        pointBorderColor: "rgba(" + colors.primary + ")",
                        pointBorderWidth: 4,
                        pointRadius: 2,
                        pointHoverBackgroundColor:
                            "rgba(" + colors.primary + ")",
                        pointHoverBorderColor: "#ffffff",
                        pointHoverRadius: 2,
                        tension: 0.5,
                    },
                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: false,
                        intersect: false,
                        external: (ctx) => {
                            const info = ctx.chart.canvas.parentNode;

                            const value =
                                ctx.tooltip.dataPoints[0].formattedValue;
                            const heading =
                                ctx.tooltip.dataPoints[0].dataset.label;
                            const label = ctx.tooltip.dataPoints[0].label;

                            info.querySelector(".chart-heading").innerHTML =
                                heading;
                            info.querySelector(".chart-value").innerHTML =
                                "$" + value;
                            info.querySelector(".chart-label").innerHTML =
                                label;
                        },
                    },
                },
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: false,
                    },
                },
                layout: {
                    padding: {
                        left: 5,
                        right: 5,
                        top: 10,
                        bottom: 10,
                    },
                },
            },
        });
    }
});
</script>

<template>
    <canvas :id="id"></canvas>
</template>
