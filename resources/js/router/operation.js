const operation = [
    {
		name: 'Operation',
		path: '/operacion',
		meta: { title: 'Operación' },
		component:  () => import(/* webpackChunkName: "Operacion" */ '../views/operacion/Operacion.vue'),
        children: [
            {
                name: 'EmpresasIndex',
                path: 'empresas',
                meta: { title: 'Empresas' },
                component: () => import(/* webpackChunkName: "EmpresasIndex" */ '../views/operacion/empresas/EmpresasIndex.vue')
            },
            {
                name: 'EmpresaCreate',
                path: 'crear-empresa',
                meta: { title: 'Crear Nueva Empresa' },
                component: () => import(/* webpackChunkName: "CreateEmpresa" */ '../views/operacion/empresas/CreateEmpresa.vue')
            },
            {
                name: 'EmpresaObraCreate',
                path: 'crear-obra',
                meta: { title: 'Crear Obra' },
                component: () => import(/* webpackChunkName: "CreateEmpresaObra" */ '../views/operacion/empresas/CreateEmpresaObra.vue')
            },
            {
                name: 'EmpresaEditar',
                meta: { title: 'Editar', requireAuth: true },
                path: 'empresas/editar/:id',
                component: () => import(/* webpackChunkName: "EditarEmpresa" */ '../views/operacion/empresas/EditarEmpresa.vue')
            },
        ]
	},
]