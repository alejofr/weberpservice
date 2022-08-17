"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["CecosCreate"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
  name: 'CecosForm',
  data: function data() {
    return {
      monedas: [],
      componentRender: LoaderComponent,
      card: {
        title: 'Nuevo Ceco',
        "class": 'max_width480 margin_auto_all',
        action: 'save',
        url: 'cecos',
        id: '',
        name: 'cecos',
        evento: 'eventChangePais',
        row: [{
          "class": 'col-xl-12 col-md-12',
          form: [{
            nodo: 'select',
            validate: 'required',
            event: 'change',
            name: 'id_pais',
            value: '',
            options: [],
            disable: false,
            opt: {
              id: 'id_pais',
              name: 'nombre'
            },
            id: 'id_pais',
            label: {
              title: 'Selecciona Un Pais',
              "for": 'id_pais'
            }
          }, {
            nodo: 'select',
            validate: 'required',
            event: 'change',
            name: 'id_empresa',
            value: '',
            options: [],
            disable: false,
            opt: {
              id: 'id_empresa',
              name: 'nombre_empresa'
            },
            id: 'id_empresa',
            label: {
              title: 'Selecciona la empresa',
              "for": 'id_empresa'
            }
          }, //
          {
            nodo: 'input',
            type: 'text',
            validate: 'required|max:60',
            event: 'change',
            name: 'id_ceco_erp',
            value: '',
            id: 'id_ceco_erp',
            label: {
              title: 'Id Ceco',
              "for": 'id_ceco_erp'
            }
          }, {
            nodo: 'input',
            type: 'text',
            validate: 'required',
            event: 'change',
            name: 'largo_ceco',
            value: '',
            id: 'largo_ceco',
            label: {
              title: 'Largo Ceco',
              "for": 'largo_ceco'
            }
          }, {
            nodo: 'input',
            type: 'text',
            validate: 'required',
            event: 'change',
            name: 'corto_ceco',
            value: '',
            id: 'corto_ceco',
            label: {
              title: 'Corto Ceco',
              "for": 'corto_ceco'
            }
          }]
        }] //fin row

      } //fin card

    };
  },
  beforeCreate: function beforeCreate() {
    this.$nextTick(function () {
      this.init();
    });
  },
  methods: {
    init: function init() {
      var _this = this;

      this.axios.get('paises/all').then(function (response) {
        console.log(response.data);

        if (response.data.results != null) {
          _this.card.row[0].form[0].options = response.data.results; //this.card.row[0].form[0].value = this.card.row[0].form[0].options[0].id_pais;

          _this.init_form();
        } else {
          compt = 'Error404';
        }
      })["catch"](function (error) {
        rend('Error404');
      });
    },
    edit: function edit(id) {
      var _this2 = this;

      this.axios.get("cecos/".concat(id, "/edit")).then(function (response) {
        console.log(response.data);

        if (response.data.results != null) {
          var ceco = response.data.results;
          _this2.card.title = 'Editar Ceco: ' + ceco.largo_ceco;
          _this2.card.action = 'update';
          _this2.card.id = id;
          _this2.card.row[0].form[0].value = ceco.id_pais;
          _this2.card.row[0].form[1].value = ceco.id_empresa;
          _this2.card.row[0].form[2].value = ceco.id_ceco_erp;
          _this2.card.row[0].form[3].value = ceco.largo_ceco;
          _this2.card.row[0].form[4].value = ceco.corto_ceco;

          _this2.search_empresas(ceco.id_pais);

          _this2.componentRender = FormOneComponent;
        } else {
          _this2.componentRender = Error404;
        }
      })["catch"](function (error) {
        _this2.componentRender = Error404;
      });
    },
    init_form: function init_form() {
      var url = this.$route.params;

      if (Object.keys(url).length != 0) {
        this.edit(url.id);
      } else {
        this.componentRender = FormOneComponent;
      }
    },
    search_empresas: function search_empresas(id) {
      var _this3 = this;

      this.axios.get('empresas/all', {
        params: {
          id_pais: id
        }
      }).then(function (response) {
        if (response.data.results != null) {
          _this3.card.row[0].form[1].options = response.data.results;

          _this3.$refs.formComponent.updateCard();
        }
      })["catch"](function (error) {});
    },
    eventChangePais: function eventChangePais(resp) {
      var formulario = this.card.row[0].form;

      if (resp.id_pais != this.card.row[0].form[0].value) {
        this.card.row[0].form[0].value = resp.id_pais;
        this.card.row[0].form[1].value = '';
        this.search_empresas(resp.id_pais);
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/views/configuracion/Cecos/CecosForm.vue":
/*!**************************************************************!*\
  !*** ./resources/js/views/configuracion/Cecos/CecosForm.vue ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _CecosForm_vue_vue_type_template_id_6b552d08___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CecosForm.vue?vue&type=template&id=6b552d08& */ "./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=template&id=6b552d08&");
/* harmony import */ var _CecosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CecosForm.vue?vue&type=script&lang=js& */ "./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CecosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CecosForm_vue_vue_type_template_id_6b552d08___WEBPACK_IMPORTED_MODULE_0__.render,
  _CecosForm_vue_vue_type_template_id_6b552d08___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/configuracion/Cecos/CecosForm.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CecosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CecosForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CecosForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=template&id=6b552d08&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=template&id=6b552d08& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CecosForm_vue_vue_type_template_id_6b552d08___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CecosForm_vue_vue_type_template_id_6b552d08___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CecosForm_vue_vue_type_template_id_6b552d08___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CecosForm.vue?vue&type=template&id=6b552d08& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=template&id=6b552d08&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=template&id=6b552d08&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/configuracion/Cecos/CecosForm.vue?vue&type=template&id=6b552d08& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
          on: { eventChangePais: _vm.eventChangePais },
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