<script setup>
import { Navigation, Pagination, Autoplay, EffectFade } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/autoplay";
import "swiper/css/effect-fade";
import "../../../public/css/app.css";

const autoplay = {
    delay: 4000
}

const modules = [Navigation, Pagination, Autoplay, EffectFade];
</script>

<template>
    <Swiper
        :modules="modules"
        loop
        :autoplay="autoplay"
        effect="fade"
        :pagination="{ clickable: true }"
        :slides-per-view="1"
        :space-between="0"
    >
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/amortiguadores.jpg"
            />
        </SwiperSlide>
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/balatas de disco.jpg"
            />
        </SwiperSlide>
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/banda de tiempo.jpg"
            />
        </SwiperSlide>
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/banda micro v.jpg"
            />
        </SwiperSlide>
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/barra de direccion.jpg"
            />
        </SwiperSlide>
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/base de amortiguador.jpg"
            />
        </SwiperSlide>
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/bomba y toma de agua.jpg"
            />
        </SwiperSlide>
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/bota cv joint.jpg"
            />
        </SwiperSlide>
        <SwiperSlide>
            <img
                src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-11/images/bujes.jpg"
            />
        </SwiperSlide>
    </Swiper>
</template>
