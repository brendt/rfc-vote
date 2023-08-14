<div class="z-50" {{$attributes}}>
    <div wire:ignore>
                <textarea id="argument-editor" x-init="
                editor = new EasyMDE({
                    element: document.getElementById('argument-editor'),
                    forceSync:true,
                    renderingConfig:{codeSyntaxHighlighting:true},
                    previewClass:['editor-preview', 'prose', 'prose-code:text-[color:var(--tw-prose-code)]'  , 'w-full', 'max-w-full']
                });
                editor.codemirror.on('change', () => {
                 $dispatch('input', editor.value());
                });
                " {{$attributes}}></textarea>
    </div>
</div>
