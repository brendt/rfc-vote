import './bootstrap'

import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'
import Clipboard from '@ryangjchandler/alpine-clipboard'


Alpine.plugin(Clipboard)
window.Alpine = Alpine


Alpine.plugin( focus )

Alpine.start()
