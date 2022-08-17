"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["CrearTiposCambios"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=script&lang=js& ***!
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
  return __webpack_require__.e(/*! import() */ "Error404").then(__webpack_require__.bind(__webpack_require__, /*! ../../../components/Error404Component.vue */ "./resources/js/components/Error404Component.vue"));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'TiposCambiosForm',
  data: function data() {
    return {
      monedas: [],
      componentRender: LoaderComponent,
      card: {
        title: 'Nuevo Tipo de Cambio',
        "class": 'max_width480 margin_auto_all',
        action: 'save',
        url: 'tipos-cambios',
        id: '',
        name: 'tipos-cambios',
        evento: 'eventChangeMoneda',
        row: [{
          "class": 'col-xl-12 col-md-12',
          form: [{
            nodo: 'select',
            type: 'text',
            validate: 'required',
            event: 'change',
            name: 'id_moneda_nc',
            value: '',
            options: [],
            disable: false,
            opt: {
              id: 'id_moneda',
              name: 'nombre'
            },
            id: 'id_moneda_nc',
            label: {
              title: 'Moneda Nacional',
              "for": 'id_moneda_nc'
            }
          }, {
            nodo: 'select',
            type: 'text',
            validate: 'required',
            event: 'change',
            name: 'id_moneda_divisa',
            value: '',
            options: [],
            disable: false,
            opt: {
              id: 'id_moneda',
              name: 'nombre'
            },
            id: 'id_moneda_divisa',
            label: {
              title: 'Monedas Extranjeras',
              "for": 'id_moneda_divisa'
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
              title: 'Monto Tasa de Cambio',
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
      this.monedas_disponibles();
    });
  },
  methods: {
    monedas_disponibles: function monedas_disponibles() {
      var _this = this;

      var url = this.$route.params;
      this.axios.get('monedas/all').then(function (response) {
        _this.monedas = response.data.results;
        console.log(response.data);

        if (Object.keys(url).length != 0) {
          _this.edit(url.id);
        } else {
          _this.init_form();
        }
      })["catch"](function (error) {
        _this.componentRender = Error404;
      });
    },
    edit: function edit(id) {
      var _this2 = this;

      this.axios.get("tipos-cambios/".concat(id, "/edit")).then(function (response) {
        console.log(response.data);

        if (response.data.results != null) {
          var cambio = response.data.results;
          _this2.card.title = 'Editar Cambio';
          _this2.card.action = 'update';
          _this2.card.id = id;

          _this2.card.row[0].form.splice(2);

          _this2.init_form(cambio.id_moneda_nc, cambio.id_moneda_divisa);
        } else {
          _this2.componentRender = Error404;
        }
      })["catch"](function (error) {
        _this2.componentRender = Error404;
      });
    },
    init_form: function init_form() {
      var id = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      var id_divisa = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
      var formulario = this.card.row[0].form;
      formulario[0].options = this.monedas;
      formulario[0].value = id == '' ? this.monedas[0].id_moneda : id;
      this.monedasCambios(formulario[0].value, formulario, false, id_divisa);
    },
    monedasCambios: function monedasCambios(id_moneda, formulario) {
      var act = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
      var id_divisa = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : '';
      var arreglo = [];
      var monedas = this.monedas;

      for (var i = 0; i < monedas.length; i++) {
        if (monedas[i].id_moneda != id_moneda) {
          arreglo.push(monedas[i]);
        }
      }

      formulario[1].options = arreglo;
      formulario[1].value = id_divisa == '' ? arreglo[0].id_moneda : id_divisa;
      console.log(this.card);
      this.card.row[0].form = formulario;
      this.componentRender = FormOneComponent;
      if (act) this.$refs.formComponent.updateCard();
    },
    eventChangeMoneda: function eventChangeMoneda(resp) {
      var formulario = this.card.row[0].form;

      if (resp.id_moneda_nc != formulario[0].value) {
        formulario[0].value = resp.id_moneda_nc;
        this.monedasCambios(resp.id_moneda_nc, formulario, true);
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TiposCambiosForm_vue_vue_type_template_id_12e2ee10___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TiposCambiosForm.vue?vue&type=template&id=12e2ee10& */ "./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=template&id=12e2ee10&");
/* harmony import */ var _TiposCambiosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TiposCambiosForm.vue?vue&type=script&lang=js& */ "./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TiposCambiosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TiposCambiosForm_vue_vue_type_template_id_12e2ee10___WEBPACK_IMPORTED_MODULE_0__.render,
  _TiposCambiosForm_vue_vue_type_template_id_12e2ee10___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/configuracion/Monedas/TiposCambiosForm.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TiposCambiosForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=template&id=12e2ee10&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=template&id=12e2ee10& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosForm_vue_vue_type_template_id_12e2ee10___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosForm_vue_vue_type_template_id_12e2ee10___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosForm_vue_vue_type_template_id_12e2ee10___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TiposCambiosForm.vue?vue&type=template&id=12e2ee10& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=template&id=12e2ee10&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=template&id=12e2ee10&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosForm.vue?vue&type=template&id=12e2ee10& ***!
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
          ref: "formComponent",
          tag: "component",
          attrs: { card: _vm.card },
          on: { eventChangeMoneda: _vm.eventChangeMoneda },
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