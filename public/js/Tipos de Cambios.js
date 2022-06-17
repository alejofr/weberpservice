"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["Tipos de Cambios"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
//
var Error404 = function Error404() {
  return __webpack_require__.e(/*! import() */ "resources_js_components_Error404Component_vue").then(__webpack_require__.bind(__webpack_require__, /*! ../../../components/Error404Component.vue */ "./resources/js/components/Error404Component.vue"));
};

var tables = function tables() {
  return __webpack_require__.e(/*! import() | TableComponent */ "TableComponent").then(__webpack_require__.bind(__webpack_require__, /*! ../../../components/tables/TableComponent.vue */ "./resources/js/components/tables/TableComponent.vue"));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Monedas',
  data: function data() {
    return {
      comp: '',
      data: {
        th: [{
          name: 'Moneda Nacional'
        }, {
          name: 'Moneda Extranjera'
        }, {
          name: 'Monto taza'
        }, {
          name: 'Usuario'
        }, {
          name: 'Fecha Actualizado'
        }],
        columns: [{
          name: 'Moneda Nacional',
          value: 'wse_monedas.abreviatura'
        }, {
          name: 'Moneda Extranjera',
          value: 'money.abreviatura'
        }, {
          name: 'Monto taza',
          value: 'wse_monedas_cambios_tazas.monto_tc'
        }, {
          name: 'Fecha Actualizado',
          value: 'wse_monedas_cambios_tazas.fecha_editado'
        }]
      },
      view: 'MonedasCambiosTazasDataTable',
      accion: {
        create: '',
        edit: '',
        "delete": '',
        volver: ''
      },
      request: {
        url: 'tazas-cambios',
        params: {
          limit: 8,
          page: this.$route.query.hasOwnProperty("page") && this.$route.query.page.match(/^[0-9]+$/) ? parseInt(this.$route.query.page) : 1,
          orderBy: 'wse_monedas.abreviatura',
          ascending: 1,
          query: {
            search: '',
            id_cambio: ''
          }
        }
      }
    };
  },
  beforeCreate: function beforeCreate() {
    this.$nextTick(function () {
      var url = this.$route.params;

      if (Object.keys(url).length != 0) {
        this.comp = tables;
        this.request.params.query.id_cambio = url.id;
        this.$store.dispatch('tableadmin/initTable', this.request);
      } else {
        this.comp = Error404;
      }
    });
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Monedas',
  data: function data() {
    return {
      data: {
        th: [//{name: 'Pais'},
        {
          name: 'Moneda Nacional'
        }, {
          name: 'Moneda Extranjera'
        }, {
          name: 'Tasa de Cambio'
        }, {
          name: 'Ultima Actualizaión de Tasa'
        }, {
          name: ''
        }],
        columns: [//{name: 'Pais', value: 'wse_paises.nombre'},
        {
          name: 'Moneda Nacional',
          value: 'wse_monedas.abreviatura'
        }, {
          name: 'Moneda Extranjera',
          value: 'money.abreviatura'
        }]
      },
      view: 'MonedasCambiosDataTable',
      accion: {
        create: 'MonedasCambiosCreate',
        edit: 'MonedasCambiosEditar',
        "delete": 'tipos-cambios/delete/'
      },
      request: {
        url: 'tipos-cambios',
        params: {
          limit: 8,
          page: this.$route.query.hasOwnProperty("page") && this.$route.query.page.match(/^[0-9]+$/) ? parseInt(this.$route.query.page) : 1,
          orderBy: 'wse_monedas.abreviatura',
          ascending: 1,
          query: {
            search: '',
            id_pais: ''
          }
        }
      }
    };
  },
  beforeCreate: function beforeCreate() {
    this.$nextTick(function () {
      this.$store.dispatch('tableadmin/initTable', this.request);
    });
  },
  components: {
    tables: function tables() {
      return __webpack_require__.e(/*! import() | TableComponent */ "TableComponent").then(__webpack_require__.bind(__webpack_require__, /*! ../../../components/tables/TableComponent.vue */ "./resources/js/components/tables/TableComponent.vue"));
    }
  },
  methods: {}
});

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue":
/*!************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TazasCambiosIndex_vue_vue_type_template_id_4d818b2e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TazasCambiosIndex.vue?vue&type=template&id=4d818b2e& */ "./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=template&id=4d818b2e&");
/* harmony import */ var _TazasCambiosIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TazasCambiosIndex.vue?vue&type=script&lang=js& */ "./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TazasCambiosIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TazasCambiosIndex_vue_vue_type_template_id_4d818b2e___WEBPACK_IMPORTED_MODULE_0__.render,
  _TazasCambiosIndex_vue_vue_type_template_id_4d818b2e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue":
/*!************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TiposCambiosIndex_vue_vue_type_template_id_41e2ca4e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TiposCambiosIndex.vue?vue&type=template&id=41e2ca4e& */ "./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=template&id=41e2ca4e&");
/* harmony import */ var _TiposCambiosIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TiposCambiosIndex.vue?vue&type=script&lang=js& */ "./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TiposCambiosIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TiposCambiosIndex_vue_vue_type_template_id_41e2ca4e___WEBPACK_IMPORTED_MODULE_0__.render,
  _TiposCambiosIndex_vue_vue_type_template_id_41e2ca4e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TazasCambiosIndex.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TiposCambiosIndex.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=template&id=4d818b2e&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=template&id=4d818b2e& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosIndex_vue_vue_type_template_id_4d818b2e___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosIndex_vue_vue_type_template_id_4d818b2e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TazasCambiosIndex_vue_vue_type_template_id_4d818b2e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TazasCambiosIndex.vue?vue&type=template&id=4d818b2e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=template&id=4d818b2e&");


/***/ }),

/***/ "./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=template&id=41e2ca4e&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=template&id=41e2ca4e& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosIndex_vue_vue_type_template_id_41e2ca4e___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosIndex_vue_vue_type_template_id_41e2ca4e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TiposCambiosIndex_vue_vue_type_template_id_41e2ca4e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TiposCambiosIndex.vue?vue&type=template&id=41e2ca4e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=template&id=41e2ca4e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=template&id=4d818b2e&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TazasCambiosIndex.vue?vue&type=template&id=4d818b2e& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
      { staticClass: "col-12" },
      [
        _c(_vm.comp, {
          ref: "TablesRef",
          tag: "component",
          attrs: { columns: _vm.data, viewData: _vm.view, accion: _vm.accion },
        }),
      ],
      1
    ),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=template&id=41e2ca4e&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Monedas/TiposCambiosIndex.vue?vue&type=template&id=41e2ca4e& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
      { staticClass: "col-12" },
      [
        _c("tables", {
          ref: "TablesRef",
          attrs: { columns: _vm.data, viewData: _vm.view, accion: _vm.accion },
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