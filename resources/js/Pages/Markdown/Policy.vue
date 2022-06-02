<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Slider from "@/Components/Slider.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
</script>
<template>
    <Head title="Aviso de Privacidad" />
    <Slider />
    <SectionTitle :primary="true">
        <h4>Aviso de Privacidad</h4>
    </SectionTitle>
    <article class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8 prose">
        <h1>Aviso de Privacidad</h1>
        <small>&Uacute;ltima actualizaci&oacute;n: 01 de enero de 2022</small>
        <p class="text-justify">
            Para <strong>HJ AUTOPARTES S.A. DE C.V.</strong> usted y su
            confianza son lo más importante, por tal motivo estamos
            comprometidos a proteger la información personal que usted nos
            proporciona, esto mediante una constante revisión en los procesos de
            obtención y resguardo de la información física y electrónica y con
            apego a la Ley de Protección de Datos Personales en Posesión de los
            Particulares, publicada en el Diario Oficial de la Federación el 5
            de Julio del 2010.
        </p>
        <p class="text-justify">
            Siguiendo el objetivo de proteger sus datos personales
            <strong>HJ AUTOPARTES S.A. DE C.V.</strong> ha creado una política
            de privacidad que nos permite garantizar el correcto uso y
            tratamiento de su información; la cual queremos compartir con usted
            y que estará disponible en nuestra página de internet
            <Link
                :href="route('home')"
                class="transition delay-100 ease-in"
                >www.hjautopartes.com.mx</Link
            >, también puede acceder al contenido de la Ley de Protección de
            Datos personales en Posesión de Particulares a través de la página
            <a href="https://home.inai.org.mx/" target="_blank"
                >www.inai.org.mx</a
            >.
        </p>
        <p class="text-justify">
            Es preciso informarle que en el momento que usted lo desee puede
            hacer válido su derecho de limitar el uso o divulgación de sus datos
            personales o revocar el consentimiento que para tal fin nos haya
            otorgado, así como su derecho de acceso, rectificación, cancelación
            u oposición (ARCO), presentando una solicitud por escrito en el
            domicilio de <strong>HJ AUTOPARTES S.A. DE C.V.</strong>, se
            entiende como autorización tácita si al dar a conocer el presente
            aviso el titular de los datos no manifieste su oposición.
        </p>
        <p class="text-justify">
            La empresa <strong>HJ AUTOPARTES S.A. DE C.V.</strong> con domicilio
            Boulevard Los &Aacute;lamos 195 interior A, Los Álamos, Heroica
            Nogales, Nogales, Son CP 84085, tienen la calidad de responsables de
            recabar sus datos, del uso que se les dé a los mismos y de su
            protección.
        </p>
        <p>
            Hacemos de su conocimiento que poseemos o recabaremos los datos que
            sean necesarios para llevar a cabo el proceso que conlleva la
            prestación del servicio que usted nos solicite, estos datos fueron o
            serán obtenidos en presencia del titular, por vía electrónica,
            óptica, sonora, visual o a través de cualquier tecnología, o bien,
            podrán obtenerse mediante fuentes permitidas por la ley como lo son
            los directorios telefónicos, de servicios y/o laborales.
        </p>
        <p class="text-justify">
            <strong>HJ AUTOPARTES S.A. DE C.V.</strong> podrá hacer uso de
            "Cookies" para recabar información adicional sobre usted durante su
            visita a nuestra página de Internet, los "Cookies" son archivos o
            piezas de información que se almacenan por su navegador en el disco
            duro de su computadora. Los cookies que utilizamos no almacenan
            datos personales y tampoco pueden dañar tu equipo. Nosotros queremos
            que nuestro sitio web sea amigable para el usuario y el uso de
            cookies nos ayudan a alcanzar esta meta.
        </p>
        <p class="text-justify">
            Los datos personales a los que podremos acceder y dar uso y
            tratamiento, de forma enunciativa más no limitativa, son los
            siguientes:
        </p>
        <ol class="list-decimal list-inside">
            <li>Datos de identificación:</li>
            <ul class="list-disc list-inside">
                <li>Nombre completo</li>
                <li>Edad</li>
                <li>Fecha y lugar de nacimiento</li>
                <li>Dirección</li>
                <li>Teléfono fijo y móvil</li>
                <li>Dirección de correo electrónico</li>
                <li>C.U.R.P.</li>
                <li>R.F.C.</li>
                <li>Estado civil</li>
                <li>Nombres y edades de familiares.</li>
            </ul>
            <li>Datos laborales:</li>
            <ul class="list-disc list-inside">
                <li>Nombre de la empresa donde labora</li>
                <li>Domicilio</li>
                <li>Teléfono</li>
                <li>Dirección de correo electrónico</li>
                <li>Puesto</li>
                <li>Antigüedad</li>
                <li>Referencias personales, laborales y comerciales.</li>
            </ul>
            <li>Datos financieros:</li>
            <ul class="list-disc list-inside">
                <li>Bienes muebles e inmuebles</li>
                <li>Historial crediticio</li>
                <li>Ingresos y egresos</li>
                <li>Buro de crédito.</li>
            </ul>
        </ol>
        <p class="text-justify">
            El uso y tratamiento de los datos que usted nos proporciones será el
            necesario y siempre en cumplimiento del presente aviso de
            privacidad, incluyendo los datos sensibles con la finalidad de:
        </p>
        <ol>
            <li>
                Llevar a cabo los procesos que se siguen en la prestación de
                nuestros servicios.
            </li>
            <li>
                Tener una base de datos que permitan ofrecerle un servicio
                personalizado.
            </li>
            <li>Realizar encuestas de satisfacción.</li>
            <li>Dar seguimiento a sus quejas y/o sugerencias.</li>
            <li>
                Con fines de mercadotecnia y publicidad de nuestros productos o
                servicios.
            </li>
            <li>
                La atención a requerimientos de cualquier autoridad competente.
            </li>
            <li>
                Tener el contacto para notificaciones sobre el presente aviso de
                privacidad.
            </li>
        </ol>
        <p class="text-justify">
            Se designa al departamento de COMERCIALIZACIÓN como el Departamento
            de Tratamiento de Datos personales y al correo
            <a href="mailto:atencionaclientes@hjautopartes.com.mx"
                >atencionaclientes@hjautopartes.com.mx</a
            >
            y como el medio por el cual usted podrá hacer válidos sus derechos
            de ARCO (acceso, rectificación cancelación y oposición) así como a
            revocar su consentimiento y limitar el uso y divulgación de sus
            datos, a que hace mención la Ley de Federal de Protección de Datos
            Personales en Posesión de Particulares, el procedimiento puede
            llevarlo a cabo personalmente o a través de su representante legal.
        </p>
        <p class="text-justify">
            El presente aviso de privacidad podrá ser modificado, con motivo de
            novedades legislativas, regulatorias o jurisprudenciales, políticas
            internas y de mercadeo no así sus datos y/o derechos sin su expreso
            consentimiento. Toda modificación realizada será dada a conocer
            mediante anuncios visibles en nuestros establecimientos y en nuestra
            página de internet
            <Link
                :href="route('home')"
                class="transition delay-100 ease-in"
                >www.hjautopartes.com.mx</Link
            >, de ser significativos, se le har la notificación por correo
            electrónico o vía telefónica.
        </p>
    </article>
</template>
