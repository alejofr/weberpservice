"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["EditarTazasCambios"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
var FormOneComponent = function FormOneComponent() {
  return __webpack_require__.e(/*! import() */ "resources_js_components_forms_FormOneComponent_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../../../components/forms/FormOneComponent.vue */ "./resources/js/components/forms/FormOneComponent.vue"));
};

var LoaderComponent = function LoaderComponent() {
  return __webpack_require__.e(/*! import() */ "resources_js_components_LoaderComponent_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../../../components/LoaderComponent.vue */ "./resources/js/components/LoaderComponent.vue"));
};

var Error404 = function Error404() {
  return __webpack_require__.e(/*! import() */ "resources_js_components_Error404Component_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../../../components/Error404Component.vue */ "./resources/js/components/Error404Component.vue"));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'TazasCambiosForm',
  data: function data() {
    return {
      componentRender: LoaderComponent,
      card: {
        title: 'Nueva Taza Cambiaria',
        "class": 'max_width480 margin_auto_all',
        action: 'save',
        url: 'tazas-cambios',
        id: '',
        name: 'tazas-cambios',
        evento: '',
        row: [{
          "class": 'col-xl-12 col-md-12',
          form: [{
            nodo: 'select',
            type: 'text',
            validate: 'required',
            event: 'change',
            name: 'id_moneda_cambio',
            value: '',
            options: [],
            disable: false,
            opt: {
              id: 'id_moneda_cambio',
              name: 'nombre'
            },
            id: 'id_moneda_cambio',
            label: {
              title: 'Tipos de Cambios',
              "for": 'id_moneda_cambio'
            }
          }, {
            nodo: 'input',
            type: 'text',
            validate: 'required',
            event: 'change',
            name: 'monto_tc',
            value: '',
            id: 'monto_tc',
            label: {
              title: 'Monto (taza cambiaria)',
              "for": 'monto_tc'
            }
          }, {
            nodo: 'input',
            type: 'date',
            validate: 'required',
            event: 'change',
            name: 'fecha_tc',
            value: '',
            id: 'fecha_tc',
            label: {
              title: 'Fecha Tasa de Cambio',
              "for": 'fecha_tc'
            }
          }]
        }] //fin row

      } //fin card

    };
  },
  beforeCreate: function beforeCreate() {
    this.$nextTick(function () {
      this.cambios_disponibles();
    });
  },
  methods: {
    cambios_disponibles: function cambios_disponibles() {
      var _this = this;

      var url = this.$route.params;

      if (Object.keys(url).length != 0) {
        this.axios.get('tipos-cambios/all').then(function (response) {
          console.log(response.data);

          _this.edit(url.id, response.data.results);
        })["catch"](function (error) {
          _this.componentRender = Error404;
        });
      } else {
        this.componentRender = Error404;
      }
    },
    edit: function edit(id, data) {
      var _this2 = this;

      this.axios.get("tazas-cambios/".concat(id, "/edit")).then(function (response) {
        console.log(response.data);

        if (response.data.results != null) {
          var cambio = response.data.results;
          _this2.card.title = 'Editar Monto Taza';
          _this2.card.action = 'update';
          _this2.card.id = id;
          _this2.card.row[0].form[0].disable = true;
          _this2.card.row[0].form[1].value = cambio.monto_tc;
          _this2.card.row[0].form[2].value = cambio.fecha_tc;

          _this2.init_form(cambio.id_moneda_cambio, data);

          _this2.componentRender = FormOneComponent;
        } else {
          _this2.componentRender = Error404;
          console.log('aa');
        }
      })["catch"](function (error) {
        _this2.componentRender = Error404;
      });
    },
    init_form: function init_form() {
      var id_cambio = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      var data = arguments.length > 1 ? arguments[1] : undefined;
      var formulario = this.card.row[0].form;
      var arreglo = [];

      for (var i = 0; i < data.length; i++) {
        var objt = {
          id_moneda_cambio: data[i].id_moneda_cambio,
          nombre: data[i].abreviatura_nc + ' - ' + data[i].abreviatura_divisa
        };
        arreglo.push(objt);
      }

      formulario[0].options = arreglo;
      formulario[0].value = id_cambio == '' ? arreglo[0].id_moneda_cambio : id_cambio;
      this.componentRender = FormOneComponent;
    }
  }
});

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TazasCambiosForm_vue_vue_type_template_id_64b7a7d0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TazasCambiosForm.vue?vue&type=template&id=64b7a7d0& */ "./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=template&id=64b7a7d0&");
/* harmony import */ var _TazasCambiosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TazasCambiosForm.vue?vue&type=script&lang=js& */ "./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TazasCambiosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TazasCambiosForm_vue_vue_type_template_id_64b7a7d0___WEBPACK_IMPORTED_MODULE_0__.render,
  _TazasCambiosForm_vue_vue_type_template_id_64b7a7d0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/configuracion/Monedas/TazasCambiosForm.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TazasCambiosForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=template&id=64b7a7d0&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=template&id=64b7a7d0& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosForm_vue_vue_type_template_id_64b7a7d0___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosForm_vue_vue_type_template_id_64b7a7d0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosForm_vue_vue_type_template_id_64b7a7d0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TazasCambiosForm.vue?vue&type=template&id=64b7a7d0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=template&id=64b7a7d0&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=template&id=64b7a7d0&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosForm.vue?vue&type=template&id=64b7a7d0& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row row-cards" }, [
    _c(
      "div",
      { staticClass: "col-12", staticStyle: { "min-height": "60vh" } },
      [
        _c(_vm.componentRender, {
          tag: "component",
          attrs: { card: _vm.card },
        }),
      ],
      1
    ),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);