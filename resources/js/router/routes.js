function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') },
      { path: 'big_project_list', name: 'settings.big_project_list', component: page('settings/big_project_list.vue') },
      { path: 'big_project_create', name: 'settings.big_project_create', component: page('settings/big_project_create.vue') },
      { path: 'big_project_update/:id', name: 'settings.big_project_update', component: page('settings/big_project_update.vue') },
      { path: 'project_list', name: 'settings.project_list', component: page('settings/project_list.vue') },
      { path: 'project_create', name: 'settings.project_create', component: page('settings/project_create.vue') },
      { path: 'project_update/:id', name: 'settings.project_update', component: page('settings/project_update.vue') },
      { path: 'project_info_list', name: 'settings.project_info_list', component: page('settings/project_info_list.vue') },
      { path: 'project_info_create/:big_id?/:product_id?', name: 'settings.project_info_create', component: page('settings/project_info_create.vue') },
      { path: 'project_info_update/:id', name: 'settings.project_info_update', component: page('settings/project_info_update.vue') },
      { path: 'project_size_list', name: 'settings.project_size_list', component: page('settings/project_size_list.vue') },
      { path: 'project_size_create', name: 'settings.project_size_create', component: page('settings/project_size_create.vue') },
      { path: 'project_size_update/:id', name: 'settings.project_size_update', component: page('settings/project_size_update.vue') },
      { path: 'project_style_list', name: 'settings.project_style_list', component: page('settings/project_style_list.vue') },
      { path: 'project_style_create', name: 'settings.project_style_create', component: page('settings/project_style_create.vue') },
      { path: 'project_style_update/:id', name: 'settings.project_style_update', component: page('settings/project_style_update.vue') }
    ] },

  { path: '*', component: page('errors/404.vue') }
]
