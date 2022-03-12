<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import SectionTitle from "@/Components/SectionTitle.vue";
import TargetIcon from "@/Icons/Target.vue";
import AwardIcon from "@/Icons/Award.vue";
import BalanceIcon from "@/Icons/Balance.vue";
import EyeIcon from "@/Icons/Eye.vue";
import Slider from "@/Components/Slider.vue";
</script>

<template>
    <Head title="Corporativo" />
    <Slider />
    <SectionTitle :primary="true">
        <h4>Corporativo</h4>
    </SectionTitle>
    <section class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-3">
            <i class="fas fa-quote-left text-4xl -mt-2"></i>
            <p>
                Somos una empresa 100% Mexicana líder en: Innovación,
                desarrollo, fabricación y comercialización de autopartes en el
                mercado global, con presencia en mercados INTERNACIONALES como
                Estados Unidos, Colombia, Guatemala, Costa Rica, El Salvador,
                Perú, Ecuador, Venezuela, Chile, Brasil, Bolivia, Canadá,
                Líbano, Israel, etc. Consolidando cada una de nuestras marcas
                como líderes indiscutibles en cada uno de sus segmentos,
                forjando valor a través de nuestra cadena productiva única en el
                mercado de autopartes; generando excelentes niveles de
                rentabilidad para nuestros clientes.”
            </p>
        </div>
        <div
            class="flex flex-col sm:flex-row space-y-4 sm:space-x-4 items-stretch my-5"
        >
            <div class="flex flex-col items-center flex-1">
                <h2 class="text-center mb-5">Misión</h2>
                <TargetIcon />
                <p class="mt-10">
                    &ldquo;Somos empresas con enfoque al cliente y alto sentido
                    de responsabilidad, generadoras de beneficios a todos los
                    involucrados, con liderazgo genuino y aportación
                    social&rdquo;.
                </p>
            </div>
            <div class="flex flex-col items-center flex-1">
                <h2 class="text-center mb-5">Cualidades</h2>
                <AwardIcon />
                <ul class="mt-5 list-disc">
                    <li>Compromiso</li>
                    <li>Implicación</li>
                    <li>Empatía</li>
                    <li>Productividad</li>
                    <li>Viabilidad</li>
                    <li>Visión</li>
                    <li>Innovación</li>
                    <li>Pensamiento Estratégico</li>
                </ul>
            </div>
            <div class="flex flex-col items-center flex-1">
                <h2 class="text-center mb-5">Visión</h2>
                <EyeIcon />
                <p class="mt-16">
                    &ldquo;Desarrollar Cultura Innovadora, a través de Modelos
                    de Negocios Sustentables con Niveles de Competencia Mundial
                    y en Evolución Constante&rdquo;.
                </p>
            </div>
        </div>
        <div class="flex flex-col space-y-5 items-center flex-1">
            <h2 class="text-center">Nuestros Valores</h2>
            <BalanceIcon />
            <ul class="w-full">
                <li>
                    <h4 class="font-bold">Espíritu de Servicio:</h4>
                    <p>
                        Actuamos siempre pensando en ayudar, por lo que cumplir
                        con los requisitos de nuestros clientes, tanto externos
                        como internos, y partes interesadas, es nuestra
                        prioridad.
                    </p>
                </li>
                <li>
                    <h4 class="font-bold">Responsabilidad:</h4>
                    <p>
                        Cumplimos nuestras obligaciones, especialmente con las
                        funciones que el puesto nos confiere, en tiempo y forma.
                    </p>
                </li>
                <li>
                    <h4 class="font-bold">Honestidad:</h4>
                    <p>Procedemos con rectitud e integridad.</p>
                </li>
                <li>
                    <h4 class="font-bold">Ética:</h4>
                    <p>
                        Nos conducimos y tomamos decisiones basados en lo que es
                        correcto.
                    </p>
                </li>
                <li>
                    <h4 class="font-bold">Confianza:</h4>
                    <p>
                        Creemos en nosotros mismos y en los demás, en sus buenas
                        intenciones, capacidades y acciones. Actuamos con
                        congruencia, cumpliendo nuestros compromisos, de tal
                        manera que generamos y mantenemos la confianza de los
                        demás.
                    </p>
                </li>
                <li>
                    <h4 class="font-bold">Lealtad:</h4>
                    <p>
                        Estamos comprometidos con nuestra misión, visión y
                        valores, por lo que defendemos y vivimos en todo
                        momento, denunciando cualquier situación que pueda
                        afectar a la organización.
                    </p>
                </li>
                <li>
                    <h4 class="font-bold">Respeto:</h4>
                    <p>
                        Buscamos crear un ambiente de armonía e interacción
                        social, reconociendo que para ser respetado es necesario
                        respetar, comprender al otro, valorar sus intereses y
                        necesidades. En ese sentido, el respeto debe ser mutuo y
                        nacer de un sentimiento de reciprocidad.
                    </p>
                </li>
            </ul>
        </div>
    </section>
</template>
