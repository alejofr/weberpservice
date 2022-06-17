"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["Paises"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
  name: 'PaisIndex',
  data: function data() {
    return {
      data: {
        th: [{
          name: 'Id Pais'
        }, {
          name: 'Nombre Pais'
        }, {
          name: 'Nacionalidad'
        }],
        columns: [{
          name: 'Id pais',
          value: 'wse_paises.id_pais_erp'
        }, {
          name: 'Nombre Pais',
          value: 'wse_paises.nombre'
        }, {
          name: 'Nacionalidad',
          value: 'wse_paises.nacionalidad_pais'
        }]
      },
      view: 'PaisesDataTable',
      accion: {
        create: 'PaisesCreate',
        edit: 'PaisesEditar',
        "delete": 'paises/delete/'
      },
      request: {
        url: 'paises',
        params: {
          limit: 8,
          page: this.$route.query.hasOwnProperty("page") && this.$route.query.page.match(/^[0-9]+$/) ? parseInt(this.$route.query.page) : 1,
          orderBy: 'wse_paises.id_pais_erp',
          ascending: 1,
          query: {
            search: ''
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

/***/ "./resources/js/views/configuracion/Paises/PaisesIndex.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/views/configuracion/Paises/PaisesIndex.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PaisesIndex_vue_vue_type_template_id_d59751ac___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PaisesIndex.vue?vue&type=template&id=d59751ac& */ "./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=template&id=d59751ac&");
/* harmony import */ var _PaisesIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PaisesIndex.vue?vue&type=script&lang=js& */ "./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PaisesIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PaisesIndex_vue_vue_type_template_id_d59751ac___WEBPACK_IMPORTED_MODULE_0__.render,
  _PaisesIndex_vue_vue_type_template_id_d59751ac___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/configuracion/Paises/PaisesIndex.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PaisesIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PaisesIndex.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PaisesIndex_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=template&id=d59751ac&":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=template&id=d59751ac& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PaisesIndex_vue_vue_type_template_id_d59751ac___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PaisesIndex_vue_vue_type_template_id_d59751ac___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PaisesIndex_vue_vue_type_template_id_d59751ac___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PaisesIndex.vue?vue&type=template&id=d59751ac& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=template&id=d59751ac&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=template&id=d59751ac&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Paises/PaisesIndex.vue?vue&type=template&id=d59751ac& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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