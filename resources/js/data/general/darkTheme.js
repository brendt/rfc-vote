import Alpine from 'alpinejs'

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
            localStorage.removeItem('theme')
            return
        }

        this.darkMode = theme === 'dark'
        this.switchType = this.darkMode ? 'dark' : 'light'

        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light')
    },

    init() {
        this._setCurrentMode()
    },

    _setCurrentMode() {
        const selectedTheme = localStorage.getItem('theme')

        if (selectedTheme) {
            this.darkMode = selectedTheme === 'dark'
            this.switchType = selectedTheme
            return
        }

        const prefersDark = this._prefersDarkSystemTheme()

        this.darkMode = prefersDark.matches
        this.switchType = 'system'

        prefersDark.addEventListener('change', ({ matches }) => {
            this.darkMode = matches
        })
    },

    _prefersDarkSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)')
    }
}))