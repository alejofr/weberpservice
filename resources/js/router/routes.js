export const routes = [
    {
		name: 'Home',
		path: '/',
		meta: { title: 'Inicio' },
		component: () => import(/* webpackChunkName: "Inicio" */ '../views/Inicio.vue')
	},
    {
		name: 'Operation',
		path: '/operacion',
		meta: { title: 'Operación' },
		component:  () => import(/* webpackChunkName: "Operacion" */ '../views/operacion/Operacion.vue'),
        children: [
            {
                name: 'OpProveedoresIndex',
                path: 'proveedores',
                meta: { title: 'Proveedores' },
                component:  () => import(/* webpackChunkName: "Proveedores" */ '../views/operacion/Proveedores/ProveedoresIndex.vue')
            },
            {
                name: 'OpFacturasIndex',
                path: 'facturas',
                meta: { title: 'Facturas' },
                component:  () => import(/* webpackChunkName: "Facturas" */ '../views/operacion/Facturas/FacturasIndex.vue')
            },
            {
                name:'OpConfiguacion',
                path: 'configuracion',
                component:  () => import(/* webpackChunkName: "Operacion" */ '../views/operacion/Operacion.vue'),
                children: [
                    {
                        name: 'OpConfigProveedoresIndex',
                        path: 'proveedores',
                        component:  () => import(/* webpackChunkName: "Operacion" */ '../views/operacion/Operacion.vue'),
                        children: [
                            {
                                name: 'ConfigProveedoresIndex',
                                path: 'all',
                                meta: { title: 'Gestión Proveedores' },
                                component:  () => import(/* webpackChunkName: "Proveedores" */ '../views/operacion/Proveedores/ProveedoresIndex.vue')
                            },
                            {
                                name:'ProveedoresCreate',
                                path: 'create',
                                meta: { title: 'Nuevo Proveedor' },//
                                component:  () => import(/* webpackChunkName: "ProveedorCreate" */ '../views/operacion/Proveedores/ProveedoresForm.vue')
                            },
                            {
                                name:'ProveedoresEditar',
                                path: 'editar/:id',
                                meta: { title: 'Editar Proveedor ' },//
                                component:  () => import(/* webpackChunkName: "ProveedorEditar" */ '../views/operacion/Proveedores/ProveedoresForm.vue')
                            },
                        ]
                    },
                    {
                        name: 'ConfigFacturaCreate',
                        path: 'factura/create',
                        meta: { title: 'Carga Manual de Movimientos' },//
                        component:  () => import(/* webpackChunkName: "ProveedorEditar" */ '../views/operacion/Facturas/FacturasForm.vue')
                    }
                ]
            }
        ]
	},
    {
        name:'Configuacion',
        path: '/configuracion',
		component:  () => import(/* webpackChunkName: "Configuracion" */ '../views/configuracion/Configuacion.vue'),
        children: [
            {
                name: 'Paises',
                path: 'paises',
                component: () => import( /* webpackChunkName: "Configuracion" */ '../views/configuracion/Configuacion.vue'),
                children: [
                    {
                        name:'PaisesIndex',
                        path: 'all',
                        meta: { title: 'Paises' },
                        component: () => import(/* webpackChunkName: "Paises"*/  '../views/configuracion/Paises/PaisesIndex.vue')
                    },
                    {
                        name:'PaisesCreate',
                        path: 'create',
                        meta: { title: 'Nuevo Pais' },
                        component: () => import(/* webpackChunkName: "PaisesCreate"*/  '../views/configuracion/Paises/PaisesForm.vue')
                    },
                    {
                        name:'PaisesEditar',
                        path: 'editar/:id',
                        meta: { title: 'Editar Pais -' },
                        component: () => import(/* webpackChunkName: "PaisesEditar"*/  '../views/configuracion/Paises/PaisesForm.vue')
                    }
                ]

            },
            {
                name:'Monedas',
                path: 'monedas',
                component: () => import( /* webpackChunkName: "Configuracion" */ '../views/configuracion/Configuacion.vue'),
                children: [
                    {
                        name:'MonedasIndex',
                        path: 'all',
                        meta: { title: 'Monedas' },
                        component: () => import(/* webpackChunkName: "Monedas"*/  '../views/configuracion/Monedas/MonedasIndex.vue')
                    },
                    {
                        name:'MonedaCreate',
                        path: 'create',
                        meta: { title: 'Crear Nueva Moneda' },
                        component: () => import(/* webpackChunkName: "CrearMoneda"*/  '../views/configuracion/Monedas/MonedasForm.vue')
                    },
                    {
                        name:'MonedaEditar',
                        path: 'editar/:id',
                        meta: { title: 'Editar Moneda - ' },
                        component: () => import(/* webpackChunkName: "EditarMoneda"*/  '../views/configuracion/Monedas/MonedasForm.vue')
                    },
                    {
                        name:'MonedasCambios',
                        path: 'cambios',
                        component: () => import( /* webpackChunkName: "Configuracion" */ '../views/configuracion/Configuacion.vue'),
                        children: [
                            {
                                name:'MonedasCambiosIndex',
                                path: 'all',
                                meta: { title: 'Taza de Cambio' },
                                component: () => import(/* webpackChunkName: "Tipos de Cambios"*/  '../views/configuracion/Monedas/TiposCambiosIndex.vue')
                            },
                            {
                                name:'MonedasCambiosCreate',
                                path: 'create',
                                meta: { title: 'Crear Nuevo Cambio' },
                                component: () => import(/* webpackChunkName: "CrearTiposCambios"*/  '../views/configuracion/Monedas/TiposCambiosForm.vue')
                            },
                            {
                                name:'MonedasCambiosEditar',
                                path: 'editar/:id',
                                meta: { title: 'Editar Cambio - ' },
                                component: () => import(/* webpackChunkName: "EditarTiposCambios"*/  '../views/configuracion/Monedas/TiposCambiosForm.vue')
                            },
                        ]
                    },
                    {
                        name:'TazasCambios',
                        path: 'tazas-cambios',
                        component: () => import( /* webpackChunkName: "Configuracion" */ '../views/configuracion/Configuacion.vue'),
                        children: [
                            {
                                name:'TazasCambiosIndex',
                                path: ':id',
                                meta: { title: 'Tazas de Cambios' },
                                component: () => import(/* webpackChunkName: "Tipos de Cambios"*/  '../views/configuracion/Monedas/TazasCambiosIndex.vue')
                            },
                            {
                                name:'TazasCambiosEditar',
                                path: 'editar/:id',
                                meta: { title: 'Editar Tasa de Cambio - ' },
                                component: () => import(/* webpackChunkName: "EditarTazasCambios"*/  '../views/configuracion/Monedas/TazasCambiosForm.vue')
                            },
                        ]
                    }
                ]
            },
            {
                name: 'Empresas',
                path: 'empresas',
                component: () => import( /* webpackChunkName: "Configuracion" */ '../views/configuracion/Configuacion.vue'),
                children: [
                    {
                        name:'EmpresasIndex',
                        path: 'all',
                        meta: { title: 'Empresas' },
                        component: () => import(/* webpackChunkName: "Empresas"*/  '../views/configuracion/Empresas/EmpresasIndex.vue')
                    },
                    {
                        name:'EmpresasCreate',
                        path: 'create',
                        meta: { title: 'Nueva Empresa' },
                        component: () => import(/* webpackChunkName: "EmpresasCreate"*/  '../views/configuracion/Empresas/EmpresasForm.vue')
                    },
                    {
                        name:'EmpresasEditar',
                        path: 'editar/:id',
                        meta: { title: 'Editar Empresa -' },
                        component: () => import(/* webpackChunkName: "EmpresasEditar"*/  '../views/configuracion/Empresas/EmpresasForm.vue')
                    }
                ]

            },
            {
                name: 'Cecos',
                path: 'cecos',
                component: () => import( /* webpackChunkName: "Configuracion" */ '../views/configuracion/Configuacion.vue'),
                children: [
                    {
                        name:'CecosIndex',
                        path: 'all',
                        meta: { title: 'Cecos' },
                        component: () => import(/* webpackChunkName: "Cecos"*/  '../views/configuracion/Cecos/CecosIndex.vue')
                    },
                    {
                        name:'CecosCreate',
                        path: 'create',
                        meta: { title: 'Nueva Ceco' },
                        component: () => import(/* webpackChunkName: "CecosCreate"*/  '../views/configuracion/Cecos/CecosForm.vue')
                    },
                    {
                        name:'CecosEditar',
                        path: 'editar/:id',
                        meta: { title: 'Editar Ceco -' },
                        component: () => import(/* webpackChunkName: "CecosEditar"*/  '../views/configuracion/Cecos/CecosForm.vue')
                    }
                ]

            },
        ]
    }
];