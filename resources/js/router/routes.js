function page(path) {
    return () =>
        import ( /* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
    { path: '/', name: 'welcome', component: page('welcome.vue') },

    { path: '/login', name: 'login', component: page('auth/login.vue') },
    { path: '/register', name: 'register', component: page('auth/register.vue') },
    { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
    { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
    { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
    { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

    {
        path: '/dashboard',
        name: 'dashboard',
        component: page('dashboard/dashboard.vue'),
        children: [
            { path: '', redirect: { name: 'dashboard.code' } },
            { path: 'index', name: 'dashboard.index', component: page('dashboard/index.vue') },
            { path: 'code', name: 'dashboard.code', component: page('dashboard/code/index.vue') },
            { path: 'user', name: 'dashboard.user', component: page('dashboard/user/index.vue') },
            { path: 'category', name: 'dashboard.category', component: page('dashboard/category/index.vue') },
            { path: 'customer', name: 'dashboard.customer', component: page('dashboard/customer/index.vue') },
            { path: 'specificities', name: 'dashboard.specificities', component: page('dashboard/category/specificities.vue') },
            { path: 'price', name: 'dashboard.price', component: page('dashboard/category/price.vue') },
            { path: 'unit', name: 'dashboard.unit', component: page('dashboard/category/unit.vue') },
            { path: 'employee', name: 'dashboard.employee', component: page('dashboard/Employee/index.vue') },
            { path: 'input', name: 'dashboard.input', component: page('dashboard/Receipt/input.vue') },
            { path: 'inputlist', name: 'dashboard.inputlist', component: page('dashboard/Receipt/index.vue') },
            { path: 'export', name: 'dashboard.export', component: page('dashboard/Export/export.vue') },
            { path: 'exportlist', name: 'dashboard.exportlist', component: page('dashboard/Export/index.vue') },
            { path: 'thanhtoantam', name: 'dashboard.thanhtoantam', component: page('dashboard/Payment/Customerpays_tam.vue') },
            { path: 'thanhtoanvau', name: 'dashboard.thanhtoanvau', component: page('dashboard/Payment/Customerpays_vau.vue') },
            { path: 'thanhtoanluong', name: 'dashboard.thanhtoanluong', component: page('dashboard/Payment/Employeepays.vue') },

        ]
    },
    {
        path: '/settings',
        component: page('settings/index.vue'),
        children: [
            { path: '', redirect: { name: 'settings.profile' } },
            { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
            { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
        ]
    },

    { path: '*', component: page('errors/404.vue') }
]