<div class="markdown-editor z-50">
    <div wire:ignore>
        <textarea id="argument-editor" x-init="
            editor = new EasyMDE({
                element: $el,
                forceSync:true,
                renderingConfig:{codeSyntaxHighlighting:true},
                previewClass:['editor-preview', 'prose', 'prose-code:text-[color:var(--tw-prose-code)]'  , 'w-full', 'max-w-full'],
                status: false
            });
            editor.codemirror.on('change', () => {
                $dispatch('input', editor.value());
            });
        " {{$attributes}} class="bg-black"></textarea>
    </div>
</div>
