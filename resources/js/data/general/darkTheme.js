import Alpine from 'alpinejs'

Alpine.data('darkTheme', () => ({
    darkMode: localStorage.getItem('theme') === null
        ? window.matchMedia('(prefers-color-scheme: dark)').matches
        : localStorage.getItem('theme') === 'dark',

    toggle() {
        this.darkMode = !this.darkMode
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light')
    },
}))