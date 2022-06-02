<script setup>
import { Navigation, Pagination, Autoplay, EffectFade } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import "swiper/css/autoplay";
import "swiper/css/effect-fade";

const props = defineProps({
    images: Object,
    delay: {
        type: Number,
        default: 3000,
    },
});

const autoplay = {
    delay: props.delay,
};

const modules = [Navigation, Pagination, Autoplay, EffectFade];
</script>

<template>
    <Swiper
        :modules="modules"
        loop
        :autoplay="autoplay"
        effect="fade"
        :pagination="{ clickable: true, dynamicBullets: true }"
        :slides-per-view="1"
        :space-between="0"
        :navigation="true"
    >
        <SwiperSlide v-for="(image, index) in images" :key="index">
            <img :src="image.original_url" :alt="image.uuid" />
        </SwiperSlide>
    </Swiper>
</template>

<style>
.swiper {
    width: 100%;
    height: 100%;
    max-height: 600px;
}
.swiper-slide {
    text-align: center;
    font-size: 1.125rem /* 18px */;
    line-height: 1.75rem /* 28px */;
    --tw-bg-opacity: 1;
    background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    display: flex;
    justify-content: center;
    align-items: center;
}
.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.swiper-button-next,
.swiper-button-prev {
    --tw-text-opacity: 1;
    color: rgb(37 34 34 / var(--tw-text-opacity));
}
.swiper-button-next:hover,
.swiper-button-prev:hover {
    --tw-text-opacity: 1;
    color: rgb(251 198 10 / var(--tw-text-opacity));
    transition-property: color, background-color, border-color,
        text-decoration-color, fill, stroke, opacity, box-shadow, transform,
        filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    transition-timing-function: linear;
    transition-duration: 100ms;
}
.swiper-pagination-bullet {
    width: 0.75rem;
    height: 0.75rem;
}
.swiper-pagination-bullet-active {
    --tw-bg-opacity: 1;
    background-color: rgb(251 198 10 / var(--tw-bg-opacity));
}
.swiper {
    margin-left: auto;
    margin-right: auto;
}
</style>
