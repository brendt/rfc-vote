import Alpine from 'alpinejs'

Alpine.data('avatarSettings', () => ({
    _defaultAreaMessage: '<b>Choose a file</b> or drag it here',
    _dragMessage: '<b>Drag and drop</b> your file here',
    _defaultAvatar: '',
    areaMessage: '',
    avatar: '',

    area: {
        ['@dragover.prevent']() {
            this.areaMessage = this._dragMessage
        },
        ['@dragleave']() {
            this.areaMessage = this._defaultAreaMessage
        },
        ['@drop.prevent']() {
            this.updateAvatar()
        },
    },

    updateAvatar() {
        const items = this.$event.dataTransfer.items

        if (!items) {
            return
        }

        Array.from(items).forEach(item => {
            if (item.kind === 'file') {
                const file = item.getAsFile()
                this.avatar = URL.createObjectURL(file)

                const dataTransfer = new DataTransfer()
                dataTransfer.items.add(file)
                document.getElementById('avatar-field').files = dataTransfer.files
            }
        })
    },

    init() {
        this._defaultAvatar = this.$el.querySelector('img').dataset.src
        this.avatar = this._defaultAvatar
        this.areaMessage = this._defaultAreaMessage
    }
}))