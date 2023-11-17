import store from '~/store'

export default (to, from, next, roles) => {
  const user = store.getters['auth/user']

  roles = roles.split(',')

  if (!roles.includes(user.role)) {
    next('/unauthorized')
  }

  next()
}
