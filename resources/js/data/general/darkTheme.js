import Alpine from 'alpinejs'
import Cookies from 'js-cookie'

Alpine.data('darkTheme', () => ({
    darkMode: null,
    switchType: 'system', // 'light', 'dark', 'system'

    /**
     * @param {'dark'|'light'|'system'} theme
     */
    toggle(theme) {
        if (theme === 'system') {
            this.darkMode = this._prefersDarkSystemTheme().matches
            this.switchType = 'system'
            this._setThemeCookieTo(this.darkMode ? 'system-dark' : 'system-light')
            return
        }

        this.darkMode = theme === 'dark'
        this.switchType = this.darkMode ? 'dark' : 'light'

        this._setThemeCookieTo(this.darkMode ? 'dark' : 'light')
    },

    init() {
        this._setCurrentMode()
    },

    _setCurrentMode() {
        const selectedTheme = Cookies.get('theme')

        if (!selectedTheme) {
            return
        }

        const hasSystemTheme = selectedTheme.includes('system-')

        if (!hasSystemTheme) {
            this.switchType = selectedTheme
            this.darkMode = selectedTheme === 'dark'
            return
        }

        const prefersDark = this._prefersDarkSystemTheme()

        this.switchType = 'system'
        this.darkMode = prefersDark.matches

        prefersDark.addEventListener('change', ({ matches }) => {
            this.darkMode = matches
            this._setThemeCookieTo(matches ? 'system-dark' : 'system-light')
        })
    },

    _setThemeCookieTo(value) {
        Cookies.set('theme', value, { expires: 365 })
    },

    _prefersDarkSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)')
    },
}))
