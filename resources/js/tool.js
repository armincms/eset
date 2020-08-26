Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'eset',
      path: '/eset',
      component: require('./components/Tool'),
    },
  ])
})
