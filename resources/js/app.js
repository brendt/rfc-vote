import './bootstrap'

import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'
import Clipboard from '@ryangjchandler/alpine-clipboard'
import hljs from 'highlight.js/lib/core'
import php from 'highlight.js/lib/languages/php'
import tippy from 'tippy.js'
import './data/profile/avatarSettings'

hljs.registerLanguage('php', php)
hljs.highlightAll()
Alpine.plugin(Clipboard)
window.Alpine = Alpine

Alpine.plugin(focus)

Alpine.start()

tippy('[data-tippy-content]')