const routes = [
  {
    path: '/',
    component: () => import('../layouts/DefaultLayout.vue'),
    children: [
      {
        name: 'pages.postal_codes.all',
        path: '', component: () => import('../pages/PostalCodesList.vue'),
      },
      {
        name: 'pages.postal_codes.get',
        path: '/postal-codes/:code', component: () => import('../pages/PostalCodeView.vue'),
      },
    ]
  },

  {
    path: '/:catchAll(.*)*',
    component: () => import('../pages/Error404.vue')
  }
];

export default routes;
