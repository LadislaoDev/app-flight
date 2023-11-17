import Vue from 'vue'
import { library, config } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {
  faUser, faLock, faSignOutAlt, faCog, faTrash, faSearch, faPlusCircle, faUserPlus, faCheckCircle, faTimesCircle
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub
} from '@fortawesome/free-brands-svg-icons'

config.autoAddCss = false

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faTrash, faSearch, faPlusCircle, faUserPlus, faCheckCircle, faTimesCircle
)

Vue.component('Fa', FontAwesomeIcon)
