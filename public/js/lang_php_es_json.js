"use strict";
/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunk"] = self["webpackChunk"] || []).push([["lang_php_es_json"],{

/***/ "./lang/php_es.json":
/*!**************************!*\
  !*** ./lang/php_es.json ***!
  \**************************/
/***/ ((module) => {

module.exports = JSON.parse('{"auth.failed":"These credentials do not match our records.","auth.password":"The provided password is incorrect.","auth.throttle":"Too many login attempts. Please try again in :seconds seconds.","pagination.previous":"&laquo; Anterior","pagination.next":"Siguiente &raquo;","passwords.reset":"¡Su contraseña ha sido restablecida!","passwords.sent":"We have emailed your password reset link!","passwords.throttled":"Por favor espere antes de volver a intentarlo.","passwords.token":"Este token de restablecimiento de contraseña es inválido.","passwords.user":"No se ha encontrado un usuario con esa dirección de correo.","passwords.password":"Las contraseñas deben tener al menos seis caracteres y coincidir con la confirmación.","validation.accepted":"El campo :attribute debe ser aceptado.","validation.accepted_if":"El campo :attribute debe aceptarse cuando :other es :value.","validation.active_url":"El campo :attribute no es una URL válida.","validation.after":"El campo :attribute debe ser una fecha posterior a :date.","validation.after_or_equal":"El campo :attribute debe ser una fecha posterior o igual a :date.","validation.alpha":"El campo :attribute solo puede contener letras.","validation.alpha_dash":"El campo :attribute solo puede contener letras, números, guiones y guiones bajos.","validation.alpha_num":"El campo :attribute solo puede contener letras y números.","validation.array":"El campo :attribute debe ser un array.","validation.before":"El campo :attribute debe ser una fecha anterior a :date.","validation.before_or_equal":"El campo :attribute debe ser una fecha anterior o igual a :date.","validation.between.array":"El campo :attribute debe contener entre :min y :max elementos.","validation.between.file":"El archivo :attribute debe pesar entre :min y :max kilobytes.","validation.between.numeric":"El campo :attribute debe ser un valor entre :min y :max.","validation.between.string":"El campo :attribute debe contener entre :min y :max caracteres.","validation.boolean":"El campo :attribute debe ser verdadero o falso.","validation.confirmed":"El campo confirmación de :attribute no coincide.","validation.current_password":"La contraseña es incorrecta.","validation.date":"El campo :attribute no corresponde con una fecha válida.","validation.date_equals":"El campo :attribute debe ser una fecha igual a :date.","validation.date_format":"El campo :attribute no corresponde con el formato de fecha :format.","validation.declined":"El :attribute debe ser rechazado.","validation.declined_if":"El :attribute debe ser rechazado cuando :other es :value.","validation.different":"Los campos :attribute y :other deben ser diferentes.","validation.digits":"El campo :attribute debe ser un número de :digits dígitos.","validation.digits_between":"El campo :attribute debe contener entre :min y :max dígitos.","validation.dimensions":"El campo :attribute tiene dimensiones de imagen inválidas.","validation.distinct":"El campo :attribute tiene un valor duplicado.","validation.email":"El campo :attribute debe ser una dirección de correo válida.","validation.ends_with":"El campo :attribute debe finalizar con alguno de los siguientes valores: :values","validation.enum":"El campo :attribute seleccionado no existe.","validation.exists":"El campo :attribute seleccionado no existe.","validation.file":"El campo :attribute debe ser un archivo.","validation.filled":"El campo :attribute debe tener un valor.","validation.gt.array":"El campo :attribute debe contener más de :value elementos.","validation.gt.file":"El archivo :attribute debe pesar más de :value kilobytes.","validation.gt.numeric":"El campo :attribute debe ser mayor a :value.","validation.gt.string":"El campo :attribute debe contener más de :value caracteres.","validation.gte.array":"El campo :attribute debe contener :value o más elementos.","validation.gte.file":"El archivo :attribute debe pesar :value o más kilobytes.","validation.gte.numeric":"El campo :attribute debe ser mayor o igual a :value.","validation.gte.string":"El campo :attribute debe contener :value o más caracteres.","validation.image":"El campo :attribute debe ser una imagen.","validation.in":"El campo :attribute es inválido.","validation.in_array":"El campo :attribute no existe en :other.","validation.integer":"El campo :attribute debe ser un número entero.","validation.ip":"El campo :attribute debe ser una dirección IP válida.","validation.ipv4":"El campo :attribute debe ser una dirección IPv4 válida.","validation.ipv6":"El campo :attribute debe ser una dirección IPv6 válida.","validation.json":"El campo :attribute debe ser una cadena de texto JSON válida.","validation.lt.array":"El campo :attribute debe contener menos de :value elementos.","validation.lt.file":"El archivo :attribute debe pesar menos de :value kilobytes.","validation.lt.numeric":"El campo :attribute debe ser menor a :value.","validation.lt.string":"El campo :attribute debe contener menos de :value caracteres.","validation.lte.array":"El campo :attribute debe contener :value o menos elementos.","validation.lte.file":"El archivo :attribute debe pesar :value o menos kilobytes.","validation.lte.numeric":"El campo :attribute debe ser menor o igual a :value.","validation.lte.string":"El campo :attribute debe contener :value o menos caracteres.","validation.mac_address":"El :attribute debe ser una dirección MAC válida.","validation.max.array":"El campo :attribute no debe contener más de :max elementos.","validation.max.file":"El archivo :attribute no debe pesar más de :max kilobytes.","validation.max.numeric":"El campo :attribute no debe ser mayor a :max.","validation.max.string":"El campo :attribute no debe contener más de :max caracteres.","validation.mimes":"El campo :attribute debe ser un archivo de tipo: :values.","validation.mimetypes":"El campo :attribute debe ser un archivo de tipo: :values.","validation.min.array":"El campo :attribute debe contener al menos :min elementos.","validation.min.file":"El archivo :attribute debe pesar al menos :min kilobytes.","validation.min.numeric":"El campo :attribute debe ser al menos :min.","validation.min.string":"El campo :attribute debe contener al menos :min caracteres.","validation.multiple_of":"El :attribute debe ser un múltiplo de :value.","validation.not_in":"El :attribute seleccionado es inválido.","validation.not_regex":"El formato del campo :attribute es inválido.","validation.numeric":"El :attribute debe ser un número.","validation.password":"La contraseña es incorrecta.","validation.present":"El :attribute debe estar presente.","validation.prohibited":"El campo :attribute está prohibido.","validation.prohibited_if":"El campo :attribute está prohibido cuando :other es :value.","validation.prohibited_unless":"El campo :attribute está prohibido a menos que :other esté en :values.","validation.prohibits":"El campo :attribute prohíbe que :other esté presente.","validation.regex":"El formato del campo :attribute es inválido.","validation.required":"El campo :attribute es obligatorio.","validation.required_array_keys":"El campo :attribute debe contener entradas para: :values.","validation.required_if":"El campo :attribute es obligatorio cuando el campo :other es :value.","validation.required_unless":"El campo :attribute es requerido a menos que :other se encuentre en :values.","validation.required_with":"El campo :attribute es obligatorio cuando :values está presente.","validation.required_with_all":"El campo :attribute es obligatorio cuando :values están presentes.","validation.required_without":"El campo :attribute es obligatorio cuando :values no está presente.","validation.required_without_all":"El campo :attribute es obligatorio cuando ninguno de los campos :values están presentes.","validation.same":"Los campos :attribute y :other deben coincidir.","validation.size.numeric":"El campo :attribute debe ser :size.","validation.size.file":"El archivo :attribute debe pesar :size kilobytes.","validation.size.string":"El campo :attribute debe contener :size caracteres.","validation.size.array":"El campo :attribute debe contener :size elementos.","validation.starts_with":"El campo :attribute debe comenzar con uno de los siguientes valores: :values","validation.string":"El campo :attribute debe ser una cadena de caracteres.","validation.timezone":"El campo :attribute debe ser una zona horaria válida.","validation.unique":"El valor del campo :attribute ya está en uso.","validation.uploaded":"El campo :attribute no se pudo subir.","validation.url":"El formato del campo :attribute es inválido.","validation.uuid":"El campo :attribute debe ser un UUID válido.","validation.custom.attribute-name.rule-name":"custom-message"}');

/***/ })

}]);