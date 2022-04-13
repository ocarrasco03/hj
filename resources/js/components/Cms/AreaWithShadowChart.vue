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
    data: {
        Array,
        default: [],
    },
});

class LineWithShadow extends LineController {}

LineWithShadow.id = "lineWithShadow";
LineWithShadow.defaults = {
    datasetElementType: "lineWithShadowElement",
};

Chart.register(LineWithShadow);

const colors = { primary: "20, 83, 136" };

onMounted(() => {
    const ctx = document.getElementById(props.id);
    if (ctx) {
        ctx.getContext("2d");
        new Chart(ctx, {
            type: "lineWithShadow",
            data: {
                labels: props.labels,
                datasets: [
                    {
                        data: props.data,
                        backgroundColor: "rgba(" + colors.primary + ", .1)",
                        borderColor: "rgba(" + colors.primary + ")",
                        borderWidth: 2,
                        fill: true,
                        pointBackgroundColor: "#ffffff",
                        pointBorderColor: "rgba(" + colors.primary + ")",
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverBackgroundColor:
                            "rgba(" + colors.primary + ")",
                        pointHoverBorderColor: "#ffffff",
                        pointHoverBorderWidth: 2,
                        pointHoverRadius: 6,
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
                        backgroundColor: "#ffffff",
                        borderColor: "#dddddd",
                        borderWidth: 0.5,
                        bodyColor: "#555555",
                        bodySpacing: 8,
                        cornerRadius: 4,
                        padding: 16,
                        titleColor: "rgba(" + colors.primary + ")",
                    },
                },
                scales: {
                    y: {
                        grid: {
                            display: true,
                            drawBorder: false,
                        },
                        min: 0,
                        max: 20,
                        ticks: {
                            stepSize: 5,
                        },
                    },
                    x: {
                        grid: {
                            display: false,
                        },
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
