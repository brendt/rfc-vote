import Alpine from 'alpinejs'

Alpine.data('darkTheme', () => ({
    darkMode: null,

    /**
     * @param {'dark'|'light'|'system'} theme
     */
    toggle(theme) {
        if (theme === 'system') {
            this.darkMode = null
            localStorage.removeItem('theme')
            return
        }

        this.darkMode = !this.darkMode
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light')
    },

    init() {
        this._setCurrentMode()
    },

    _setCurrentMode() {
        const selectedTheme = localStorage.getItem('theme')

        if (selectedTheme) {
            this.darkMode = selectedTheme === 'dark'
            return
        }

        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)')

        this.darkMode = systemTheme.matches

        systemTheme.addEventListener('change', ({ matches }) => {
            this.darkMode = matches
        })
    },
}))