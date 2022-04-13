<script setup>
import { v4 as uuidv4 } from "uuid";
import { onMounted } from "vue";
import Chart from "chart.js/auto";
import { LineElement, PolarAreaController } from "chart.js";

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

class LineWithShadowElement extends LineElement {
    draw(ctx) {
        const originalStroke = ctx.stroke;

        ctx.stroke = function () {
            ctx.save();
            ctx.shadowColor = "rgba(0, 0, 0, 0.25)";
            ctx.shadowBlur = 8;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 4;
            originalStroke.apply(this, arguments);
            ctx.restore();
        };

        LineElement.prototype.draw.apply(this, arguments);
    }
}

LineWithShadowElement.id = "lineWithShadowElement";

Chart.register(LineWithShadowElement);

class PolarAreaWithShadow extends PolarAreaController {}

PolarAreaWithShadow.id = "polarAreaWithShadow";
PolarAreaWithShadow.defaults = {
    datasetElementType: "lineWithShadowElement",
};

Chart.register(PolarAreaWithShadow);

const colors = { primary: "20, 83, 136" };

onMounted(() => {
    const ctx = document.getElementById(props.id);
    if (ctx) {
        ctx.getContext("2d");
        new Chart(ctx, {
            type: "polarAreaWithShadow",
            data: {
                labels: props.labels,
                datasets: [
                    {
                        data: props.data,
                        backgroundColor: [
                            "rgba(" + colors.primary + ", .1)",
                            "rgba(" + colors.primary + ", .5)",
                            "rgba(" + colors.primary + ", .25)",
                        ],
                        borderColor: "rgba(" + colors.primary + ")",
                        borderWidth: 2,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                        },
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
                    r: {
                        ticks: {
                            display: false,
                        },
                    },
                },
                layout: {
                    padding: 5,
                },
            },
        });
    }
});
</script>

<template>
    <canvas :id="id"></canvas>
</template>
