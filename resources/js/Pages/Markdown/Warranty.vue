<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Slider from "@/Components/Slider.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
</script>
<template>
    <Head title="Pol&iacute;ticas de Garantia" />
    <Slider />
    <SectionTitle :primary="true">
        <h4>Pol&iacute;ticas de Garantia</h4>
    </SectionTitle>
    <article class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8 prose">
        <h1>Pol&iacute;ticas de Garantia</h1>
        <p class="text-justify">
            HJ Autopartes desea que se obtengan los mejores resultados en el uso
            de sus autopartes y agradece el favor de su preferencia.
        </p>
        <p class="text-justify">
            Para brindar el servicio que se requiere, pone a sus órdenes el
            proceso de devoluciones, bajo la siguiente política:
        </p>
        <ol>
            <li>
                Devolución procedente:
                <ol type="i">
                    <li>
                        <p class="text-justify">
                            Defectuoso. Producto no instalado. El cliente lo
                            recibe con algún defecto de fabricación
                        </p>
                    </li>
                    <li>
                        <p class="text-justify">
                            Mal empacado. Dentro de la caja se recibe un
                            producto diferente a la clave e imagen indicadas en
                            la etiqueta de ésta. (Ver nota 1)
                        </p>
                    </li>
                </ol>
            </li>
            <li>
                Devolución no procedente:
                <p>
                    No se generará nota de crédito o reposición de producto para
                    todos aquellos casos que se evalúen como devoluciones no
                    procedentes.
                </p>
                <p class="text-justify">
                    Las devoluciones deberán ser entregadas al asesor de
                    negocios (en caso de tenerlo), notificadas sin excepción al
                    departamento de atencion a clientes al correo
                    <a href="mailto:atencionaclientes@hjautopartes.com.mx"
                        >atencionaclientes@hjautopartes.com.mx</a
                    >.
                </p>
                <ol type="i">
                    <li>
                        <p class="text-justify">
                            Piezas que no presentan un numero de orden valido la
                            plataforma de hjautopartes.com.mx
                        </p>
                    </li>
                    <li>
                        <p class="text-justify">
                            Piezas incompletas (falta de tornillos, tuercas,
                            baleros, sensores, etc.)
                        </p>
                    </li>
                    <li>
                        <p class="text-justify">
                            Piezas mal instaladas y/o que presenten un daño o
                            alteración física, HJ Autopartes entregará un parte
                            técnico donde se explique técnicamente el por qué no
                            procede dicha devolución.
                        </p>
                    </li>
                    <li>
                        <p class="text-justify">
                            Piezas regresadas con líquido contaminado o algún
                            contaminante.
                        </p>
                    </li>
                    <li>
                        <p class="text-justify">
                            En las lineas bomba de agua y depositos de agua, el
                            interior de la pieza oxidado a causa de falta de
                            refrigerante.
                        </p>
                    </li>
                </ol>
            </li>
        </ol>
        <div id="notes">
            <span class="font-bold">Notas:</span>
            <ol class="text-red-500">
                <li>
                    Se tendrán 7 días a partir de la fecha de facturación para
                    reportar producto no solicitado o mal surtido, después de
                    esta fecha no se aceptara devolución. El reporte será a
                    través del área de atención a clientes.
                </li>
                <li>
                    No se hará reembolso de la compra hasta no haber evaluado el
                    producto.
                </li>
                <li>
                    En condiciones normales por devoluciones el periodo de
                    dictamen de una devolución es de 3 a 5 días habiles a partir
                    de recibido el producto, del folio de compra y el motivo de
                    devolución, este proceso inicia una vez teniendo completetos
                    los tres puntos anteriores. Junto con su reporte se debera
                    anexar imágenes para evidenciar el reclamo los cuales
                    deberán ser proporcionados via correo electronico y/o
                    whatsapp.
                </li>
            </ol>
        </div>
    </article>
</template>
