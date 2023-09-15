import Alpine from 'alpinejs'

Alpine.data('avatarSettings', () => ({
    _defaultAreaMessage: '<b>Choose a file</b> or drag it here',
    _dragMessage: 'Drop your file <b>here</b>',
    _defaultAvatar: '',
    avatarChanged: false,
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
            this._updateAvatar()
        },
    },

    onFileChange(event) {
        if (!event.target.files || event.target.files.length === 0) {
            return
        }

        const file = event.target.files[0]
        this._updateAvatarPreview(file)
    },

    init() {
        this._defaultAvatar = this.$el.querySelector('img').dataset.src
        this.avatar = this._defaultAvatar
        this.areaMessage = this._defaultAreaMessage
    },

    _updateAvatar() {
        const items = this.$event.dataTransfer.items

        if (!items) {
            return
        }

        Array.from(items).forEach(item => {
            if (item.kind === 'file') {
                const file = item.getAsFile()
                this._updateAvatarPreview(file)

                const dataTransfer = new DataTransfer()
                dataTransfer.items.add(file)
                this.$refs.fileInp.files = dataTransfer.files
            }
        })
    },

    _updateAvatarPreview(file) {
        this.avatar = URL.createObjectURL(file)
        this.avatarChanged = true
    },
}))