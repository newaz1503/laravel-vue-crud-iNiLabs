const routes = [
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: () => import('../views/admin/DashboardComponent.vue')
    },
     //Student route
     {
        path: '/admin/student',
        name: 'student',
        component: () => import('../views/admin/student/Index.vue')
    }
  ]

  export default routes;
