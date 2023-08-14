import './bootstrap';
import EasyMDE from 'easymde'
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();

const easyMDE = new EasyMDE({element: document.querySelector('.markdown-editor')});
