<script setup>
import { v4 as uuidv4 } from "uuid";
import { onMounted } from "vue";
import Chart from "chart.js/auto";
import { BarController } from "chart.js";

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

class BarWithShadow extends BarController {
    draw(ease) {
        const ctx = this.chart.ctx;

        BarController.prototype.draw.call(this, ease);
        ctx.save();
        ctx.shadowColor = "rgba(0, 0, 0, 0.25)";
        ctx.shadowBlur = 8;
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 4;
        BarController.prototype.draw.apply(this, arguments);
        ctx.restore();
    }
}

BarWithShadow.id = "barWithShadow";

Chart.register(BarWithShadow);

const colors = { primary: "20, 83, 136" };

onMounted(() => {
    const ctx = document.getElementById(props.id);
    if (ctx) {
        ctx.getContext("2d");
        new Chart(ctx, {
            type: "barWithShadow",
            data: {
                labels: props.labels,
                datasets: props.data,
            },
            options: {
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
